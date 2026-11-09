<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    // GET: Customer Order History
    public function index()
    {
        $orders = Order::where('user_id', auth('api')->id())
            ->with(['orderItems.plant', 'payment'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Orders fetched successfully.',
            'data' => $orders,
        ]);
    }

    // GET: Customer Single Order
    public function show(Order $order)
    {
        if ($order->user_id !== auth('api')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this order.',
            ], 403);
        }

        $order->load([
            'orderItems.plant',
            'payment',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order details fetched successfully.',
            'data' => $order,
        ]);
    }

    // GET: Admin All Orders
    public function adminIndex(Request $request)
    {
        $query = Order::with([
            'user',
            'orderItems.plant',
            'payment',
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'All orders fetched successfully.',
            'data' => $orders,
        ]);
    }

    // GET: Admin Single Order
    public function adminShow(Order $order)
    {
        $order->load([
            'user',
            'orderItems.plant',
            'payment',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order details fetched successfully.',
            'data' => $order,
        ]);
    }

    // PUT: Admin Update Order Status
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(Order::STATUS_CHOICES),
            ],
        ]);

        // Do not allow an unpaid order to be shipped or delivered.
        if (
            $order->status === Order::NOT_PAID &&
            in_array($validated['status'], [
                Order::READY_TO_SHIP,
                Order::SHIPPED,
                Order::DELIVERED,
            ], true)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'An unpaid order cannot be shipped or delivered.',
            ], 422);
        }

        $order->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully.',
            'data' => $order->fresh(),
        ]);
    }
}
