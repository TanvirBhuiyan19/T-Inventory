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
  
<h3 align="center">Report of {{ $reportDate }}</h3><hr style="align-content: center; width: 50%; margin-top:-20px;">
        
  <h2 align="center" style="color: darkorange">Expenses this Day</h2>
        <table width="100%">
            <thead style="background-color: green; color:#FFFFFF;">
                <tr class="text-center">
                    <th>Details</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @if( count($ExpensesByDate) == 0)
                    <tr class="font">
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;" colspan="2">
                            <h1>No Expense Found!</h1><br/><br/>
                        </td>
                    </tr>
                @else
                    @foreach ($ExpensesByDate as $item)
                    <tr class="font">
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->details }}</td>
                        <td align="center" style="border-bottom: 1px solid;padding-bottom: 5px;">{{ $item->amount }}Tk</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <br>
        <table width="100%" style=" padding:0 10px 0 10px;">
          <tr>
              <td align="left">
                  <h1 style="text-align: center; color: #E9E8E2; transform: rotate(-50deg);">{{config('app.name')}}</h1>
              </td>
              
              <td align="right" >
                  <h2><span>Total Sell : </span> {{$SellByDate}} Tk</h2>
                  <h2><span>Total Profit : </span> {{$ErningsByDate}} Tk</h2>
                  <h2><span>Total Expense : </span> {{$ExpenseTotalByDate}} Tk</h2>
                  @if($profitAfterExpense > 0)
                  <h2 class="row" style="color: green; padding:5px; border:1px solid"><span>Profit after Expense:</span> {{ $profitAfterExpense }} Tk</h2>
                  @else
                  <h2 class="row" style="color: red; padding:5px; border:1px solid"><span>Profit after Expense :</span> {{ $profitAfterExpense }} Tk</h2>
                  @endif
              </td>
          </tr>
        </table>



    <small align="center">
        <span>COPYRIGHT  &copy; {{ date('Y') }} <a style="text-decoration: none;" href="#">{{config('app.name')}} </a><span>, All rights Reserved</span></span>
    </small>
  <h1 style="text-align: center; color: #E9E8E2; transform: rotate(-50deg); opacity: 0.5; margin-top: -200px; overflow:hidden;">{{config('app.name')}}</h1>
</body>
</html>