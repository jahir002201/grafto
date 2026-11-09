<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
    /*
    |--------------------------------------------------------------------------
    | DIRECT PLANT CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkout(Request $request, Plant $plant)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $user = auth('api')->user();
        $quantity = (int) $validated['quantity'];

        return DB::transaction(function () use ($user, $plant, $quantity) {

            $plant = Plant::whereKey($plant->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($quantity > $plant->stock) {
                throw ValidationException::withMessages([
                    'quantity' => 'Insufficient plant stock.',
                ]);
            }

            $unitPrice = (float) $plant->price;

            $subtotal = round($unitPrice * $quantity, 2);

            $deliveryCharge = (float) config(
                'services.delivery_charge',
                80
            );

            $total = round($subtotal + $deliveryCharge, 2);

            if ($total < 10) {
                throw ValidationException::withMessages([
                    'payment' => 'Minimum payment amount is ৳10.',
                ]);
            }

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

            $payment = Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'amount' => $total,
                'status' => Payment::PENDING,
                'transaction_id' => (string) Str::uuid(),
            ]);

            return $this->initializePayment(
                $payment,
                $user,
                $plant->name
            );
        });
    }


    /*
    |--------------------------------------------------------------------------
    | CART CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function checkoutCart(Request $request)
    {
        $user = auth('api')->user();

        return DB::transaction(function () use ($user) {

            $cart = Cart::where('user_id', $user->id)
                ->with('cartItems.plant')
                ->lockForUpdate()
                ->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.',
                ], 422);
            }

            $subtotal = 0;
            $items = [];

            foreach ($cart->cartItems as $cartItem) {

                $plant = Plant::whereKey($cartItem->plant_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($plant->stock < $cartItem->quantity) {
                    throw ValidationException::withMessages([
                        'stock' => $plant->name .
                            ' has insufficient stock.',
                    ]);
                }

                $price = (float) $plant->price;

                $itemTotal = round(
                    $price * $cartItem->quantity,
                    2
                );

                $subtotal += $itemTotal;

                $items[] = [
                    'plant_id' => $plant->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $price,
                    'total_price' => $itemTotal,
                ];
            }

            $deliveryCharge = (float) config(
                'services.delivery_charge',
                80
            );

            $total = round($subtotal + $deliveryCharge, 2);

            if ($total < 10) {
                throw ValidationException::withMessages([
                    'payment' => 'Minimum payment amount is ৳10.',
                ]);
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => Order::NOT_PAID,
                'shipping_address' => $user->address ?: 'Not provided',
                'shipping_phone' => $user->phone ?: 'Not provided',
                'shipping_name' => $user->name,
            ]);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'plant_id' => $item['plant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['total_price'],
                ]);
            }

            // Create payment
            $payment = Payment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'amount' => $total,
                'status' => Payment::PENDING,
                'transaction_id' => (string) Str::uuid(),
            ]);

            $productNames = $cart->cartItems
                ->map(fn ($item) => $item->plant->name)
                ->implode(', ');

            return $this->initializePayment(
                $payment,
                $user,
                $productNames
            );
        });
    }


    /*
    |--------------------------------------------------------------------------
    | INITIALIZE SSLCOMMERZ PAYMENT
    |--------------------------------------------------------------------------
    */

    private function initializePayment(
        Payment $payment,
        $user,
        string $productName
    ) {
        $baseUrl = config('services.sslcommerz.sandbox')
            ? 'https://sandbox.sslcommerz.com'
            : 'https://securepay.sslcommerz.com';

        try {

            $response = Http::asForm()
                ->timeout(30)
                ->post($baseUrl . '/gwprocess/v4/api.php', [

                    'store_id' => config('services.sslcommerz.store_id'),

                    'store_passwd' => config(
                        'services.sslcommerz.store_password'
                    ),

                    'total_amount' => number_format(
                        (float) $payment->amount,
                        2,
                        '.',
                        ''
                    ),

                    'currency' => 'BDT',

                    'tran_id' => $payment->transaction_id,

                    'product_category' => 'Nursery Plants',

                    'product_name' => Str::limit($productName, 200),

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
                !$response->successful()
                || empty($result['GatewayPageURL'])
            ) {
                $payment->update([
                    'status' => Payment::FAILED,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Unable to initialize payment.',
                    'gateway_response' => $result,
                ], 502);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment initialized successfully.',
                'data' => [
                    'order_id' => $payment->order_id,
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                    'gateway_url' => $result['GatewayPageURL'],
                ],
            ], 201);

        } catch (\Throwable $e) {

            $payment->update([
                'status' => Payment::FAILED,
            ]);

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Payment gateway connection failed.',
            ], 502);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER PAYMENT DETAILS
    |--------------------------------------------------------------------------
    */

    public function show(Order $order)
    {
        if ($order->user_id !== auth('api')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized payment access.',
            ], 403);
        }

        $payment = $order->payment;

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN: ALL PAYMENTS
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        $payments = Payment::with([
            'user',
            'order.orderItems.plant',
        ])->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN: PAYMENT DETAILS
    |--------------------------------------------------------------------------
    */

    public function adminShow(Payment $payment)
    {
        $payment->load([
            'user',
            'order.orderItems.plant',
        ]);

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }
}
