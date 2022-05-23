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
  
<h3 align="center">Orders List of {{$orderdate}}</h3>
        <table width="100%">
            <thead style="background-color: green; color:#FFFFFF;">
                <tr class="text-center">
                    <th># Id</th>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Pay</th>
                    <th>Due</th>
                    <th>PayBy</th>
                </tr>
            </thead>
            <tbody>
                @if( count($orders) == 0)

                    <tr class="font">
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;" colspan="7">
                            <h1>No data found!</h1><br/><br/>
                        </td>
                    </tr>
                @else
                    @foreach ($orders as $item)
                    <tr class="font">
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->id }}</td>
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->order_date }}</td>
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->customer->name }}</td>
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->qty }}</td>
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->total }}Tk</td>
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->pay }}Tk</td>
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->due }}Tk</td>
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->payby }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
  <br><br>
    <small align="center">
        <span>COPYRIGHT  &copy; {{ date('Y') }} <a style="text-decoration: none;" href="#">{{config('app.name')}} </a><span>, All rights Reserved</span></span>
    </small>
  <h1 style="text-align: center; color: #E9E8E2; transform: rotate(-50deg); opacity: 0.5; margin-top: -120px; overflow:hidden;">{{config('app.name')}}</h1>
</body>
</html>