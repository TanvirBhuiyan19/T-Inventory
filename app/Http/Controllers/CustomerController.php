<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
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
            'name' => ['required', 'unique:customers', 'string', 'max:255'],
            'email' => ['unique:customers', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'unique:customers', 'max:255'],

        ]);

        if($request->photo){

                //Get Photo Extension + Random Name Generate
                $photo = $request->photo;
                $position = strpos($photo, ';');
                $sub = substr($photo, 0, $position);
                $ext = explode('/', $sub)[1];
                $imageName = $request->name .'_' .time(). '.' .$ext;
                //Image Resize with Intervention
                Image::make($photo)->resize(300, 300)->save('backend/uploads/customer/'.$imageName);

                Customer::insert([
                    'name' => $request->name,
                    'email' => strtolower($request->email),
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'photo' => $imageName,
                    'created_at' => Carbon::now(),
                ]);

        }else{

            Customer::insert([
                'name' => $request->name,
                'email' => strtolower($request->email),
                'address' => $request->address,
                'phone' => $request->phone,
                'photo' => 'default.jpg',
                'created_at' => Carbon::now(),
            ]);

        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        return response()->json($customer);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customer_id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:255'],
        ]);

        if($request->photo != $request->oldPhoto){

                if($request->oldPhoto != 'default.jpg'){
                    //Remove Old Photo
                    $directory = 'backend/uploads/customer/';
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
                Image::make($photo)->resize(300, 300)->save('backend/uploads/customer/'.$imageName);

                Customer::findOrFail($customer_id)->update([
                    'name' => $request->name,
                    'email' => strtolower($request->email),
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'photo' => $imageName,
                    'updated_at' => Carbon::now(),
                ]);

        }else{

            Customer::findOrFail($customer_id)->update([
                'name' => $request->name,
                'email' => strtolower($request->email),
                'address' => $request->address,
                'phone' => $request->phone,
                'updated_at' => Carbon::now(),
            ]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($customer_id)
    {
        $image_name = Customer::findOrFail($customer_id)->photo;
        if($image_name == 'default.jpg'){
            Customer::findOrFail($customer_id)->delete();
        }else{
            $directory = 'backend/uploads/customer/';
            unlink($directory . $image_name);
            Customer::findOrFail($customer_id)->delete();
        }

    }



}
