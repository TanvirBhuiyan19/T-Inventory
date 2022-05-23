<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
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
            'name' => ['required', 'unique:employees', 'string', 'max:255'],
            'email' => ['required', 'unique:employees', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'string', 'max:255'],
            'joining_date' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'unique:employees', 'max:255'],

        ]);

        if($request->photo){

                //Get Photo Extension + Random Name Generate
                $photo = $request->photo;
                $position = strpos($photo, ';');
                $sub = substr($photo, 0, $position);
                $ext = explode('/', $sub)[1];
                $imageName = $request->name .'_' .time(). '.' .$ext;
                //Image Resize with Intervention
                Image::make($photo)->resize(300, 300)->save('backend/uploads/employee/'.$imageName);

                Employee::insert([
                    'name' => $request->name,
                    'email' => strtolower($request->email),
                    'address' => $request->address,
                    'salary' => $request->salary,
                    'joining_date' => $request->joining_date,
                    'nid' => $request->nid,
                    'phone' => $request->phone,
                    'photo' => $imageName,
                    'created_at' => Carbon::now(),
                ]);

        }else{

            Employee::insert([
                'name' => $request->name,
                'email' => strtolower($request->email),
                'address' => $request->address,
                'salary' => $request->salary,
                'joining_date' => $request->joining_date,
                'nid' => $request->nid,
                'phone' => $request->phone,
                'photo' => 'default.jpg',
                'created_at' => Carbon::now(),
            ]);

        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        return response()->json($employee);

    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee_id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'string', 'max:255'],
            'joining_date' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:255'],
        ]);

        if($request->photo != $request->oldPhoto){

                if($request->oldPhoto != 'default.jpg'){
                    //Remove Old Photo
                    $directory = 'backend/uploads/employee/';
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
                Image::make($photo)->resize(300, 300)->save('backend/uploads/employee/'.$imageName);

                Employee::findOrFail($employee_id)->update([
                    'name' => $request->name,
                    'email' => strtolower($request->email),
                    'address' => $request->address,
                    'salary' => $request->salary,
                    'joining_date' => $request->joining_date,
                    'nid' => $request->nid,
                    'phone' => $request->phone,
                    'photo' => $imageName,
                    'updated_at' => Carbon::now(),
                ]);

        }else{

            Employee::findOrFail($employee_id)->update([
                'name' => $request->name,
                'email' => strtolower($request->email),
                'address' => $request->address,
                'salary' => $request->salary,
                'joining_date' => $request->joining_date,
                'nid' => $request->nid,
                'phone' => $request->phone,
                'updated_at' => Carbon::now(),
            ]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($employee_id)
    {
        $image_name = Employee::findOrFail($employee_id)->photo;
        if($image_name == 'default.jpg'){
            Employee::findOrFail($employee_id)->delete();
        }else{
            $directory = 'backend/uploads/employee/';
            unlink($directory . $image_name);
            Employee::findOrFail($employee_id)->delete();
        }

    }

    // ===================== Admin Info ===========================//
    public function userInfo($userId){
        $userInfo = User::findOrFail($userId);
        return response()->json($userInfo);
    }

    
}
