<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use App\Mail\orderMail;
use PDF;
//use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Expense;

class PosController extends Controller
{
    
    public function categoryProduct($category_id){
        $categoryProduct = Product::where('category_id' , $category_id)->get();
        return response()->json($categoryProduct);
    }



    public function orderDone(Request $request){

        $request->validate([
            'customer_id' => 'required',
            'pay' => 'required',
            'payby' => 'required',
          ]);


        //Order Table data insert + get order id ==============//
        $order_id = Order::insertGetId([
            'customer_id' => $request->customer_id,
            'qty' => $request->qty,
            'sub_total' => $request->sub_total,
            'vat' => $request->vat,
            'total' => $request->total,
            'payby' => $request->payby,
            'pay' => $request->pay,
            'due' => $request->due,
            'profit' => $request->profit,
            'order_date' => date('d/m/Y'),
            'order_month' => date('F'),
            'order_year' => date('Y'),
            'created_at' => Carbon::now(),
        ]);


        //Order Item Table data insert ================//
        $carts = Cart::all();
        foreach ($carts as $cart ) {
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart->product_id,
                'product_name' => $cart->product_name,
                'product_qty' => $cart->product_qty,
                'product_price' => $cart->product_price,
                'sub_total' => $cart->sub_total,
                'created_at' => Carbon::now(),
            ]);

            Product::where('id', $cart->product_id)->decrement('quantity',$cart->product_qty);
        }

        //====== Delete Cart ======================//
        Cart::truncate();

        
        //======== Start Order Mail ========================================//
        $order = Order::where('id', $order_id)->first();
        $customer = Customer::findOrFail($request->customer_id);
        if($customer->email){
            $data = [
                'customer_name' => $customer->name,
                'appName' =>config('app.name'),
                'phone' =>$customer->phone,
                'order_id' => $order->id,
                'order_date' => $order->order_date,
                'order_year' => $order->order_year,
                'sub_total' => $order->sub_total,
                'vat' => $order->vat,
                'total' => $order->total,
                'pay' => $order->pay,
                'due' => $order->due,
                'payby' => $order->payby,
                ];
            Mail::to($customer->email)->send(new orderMail($data));
        }
        
        //======== End: Order Mail ==========================================//

    }


    //===================== Download Order Invoice ================================  //      
    public function invoiceDownload($order_id) {
        $order = Order::with('customer')->where('id', $order_id)->first();
        $orderItems = OrderItem::with('product')->where('order_id', $order_id)->get();
        //return view( 'order.invoice', compact('order','orderItems', 'customer') );
        
        $pdf = PDF::setPaper('landscape')->loadView('order.invoice', compact('order','orderItems'));
        return $pdf->download('Invoice.pdf');
    }

    //===================== View Order Invoice ================================  //      
    public function invoiceView($order_id) {
        $order = Order::with('customer')->where('id', $order_id)->first();
        $orderItems = OrderItem::with('product')->where('order_id', $order_id)->get();
        
        $pdf = PDF::setPaper('landscape')->loadView('order.invoice', compact('order','orderItems'));
        return $pdf->stream('Invoice.pdf');
    }


    //===================== Today All Data ================================  //      
    public function todayData() {
        $today = date('d/m/Y');
        $todaySell = Order::where('order_date', $today)->sum('total');
        $todayErnings = Order::where('order_date', $today)->sum('profit');
        $todayDue = Order::where('order_date', $today)->sum('due');
        $todayExpense = Expense::where('expense_date', $today)->sum('amount');
        return response()->json([$todaySell, $todayErnings, $todayDue, $todayExpense]);
    }

    //===================== This Month All Data ================================  //  
    public function thisMonthData() {
        $firstDayOfThisMonth = date('01/m/Y');
        $today = date('d/m/Y');
        $thisMonthSell = Order::whereBetween('order_date', [$firstDayOfThisMonth, $today])->sum('total');
        $thisMonthErnings = Order::whereBetween('order_date', [$firstDayOfThisMonth, $today])->sum('profit');
        $thisMonthDue = Order::whereBetween('order_date', [$firstDayOfThisMonth, $today])->sum('due');
        $thisMonthExpense = Expense::whereBetween('expense_date', [$firstDayOfThisMonth, $today])->sum('amount');
        return response()->json([$thisMonthSell, $thisMonthErnings, $thisMonthDue, $thisMonthExpense]);
    }

    //===================== All-Time All Data ================================  //  
    public function allTimeData() {
        $allTimeSell = Order::all()->sum('total');
        $allTimeErnings = Order::all()->sum('profit');
        $allTimeDue = Order::all()->sum('due');
        $allTimeExpense = Expense::all()->sum('amount');
        return response()->json([$allTimeSell, $allTimeErnings, $allTimeDue, $allTimeExpense]);
    }

    //===================== Stock Out Products ================================  //  
    public function stockOut(){
        $stockOutProducts = Product::with('supplier', 'category')->where('quantity', '<=', 0)->get();
        return response()->json($stockOutProducts);
    }

//===================== All-Time All Data ================================  //  
public function payBy() {
    $totalTaka = Order::all()->sum('total');
    $amountInOnePercent = $totalTaka/100;
    $HandCashe = Order::where('payby', 'HandCash')->sum('total');
    $HandCash = round($HandCashe/$amountInOnePercent );
    $Cheaquee = Order::where('payby', 'Cheaque')->sum('total');
    $Cheaque = round($Cheaquee/$amountInOnePercent );
    $GiftCarde = Order::where('payby', 'GiftCard')->sum('total');
    $GiftCard = round($GiftCarde/$amountInOnePercent );
    return response()->json([$HandCash, $Cheaque, $GiftCard]);
}





}
