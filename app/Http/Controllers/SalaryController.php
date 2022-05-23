<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use Carbon\Carbon;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salary_year =Salary::select('salary_year')->groupBy('salary_year')->get();
        
        $salaries = Salary::with('employee')->latest()->get();
        return response()->json([ $salaries, $salary_year]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $employee_id)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salary = Salary::with('employee')->where('id',$id)->first();
        return response()->json($salary);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $salary_id)
    {
        Salary::findOrFail($salary_id)->update([
            'salary_month' => $request->salary_month,
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($salary_id)
    {
        Salary::findOrFail($salary_id)->delete();
    }
}
