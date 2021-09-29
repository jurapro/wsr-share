<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Product $product)
    {
        if (Auth::user()->role->code!=='user') {
            throw new ApiException(403,'Forbidden for you');
        }

        Cart::create([
            'user_id'=>Auth::id(),
            'product_id'=>$product->id
        ]);

        return response()->json([
            'data'=>[
                'message'=>'Product add to card'
            ]
        ])->setStatusCode(201);
    }
}
