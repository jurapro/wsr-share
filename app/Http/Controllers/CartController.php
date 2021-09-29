<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Resources\CartResourse;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Product $product)
    {
        Auth::user()->isUser();

        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id
        ]);

        return response()->json([
            'data' => [
                'message' => 'Product add to card'
            ]
        ])->setStatusCode(201);
    }

    public function remove(Cart $cart)
    {
        Auth::user()->isUser();
        $cart->delete();
        return [
            'data' => [
                'message' => 'Item removed from cart'
            ]
        ];
    }

    public function index()
    {
        Auth::user()->isUser();
        return CartResourse::collection(Auth::user()->cart);
    }
}
