<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('supplier', 'category')->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['unique:products', 'max:255'],
            'quantity' => ['required', 'max:255'],
            'category_id' => ['required', 'max:255'],
            'supplier_id' => ['required', 'max:255'],
            'buying_price' => ['required', 'max:255'],
            'selling_price' => ['required', 'max:255'],
            'buying_date' => ['required', 'max:255'],

        ]);

        if($request->photo){

                //Get Photo Extension + Random Name Generate
                $photo = $request->photo;
                $position = strpos($photo, ';');
                $sub = substr($photo, 0, $position);
                $ext = explode('/', $sub)[1];
                $imageName = $request->name .'_' .time(). '.' .$ext;
                //Image Resize with Intervention
                Image::make($photo)->resize(300, 300)->save('backend/uploads/product/'.$imageName);

                Product::insert([
                    'name' => $request->name,
                    'code' => $request->code,
                    'root' => $request->root,
                    'category_id' => $request->category_id,
                    'supplier_id' => $request->supplier_id,
                    'quantity' => $request->quantity,
                    'buying_price' => $request->buying_price,
                    'selling_price' => $request->selling_price,
                    'buying_date' => $request->buying_date,
                    'photo' => $imageName,
                    'created_at' => Carbon::now(),
                ]);

        }else{

            Product::insert([
                'name' => $request->name,
                'code' => $request->code,
                'root' => $request->root,
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'quantity' => $request->quantity,
                'buying_price' => $request->buying_price,
                'selling_price' => $request->selling_price,
                'buying_date' => $request->buying_date,
                'photo' => 'default.jpg',
                'created_at' => Carbon::now(),
            ]);

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        $product = Product::findOrFail($product_id);
        return response()->json($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'max:255'],
            'category_id' => ['required', 'max:255'],
            'supplier_id' => ['required', 'max:255'],
            'buying_price' => ['required', 'max:255'],
            'selling_price' => ['required', 'max:255'],
            'buying_date' => ['required', 'max:255'],

        ]);

        if($request->photo != $request->oldPhoto){

            if($request->oldPhoto != 'default.jpg'){
                //Remove Old Photo
                $directory = 'backend/uploads/product/';
                $oldImage = $request->oldPhoto;
                unlink($directory . $oldImage);
            }

            //Get Photo Extension + Random Name Generate
            $photo = $request->photo;
            $position = strpos($photo, ';');
            $sub = substr($photo, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = $request->name .'_' .time(). '.' .$ext;
            //Image Resize with Intervention
            Image::make($photo)->resize(300, 300)->save('backend/uploads/product/'.$imageName);

            Product::findOrFail($product_id)->update([
                'name' => $request->name,
                'code' => $request->code,
                'root' => $request->root,
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'quantity' => $request->quantity,
                'buying_price' => $request->buying_price,
                'selling_price' => $request->selling_price,
                'buying_date' => $request->buying_date,
                'photo' => $imageName,
                'updated_at' => Carbon::now(),
            ]);

    }else{

        Product::findOrFail($product_id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'root' => $request->root,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'buying_date' => $request->buying_date,
            'updated_at' => Carbon::now(),
        ]);

    }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $image_name = Product::findOrFail($product_id)->photo;
        if($image_name == 'default.jpg'){
            Product::findOrFail($product_id)->delete();
        }else{
            $directory = 'backend/uploads/product/';
            unlink($directory . $image_name);
            Product::findOrFail($product_id)->delete();
        }
    }

    //Stock Update
    public function stockUpdate(Request $request, $product_id){
        $request->validate([
            'quantity' => ['required', 'max:255'],

        ]);
        Product::findOrFail($product_id)->update([
            'quantity' => $request->quantity,
            'updated_at' => Carbon::now(),
        ]);
    }


}
