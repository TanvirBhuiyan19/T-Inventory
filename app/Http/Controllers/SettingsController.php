<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(){
        $id = 1;
        $settings = Setting::findOrFail($id);
        return response()->json($settings);
    }


    public function create(Request $request){
        $id=1;
        if(Setting::exists()){
            Setting::findOrFail($id)->update([
                'vat' => $request->vat,
            ]);
        }else{
            Setting::insert([
                'vat' => $request->vat,
            ]);
        }
        
    }



}
