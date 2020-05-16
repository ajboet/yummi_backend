<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Start an order / Start a shopping cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function startOrder(Request $request, Product $product)
    {
        // Get quantity from request or default it to one (1) if not present
        $quantity = $request->quantity ?: 1;

        // Check if a cart exists and have items
        if (cart()->isEmpty()) {
            // Create a new cart
            $cart = Product::addToCart($product->id, $quantity);
        } else {
            // Add product to existing cart
            cart()->add($product, $quantity);
        }

        return response()->json(cart()->toArray(), 200);
    }

    /**
     * Retrieve Cart Totals and Items
     *
     * @return json
     */
    public function retrieveCart()
    {
        return response()->json(cart()->toArray(), 200);
    }

    /**
     * Clear Cart
     *
     * @return json
     */
    public function clearCart()
    {
        cart()->clear();
        return response()->json(['message' => 'Successfully deleted shopping cart.'], 200);
    }

    /**
     * Increment cart item quantity
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function incrementCartItem(Request $request)
    {
        $request->validate([
            'cartItemIndex' => 'required|numeric|integer',
        ]);

        return cart()->incrementQuantityAt($request->cartItemIndex);
    }

    /**
     * Decrement cart item quantity
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function decrementCartItem(Request $request)
    {
        $request->validate([
            'cartItemIndex' => 'required|numeric|integer',
        ]);

        return cart()->decrementQuantityAt($request->cartItemIndex);
    }

    /**
     * Remove from cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'cartItemIndex' => 'required|numeric|integer',
        ]);

        return cart()->removeAt($request->cartItemIndex);
    }
}
