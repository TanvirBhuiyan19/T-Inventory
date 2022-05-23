<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::latest()->get();
        return response()->json($expenses);
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
            'details' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'max:10'],
        ]);

        Expense::insert([
            'details' => $request->details,
            'amount' => $request->amount,
            'expense_month' => date('F'),
            'expense_year' => date('Y'),
            'expense_date' => date('d/m/Y'),
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($expense_id)
    {
        $expense = Expense::findOrFail($expense_id);
        return response()->json($expense);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$expense_id)
    {
        $request->validate([
            'details' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'max:10'],
            'expense_date' => ['required', 'string', 'max:255'],
        ]);

        Expense::findOrFail($expense_id)->update([
            'details' => $request->details,
            'amount' => $request->amount,
            'expense_date' => date('d-m-Y'),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($expense_id)
    {
        Expense::findOrFail($expense_id)->delete();
    }
}
