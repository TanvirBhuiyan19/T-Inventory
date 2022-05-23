<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('customer')->latest()->get();
        $order_year =Order::select('order_year')->groupBy('order_year')->get();
        $order_month =Order::select('order_month')->groupBy('order_month')->get();
        return response()->json([$orders, $order_month, $order_year]);
    }


    public function todayOrders(){
        $orders = Order::with('customer')->whereDate('created_at', Carbon::today())->latest()->get();
        return response()->json($orders);
    }


    public function orderDetail($order_id){
        $order = Order::with('customer')->findOrFail($order_id);
        return response()->json($order);
    }

    public function orderdetails($order_id){
        $details = OrderItem::with('product')->where('order_id', $order_id)->get();
        return response()->json($details);
    }

    public function orderDelete($order_id){
        Order::findOrFail($order_id)->delete();
    }


    public function todayOrdersPDF(){
        $orders = Order::with('customer')->whereDate('created_at', Carbon::today())->latest()->get();
        
        $pdf = PDF::setPaper('landscape')->loadView('order.todayorders', compact('orders'));
        return $pdf->stream('Today_Orders.pdf');
    }


    public function orderByDatePDF($date){
            $order = Order::whereDate('created_at', $date)->first();
            $orderdate = $order->order_date;

            $orders = Order::with('customer')->whereDate('created_at', $date)->get();
            $pdf = PDF::setPaper('landscape')->loadView('order.orderbydate', compact('orders', 'orderdate'));
            return $pdf->stream('Order_Search_By_Date.pdf');
        
    }


    public function orderByMonthPDF($month){
        $orders = Order::with('customer')->where('order_month', $month)->latest()->get();
        $month = $month;
        
        $pdf = PDF::setPaper('landscape')->loadView('order.orderbymonth', compact('orders', 'month'));
        return $pdf->stream('Order_Search_By_Month.pdf');
    }


    public function orderByYearPDF($year){
        $orders = Order::with('customer')->where('order_year', $year)->latest()->get();
        $year = $year;
        
        $pdf = PDF::setPaper('landscape')->loadView('order.orderbyyear', compact('orders', 'year'));
        return $pdf->stream('Order_Search_By_Year.pdf');
    }


    public function orderByMonthYearPDF($month, $year){
        $orders = Order::with('customer')->where('order_month', $month)->where('order_year', $year)->latest()->get();
        $month = $month;
        $year = $year;
        
        $pdf = PDF::setPaper('landscape')->loadView('order.orderbymonthyear', compact('orders', 'month', 'year'));
        return $pdf->stream('Order_Search_By_Month_and_Year.pdf');
    }









}
