<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function checkout(Request $request, Plant $plant)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $data['quantity'];

        if ($quantity > $plant->stock) {
            throw ValidationException::withMessages([
                'quantity' => 'The requested quantity is not available.',
            ]);
        }

        $user = $request->user();

        $unitPrice = (float) $plant->price;
        $subtotal = round($unitPrice * $quantity, 2);
        $deliveryCharge = (float) config('services.delivery_charge', 80);
        $total = round($subtotal + $deliveryCharge, 2);

        if ($total < 10) {
            return back()->withErrors([
                'payment' => 'The payment total must be at least ৳10.',
            ]);
        }

        // Create a pending order before contacting the gateway.
        [$order, $payment, $transactionId] = DB::transaction(
            function () use ($user, $plant, $quantity, $unitPrice, $subtotal, $total) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $total,
                    'status' => Order::NOT_PAID,
                    'shipping_address' => $user->address ?: 'Not provided',
                    'shipping_phone' => $user->phone ?: 'Not provided',
                    'shipping_name' => $user->name,
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'plant_id' => $plant->id,
                    'quantity' => $quantity,
                    'price' => $unitPrice,
                    'total_price' => $subtotal,
                ]);

                $transactionId = (string) Str::uuid();

                $payment = Payment::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'amount' => $total,
                    'status' => Payment::PENDING,
                    'transaction_id' => $transactionId,
                ]);

                return [$order, $payment, $transactionId];
            }
        );

        $baseUrl = config('services.sslcommerz.sandbox')
            ? 'https://sandbox.sslcommerz.com'
            : 'https://securepay.sslcommerz.com';

        $response = Http::asForm()
            ->timeout(30)
            ->post($baseUrl . '/gwprocess/v4/api.php', [
                'store_id' => config('services.sslcommerz.store_id'),
                'store_passwd' => config('services.sslcommerz.store_password'),
                'total_amount' => number_format($total, 2, '.', ''),
                'currency' => 'BDT',
                'tran_id' => $transactionId,
                'product_category' => 'Nursery Plants',
                'product_name' => $plant->name,
                'product_profile' => 'general',
                'shipping_method' => 'NO',
                'cus_name' => $user->name,
                'cus_email' => $user->email,
                'cus_add1' => $user->address ?: 'Not provided',
                'cus_city' => 'Dhaka',
                'cus_country' => 'Bangladesh',
                'cus_phone' => $user->phone ?: '01700000000',
                'success_url' => route('payment.success'),
                'fail_url' => route('payment.fail'),
                'cancel_url' => route('payment.cancel'),
                'ipn_url' => route('payment.ipn'),
            ]);

        $result = $response->json();

        if (
            ! $response->successful()
            || empty($result['GatewayPageURL'])
        ) {
            $payment->update(['status' => Payment::FAILED]);

            return redirect()
                ->route('home')
                ->with('error', 'Unable to start payment. Please try again.');
        }

        return redirect()->away($result['GatewayPageURL']);
    }

    public function success(Request $request)
    {
        return $this->validateAndFinishPayment($request);
    }

    public function ipn(Request $request)
    {
        return $this->validateAndFinishPayment($request);
    }

    public function fail(Request $request)
    {
        $this->markUnsuccessful($request, Payment::FAILED);

        return redirect()->route('home')
            ->with('error', 'Payment failed. Please try again.');
    }

    public function cancel(Request $request)
    {
        $this->markUnsuccessful($request, Payment::FAILED);

        return redirect()->route('home')
            ->with('error', 'Payment was cancelled.');
    }

    private function validateAndFinishPayment(Request $request)
    {
        $valId = $request->input('val_id');
        $transactionId = $request->input('tran_id');

        if (! $valId || ! $transactionId) {
            return response('Missing payment validation details.', 400);
        }

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (! $payment) {
            return response('Payment not found.', 404);
        }

        // Do not trust the callback alone. Validate with SSLCOMMERZ.
        $baseUrl = config('services.sslcommerz.sandbox')
            ? 'https://sandbox.sslcommerz.com'
            : 'https://securepay.sslcommerz.com';

        $validation = Http::timeout(30)->get(
            $baseUrl . '/validator/api/validationserverAPI.php',
            [
                'val_id' => $valId,
                'store_id' => config('services.sslcommerz.store_id'),
                'store_passwd' => config('services.sslcommerz.store_password'),
                'format' => 'json',
            ]
        );

        $result = $validation->json();

        if (
            ! $validation->successful()
            || ($result['status'] ?? '') !== 'VALID'
            || ($result['tran_id'] ?? '') !== $payment->transaction_id
            || ! is_numeric($result['amount'] ?? null)
            || abs((float) $result['amount'] - (float) $payment->amount) > 0.01
            || ($result['currency'] ?? '') !== 'BDT'
        ) {
            return response('Payment could not be verified.', 422);
        }

        DB::transaction(function () use ($payment) {
            $lockedPayment = Payment::whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Make repeated success callbacks safe.
            if ($lockedPayment->status === Payment::SUCCESS) {
                return;
            }

            $lockedPayment->update(['status' => Payment::SUCCESS]);

            $order = Order::whereKey($lockedPayment->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            $order->update(['status' => Order::READY_TO_SHIP]);

            // Decrease stock only after verified payment.
            foreach ($order->items as $item) {
                $plant = Plant::whereKey($item->plant_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($plant->stock < $item->quantity) {
                    // Payment is valid, but stock needs manual resolution.
                    // Do not silently oversell.
                    throw ValidationException::withMessages([
                        'stock' => 'Payment succeeded, but stock needs review.',
                    ]);
                }

                $plant->decrement('stock', $item->quantity);
            }
        });

        if ($request->routeIs('payment.ipn')) {
            return response('OK', 200);
        }

        return redirect()->route('home')
            ->with('success', 'Payment successful! Your order has been placed.');
    }

    private function markUnsuccessful(Request $request, string $status): void
    {
        $transactionId = $request->input('tran_id');

        if (! $transactionId) {
            return;
        }

        $payment = Payment::where('transaction_id', $transactionId)->first();

        if ($payment && $payment->status === Payment::PENDING) {
            $payment->update(['status' => $status]);
        }
    }
}