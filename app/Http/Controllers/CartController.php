<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index(){
        $allCart = Cart::all();
        return response()->json($allCart);
    }

    public function store($product_id){
        $product = Product::findOrFail($product_id);
        $check = Cart::where('product_id', $product_id)->first();

        if($check && $product->quantity > $check->product_qty){
            Cart::findOrFail($check->id)->increment('product_qty');
            $cart = Cart::where('product_id', $product_id)->first();
            $subTotal = $cart->product_qty * $cart->product_price;
            $subTotalBuying = $cart->product_qty * $cart->buying_price;
            $profit = $subTotal - $subTotalBuying;
            Cart::findOrFail($cart->id)->update([
                'sub_total' => $subTotal,
                'profit' => $profit,
            ]);

        }elseif($product->quantity != 0 && !$check){
            $profit = $product->selling_price - $product->buying_price;
            Cart::insert([
                'product_id' => $product_id,
                'product_name' => $product->name,
                'product_qty' => 1,
                'product_price' => $product->selling_price,
                'buying_price' => $product->buying_price,
                'sub_total' => $product->selling_price ,
                'profit' => $profit,
            ]);
        }else{
            return Response::json(500);
        }
        
    }

    public function increment($id)
    {
        $carto = Cart::findOrFail($id);
        $product = Product::where('id', $carto->product_id)->first();
        if($product->quantity > $carto->product_qty){
            Cart::findOrFail($id)->increment('product_qty');
            $cart = Cart::findOrFail($id);
            $subTotal = $cart->product_qty * $cart->product_price;
            $subTotalBuying = $cart->product_qty * $cart->buying_price;
            $profit = $subTotal - $subTotalBuying;
            Cart::findOrFail($cart->id)->update([
                'sub_total' => $subTotal,
                'profit' => $profit,
            ]);
        }else{
            return Response::json(500);
        }
        
    }

    public function decrement($id)
    {
        $product_qty = Cart::findOrFail($id);
        if($product_qty->product_qty > 1){
            Cart::findOrFail($id)->decrement('product_qty');
            $cart = Cart::findOrFail($id);
            $subTotal = $cart->product_qty * $cart->product_price;
            $subTotalBuying = $cart->product_qty * $cart->buying_price;
            $profit = $subTotal - $subTotalBuying;
            Cart::findOrFail($cart->id)->update([
                'sub_total' => $subTotal,
                'profit' => $profit,
            ]);

        }else{
            return Response::json(500);
        }
        
    }

    public function destroy($id)
    {
        Cart::findOrFail($id)->delete();
    }



}
