<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use App\Models\Salary;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function todayReport(){
        $today = date('d/m/Y');
        $todayExpenseTotal = Expense::where('expense_date', $today)->sum('amount');
        $todayExpenses = Expense::where('expense_date', $today)->get();
        $todaySell = Order::where('order_date', $today)->sum('total');
        $todayErnings = Order::where('order_date', $today)->sum('profit');
        return response()->json([$todayExpenseTotal, $todayExpenses, $todaySell, $todayErnings]);
    }

    public function reportYears(){
        $order_years =Order::select('order_year')->groupBy('order_year')->get();
        return response()->json($order_years);
    }

    public function reportByDate($date){
        $ExpenseTotalByDate = Expense::whereDate('created_at', $date)->sum('amount');
        $SellByDate = Order::whereDate('created_at', $date)->sum('total');
        $ErningsByDate = Order::whereDate('created_at', $date)->sum('profit');
        $reportDate = date('d F Y', strtotime($date));
        return response()->json([$ExpenseTotalByDate, $SellByDate, $ErningsByDate, $reportDate]);
    }

    public function reportByMonth($month){
        $ExpenseTotalByMonth = Expense::where('expense_month', $month)->sum('amount');
        $SalaryTotalByMonth = Salary::where('salary_month', $month)->sum('amount');
        $SellByMonth = Order::where('order_month', $month)->sum('total');
        $ErningsByMonth = Order::where('order_month', $month)->sum('profit');
        return response()->json([$ExpenseTotalByMonth, $SalaryTotalByMonth, $SellByMonth, $ErningsByMonth]);
    }

    public function reportByYear($year){
        $ExpenseTotalByYear = Expense::where('expense_year', $year)->sum('amount');
        $SalaryTotalByYear = Salary::where('salary_year', $year)->sum('amount');
        $SellByYear = Order::where('order_year', $year)->sum('total');
        $ErningsByYear = Order::where('order_year', $year)->sum('profit');
        return response()->json([$ExpenseTotalByYear, $SalaryTotalByYear, $SellByYear, $ErningsByYear]);
    }

    public function reportByMonthYear($month, $year){
        $ExpenseTotalByMonthYear = Expense::where('expense_month', $month)->where('expense_year', $year)->sum('amount');
        $SalaryTotalByMonthYear = Salary::where('salary_month', $month)->where('salary_year', $year)->sum('amount');
        $SellByMonthYear = Order::where('order_month', $month)->where('order_year', $year)->sum('total');
        $ErningsByMonthYear = Order::where('order_month', $month)->where('order_year', $year)->sum('profit');
        return response()->json([$ExpenseTotalByMonthYear, $SalaryTotalByMonthYear, $SellByMonthYear, $ErningsByMonthYear]);
    }

    //================= PDF Report ================================//
    public function todayReportPDF(){
        $today = date('d/m/Y');
        $todayExpenseTotal = Expense::where('expense_date', $today)->sum('amount');
        $todayExpenses = Expense::where('expense_date', $today)->get();
        $todaySell = Order::where('order_date', $today)->sum('total');
        $todayErnings = Order::where('order_date', $today)->sum('profit');
        $profitAfterExpense = ($todayErnings - $todayExpenseTotal);

        $pdf = PDF::setPaper('landscape')->loadView('report.todayreport', compact('profitAfterExpense', 'todayExpenseTotal', 'todayExpenses', 'todaySell', 'todayErnings'));
        return $pdf->stream('Today_Report.pdf');
    
    }

    public function reportByDatePDF($date){
        $ExpenseTotalByDate = Expense::whereDate('created_at', $date)->sum('amount');
        $ExpensesByDate = Expense::whereDate('created_at', $date)->get();
        $SellByDate = Order::whereDate('created_at', $date)->sum('total');
        $ErningsByDate = Order::whereDate('created_at', $date)->sum('profit');
        $profitAfterExpense = ($ErningsByDate - $ExpenseTotalByDate);
        $reportDate = date('d F Y', strtotime($date));

        $pdf = PDF::setPaper('landscape')->loadView('report.reportbydate', compact('reportDate', 'profitAfterExpense', 'ExpenseTotalByDate', 'ExpensesByDate', 'SellByDate', 'ErningsByDate'));
        return $pdf->stream('Report_By_Date.pdf');
    
    }

    public function reportByMonthPDF($month){
        $ExpenseTotalByMonth = Expense::where('expense_month', $month)->sum('amount');
        $ExpensesByMonth = Expense::where('expense_month', $month)->get();
        $SalaryTotalByMonth = Salary::where('salary_month', $month)->sum('amount');
        $SalariesByMonth = Salary::with('employee')->where('salary_month', $month)->get();
        $SellByMonth = Order::where('order_month', $month)->sum('total');
        $ErningsByMonth = Order::where('order_month', $month)->sum('profit');
        $profitAfterExpense = ($ErningsByMonth - $ExpenseTotalByMonth - $SalaryTotalByMonth);
        $reportMonth = $month;

        $pdf = PDF::setPaper('landscape')->loadView('report.reportbymonth', compact('SalaryTotalByMonth','SalariesByMonth', 'reportMonth', 'profitAfterExpense', 'ExpenseTotalByMonth', 'ExpensesByMonth', 'SellByMonth', 'ErningsByMonth'));
        return $pdf->stream('Report_By_Month.pdf');
    
    }

    public function reportByMonthYearPDF($month, $year){
        $ExpenseTotalByMonth = Expense::where('expense_month', $month)->where('expense_year', $year)->sum('amount');
        $ExpensesByMonth = Expense::where('expense_month', $month)->where('expense_year', $year)->get();
        $SalaryTotalByMonth = Salary::where('salary_month', $month)->where('salary_year', $year)->sum('amount');
        $SalariesByMonth = Salary::with('employee')->where('salary_month', $month)->where('salary_year', $year)->get();
        $SellByMonth = Order::where('order_month', $month)->where('order_year', $year)->sum('total');
        $ErningsByMonth = Order::where('order_month', $month)->where('order_year', $year)->sum('profit');
        $profitAfterExpense = ($ErningsByMonth - $ExpenseTotalByMonth - $SalaryTotalByMonth);
        $reportMonth = $month .' '. $year;

        $pdf = PDF::setPaper('landscape')->loadView('report.reportbymonth', compact('SalaryTotalByMonth','SalariesByMonth', 'reportMonth', 'profitAfterExpense', 'ExpenseTotalByMonth', 'ExpensesByMonth', 'SellByMonth', 'ErningsByMonth'));
        return $pdf->stream('Report_By_Month_Year.pdf');
    
    }
    
    public function reportByYearPDF($year){
        $ExpenseTotalByMonth = Expense::where('expense_year', $year)->sum('amount');
        $ExpensesByMonth = Expense::where('expense_year', $year)->get();
        $SalaryTotalByMonth = Salary::where('salary_year', $year)->sum('amount');
        $SalariesByMonth = Salary::with('employee')->where('salary_year', $year)->get();
        $SellByMonth = Order::where('order_year', $year)->sum('total');
        $ErningsByMonth = Order::where('order_year', $year)->sum('profit');
        $profitAfterExpense = ($ErningsByMonth - $ExpenseTotalByMonth - $SalaryTotalByMonth);
        $reportMonth = $year;

        $pdf = PDF::setPaper('landscape')->loadView('report.reportbymonth', compact('SalaryTotalByMonth','SalariesByMonth', 'reportMonth', 'profitAfterExpense', 'ExpenseTotalByMonth', 'ExpensesByMonth', 'SellByMonth', 'ErningsByMonth'));
        return $pdf->stream('Report_By_Year.pdf');
    
    }



}
