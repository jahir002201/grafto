<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // GET: Customer Cart
    public function index()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth('api')->id(),
        ]);

        $cart->load('cartItems.plant');

        return response()->json([
            'success' => true,
            'message' => 'Cart fetched successfully.',
            'data' => $cart,
        ]);
    }

    // POST: Add Plant to Cart
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plant_id' => 'required|exists:plants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {

            $plant = Plant::whereKey($validated['plant_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $cart = Cart::firstOrCreate([
                'user_id' => auth('api')->id(),
            ]);

            $cartItem = $cart->cartItems()
                ->where('plant_id', $plant->id)
                ->first();

            $newQuantity = ($cartItem?->quantity ?? 0)
                + $validated['quantity'];

            if ($newQuantity > $plant->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient plant stock.',
                    'available_stock' => $plant->stock,
                ], 422);
            }

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $newQuantity,
                ]);
            } else {
                $cartItem = $cart->cartItems()->create([
                    'plant_id' => $plant->id,
                    'quantity' => $validated['quantity'],
                ]);
            }

            $cartItem->load('plant');

            return response()->json([
                'success' => true,
                'message' => 'Plant added to cart successfully.',
                'data' => $cartItem,
            ], 201);
        });
    }

    // PUT: Update Cart Item
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->cart->user_id !== auth('api')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized cart item access.',
            ], 403);
        }

        return DB::transaction(function () use ($cartItem, $validated) {

            $plant = Plant::whereKey($cartItem->plant_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($validated['quantity'] > $plant->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient plant stock.',
                    'available_stock' => $plant->stock,
                ], 422);
            }

            $cartItem->update([
                'quantity' => $validated['quantity'],
            ]);

            $cartItem->load('plant');

            return response()->json([
                'success' => true,
                'message' => 'Cart quantity updated successfully.',
                'data' => $cartItem,
            ]);
        });
    }

    // DELETE: Remove Cart Item
    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth('api')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized cart item access.',
            ], 403);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart item removed successfully.',
        ]);
    }

    // DELETE: Clear Cart
    public function clear()
    {
        $cart = Cart::where('user_id', auth('api')->id())
            ->first();

        if ($cart) {
            $cart->cartItems()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully.',
        ]);
    }
}
