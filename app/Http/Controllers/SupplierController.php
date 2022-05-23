<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
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
            'name' => ['required', 'unique:suppliers', 'string', 'max:255'],
            'email' => ['required', 'unique:suppliers', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'unique:suppliers', 'max:255'],
        ]);

        if($request->photo){

                //Get Photo Extension + Random Name Generate
                $photo = $request->photo;
                $position = strpos($photo, ';');
                $sub = substr($photo, 0, $position);
                $ext = explode('/', $sub)[1];
                $imageName = $request->name .'_' .time(). '.' .$ext;
                //Image Resize with Intervention
                Image::make($photo)->resize(300, 300)->save('backend/uploads/supplier/'.$imageName);

                Supplier::insert([
                    'name' => $request->name,
                    'email' => strtolower($request->email),
                    'address' => $request->address,
                    'shop_name' => $request->shop_name,
                    'phone' => $request->phone,
                    'photo' => $imageName,
                    'created_at' => Carbon::now(),
                ]);

        }else{

            Supplier::insert([
                'name' => $request->name,
                'email' => strtolower($request->email),
                'address' => $request->address,
                'shop_name' => $request->shop_name,
                'phone' => $request->phone,
                'photo' => 'default.jpg',
                'created_at' => Carbon::now(),
            ]);

        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);
        return response()->json($supplier);

    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $supplier_id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:255'],
        ]);

        if($request->photo != $request->oldPhoto){

                if($request->oldPhoto != 'default.jpg'){
                    //Remove Old Photo
                    $directory = 'backend/uploads/supplier/';
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
                Image::make($photo)->resize(300, 300)->save('backend/uploads/supplier/'.$imageName);

                Supplier::findOrFail($supplier_id)->update([
                    'name' => $request->name,
                    'email' => strtolower($request->email),
                    'address' => $request->address,
                    'shop_name' => $request->shop_name,
                    'phone' => $request->phone,
                    'photo' => $imageName,
                    'updated_at' => Carbon::now(),
                ]);

        }else{

            Supplier::findOrFail($supplier_id)->update([
                'name' => $request->name,
                'email' => strtolower($request->email),
                'address' => $request->address,
                'shop_name' => $request->shop_name,
                'phone' => $request->phone,
                'updated_at' => Carbon::now(),
            ]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($supplier_id)
    {
        $image_name = Supplier::findOrFail($supplier_id)->photo;
        if($image_name == 'default.jpg'){
            Supplier::findOrFail($supplier_id)->delete();
        }else{
            $directory = 'backend/uploads/supplier/';
            unlink($directory . $image_name);
            Supplier::findOrFail($supplier_id)->delete();
        }

    }
}
