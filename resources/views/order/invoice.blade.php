<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Invoice</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .font{
      font-size: 15px;
    }
    .authority {
        /*text-align: center;*/
        float: right
    }
    .authority h5 {
        margin-top: -10px;
        color: green;
        /*text-align: center;*/
        margin-left: 35px;
    }
    .thanks p {
        color: green;;
        font-size: 16px;
        font-weight: normal;
        font-family: serif;
        margin-top: 20px;
    }
</style>

</head>
<body>

  <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
    <tr>
        <td valign="top">
          {{-- <img src="" alt="" width="150"/> --}}<br>
          <h2 style="color: green; font-size: 26px;"><strong>{{config('app.name')}}</strong></h2>
        </td>
        
        <td align="right">
            <pre class="font">
               {{config('app.name')}} Head Office
               hello@t-inventory.com
               +8801757461006
               Dhaka 1207,Dhanmondi:#4
               Dhaka ,Bangladesh
            </pre>
        </td>
    </tr>
  </table>
  <table width="100%" style="background:white; padding:2px;""></table>
  <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
    <tr>
        <td>
          <p class="font" style="margin-left: 20px; line-height: 1.5">
           <strong>CUSTOMER DETAILS :</strong><br>
            {{ $order->customer->name }} <br>
            {{ $order->customer->phone }} <br>
            {{ $order->customer->email }} <br>
            {{ $order->customer->address }}
         </p>
        </td>
        <td>
          <p class="font" style="margin-left: 20px; line-height: 1.5">
            <strong>ORDER DETAILS: </strong><br>
            Order Id: #{{ $order->id }}<br>
            Order Date: {{ $order->order_date }}<br>
            Order Quantity: {{ $order->qty }}<br>
            Pay by: {{ $order->payby }}
         </p>
        </td>
    </tr>
  </table>
<h3>Products</h3>
  <table width="100%">
    <thead style="background-color: green; color:#FFFFFF;">
      <tr class="font">
        <th>Product Name</th>
        <th>Code</th>
        <th>Unit Price </th>
        <th>Quantity</th>
        <th>Line Total</th>
      </tr>
    </thead>
    <tbody>
     @foreach ($orderItems as $item)
     <tr class="font">
        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->product_name }}</td>
        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->product->code }}</td>
        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->product_price }}Tk</td>
        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->product_qty }}</td>
        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->sub_total }}Tk</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <br>
  <table width="100%" style=" padding:0 10px 0 10px;">
    <tr>
        <td align="left">
            <h1 style="text-align: center; color: #E9E8E2; transform: rotate(-50deg);">{{config('app.name')}}</h1>
        </td>
        
        <td align="right" >
            <h2><span style="color: green;">Sub Total : </span> {{$order->sub_total}} Tk</h2>
            <h2><span style="color: green;">Vat : </span> {{$order->vat}}%</h2>
            <h2 class="row"><span style="color: green;">Grand Total:</span> {{ $order->total }}Tk</h2>
            @if($order->due)
            <h2><span style="color: green;">Pay Amount : </span> {{ $order->pay }}Tk</h2>
            <h2><span style="color: green;">Due Amount : </span> {{ $order->due }}Tk</h2>
            @else
            <h2><span style="color: green; padding: 5px; border: 1px solid; width: 60%; background: #F7F7F7;">Full Payment PAID</h2>
            @endif
        </td>
    </tr>
  </table>
  <div class="thanks mt-3">
      <br>
    <p>Thanks For Buying Products..!!</p>
  </div>
  <div class="authority float-right mt-5">
      <p>-----------------------------------</p>
      <h5>Authority Signature:</h5>
    </div>
  <br><br></br><br>
  <h1 style="text-align: center; color: #E9E8E2; transform: rotate(-50deg); margin-top: -300px; overflow:hidden;">{{config('app.name')}}</h1>
</body>
</html>