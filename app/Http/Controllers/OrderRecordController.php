<?php

namespace App\Http\Controllers;

use App\OrderRecord;
use App\OrderRecordItem;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderRecordController extends Controller
{
    /**
     * Display a listing of User's Order Record.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $user = auth('sanctum')->user();
        // Fetch all User's Order Record from DB
        $order_record = OrderRecord::where('user_id', $user->id)->get();
        if ($order_record->count() > 0) {
            return response()->json($order_record, 200);
        }
        // No Record in DB
        return response()->json(['message' => 'You don\'t have any Orders in your record',], 404);
    }

    /**
     * Store User's Order Record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request)
    {
        // Check if a cart is empty
        if (cart()->isEmpty()) {
            $request['cart'] = '';
            $request->validate([
                'cart' => 'filled'//Custom field to throw 422 error
            ],
            [
                'filled' => 'Nothing to Order'//Custom error message
            ]);
        }

        $user = auth('sanctum')->user();
        $is_guest = False;
        $check1 = explode('_', $user->email)[0];
        $check2 = explode('@', $user->email);
        if ($check1 == 'guest' && array_pop($check2) == 'mail.com') {
            $is_guest = True;// It's a Guest User
        }
        // If User is Guest, request registration info
        if ($is_guest) {
            $request->validate([
                'name' => 'required|string|min:3',
                'email' => 'required|string|email|unique:users',
                'password' => 'sometimes|string|confirmed',
                'cellphone_number' => 'required|unique:users',
                'full_address' => 'required|string',
                'currency_iso_code' => 'required_with:currency_rate|string|size:3',
                'currency_rate' => 'required_with:currency_iso_code|numeric'
            ]);
        }

        DB::beginTransaction(); // Disable autocommit
        try {
            $user->fill($request->except(['password', 'currency_iso_code', 'currency_rate']));
            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
            }
            if($user->isDirty()){
                $user->update();
            }

            // Convert Cart data into snake_case
            $cart = [];
            foreach (cart()->data() as $key => $value) {
                $cart[Str::snake($key)] = $value;
            }

            // Store the Order Record
            $order = new OrderRecord();
            $order->fill($cart);
            $order->user_id = $user->id;
            
            if ($request->has('currency_iso_code')) {
                $order->currency_iso_code =  mb_strtoupper($request->currency_iso_code);
            }
            if ($request->has('currency_rate')) {
                $order->currency_rate = $request->currency_rate;
            }
            $order->save();

            // Store the Order Record Items
            foreach (cart()->items() as $key => $item) {
                $order_item = new OrderRecordItem();
                $order_item->order_record_id = $order->id;
                $order_item->product_id = $item['modelId'];
                $order_item->price = $item['price'];
                $order_item->quantity = $item['quantity'];
                $order_item->save();
            }

            // If no errors occurred, commit DB changes and send a success response
            DB::commit();

            // Delete the Cart
            cart()->clear();

            return response()->json(['message' => 'Successfully confirmed order.'], 200);
        } catch (\Exception $e) {
            // An error has occurred, rollback DB changes and inform the error
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
}
