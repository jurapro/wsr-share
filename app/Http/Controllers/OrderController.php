<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function add()
    {
        $order = Order::create([
            'user_id' => Auth::id()
        ]);

        foreach (Auth::user()->cart as $cart) {
            Item::create([
                'order_id' => $order->id,
                'product_id' => $cart->product->id,
                'price' => $cart->product->price
            ]);
            $cart->delete();
        }

        return [
            'data' => [
                'order_id' => $order->id,
                'message' => 'Order ib prosessed'
            ]
        ];
    }

    public function index()
    {
        Auth::user()->isUser();
        return OrderResource::collection(Auth::user()->orders);
    }
}
