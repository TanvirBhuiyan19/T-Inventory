<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Salary;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(){
    	$salary_year =Salary::select('salary_year')->groupBy('salary_year')->get();
        
        $salaries = Salary::with('employee')->latest()->get();
        return response()->json([ $salaries, $salary_year]);
    }

    public function store(Request $request, $employee_id){
        $request->validate([
            'salary_month' => ['required', 'string', 'max:255'],
        ]);
        
    	$check=Salary::where('employee_id',$employee_id)->where('salary_month',$request->salary_month)->first();
        if($check){
            return response()->json('Salary Already Given!');
        }else{
            Salary::insert([
                'employee_id' => $employee_id, 
                'amount' => $request->salary,
                'salary_month' => $request->salary_month,
                'salary_date' => date('d/m/Y'),
                'salary_year' => date('Y'),
                'created_at' => Carbon::now(),
            ]);
        }

    }

    public function edit($id){
        $salary = Salary::with('employee')->where('id',$id)->first();
        return response()->json($salary);
    }

    public function update(Request $request, $salary_id){
        Salary::findOrFail($salary_id)->update([
            'salary_month' => $request->salary_month,
            'updated_at' => Carbon::now(),
        ]);
    }

    public function delete($salary_id){
        Salary::findOrFail($salary_id)->delete();
    }



}
