<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Sales by Sales Person</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! asset('assets/templates/bootstrap-3/style.css') !!}" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style> 
</head>
<body class="login-page" style="background: white">
   <div>
      <div class="row">
         <div class="col-xs-12">
            <h3 class="text-center">Sales by Sales Person</h3>
            <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
         </div>
      </div>
      <table class="table table-bordered">
         <thead>
            <tr>  
               <th>Name</th>  
               <th><center>Invoice count</center></th>  
               <th><center>Total sales</center></th> 
            </tr>
         </thead> 
         <tbody> 
            @foreach($sales as $sale)
               <tr>
                  <td><a href="#">{!! $sale->salesperson !!}</a></td>
                  <td><center>{!! Finance::count_invoice_salesperson($sale->salespersonID) !!}</center></td>
                  <td><center><b>{!! number_format($sale->total) !!} {!! $sale->code !!}</b></center></td>
               </tr>
            @endforeach
            @foreach($others as $other)
               <tr>
                  <td>Other</td>
                  <td><center>{!! $otherCounts !!}</center></td>
                  <td><center><b>{!! number_format($other->total) !!} {!! $other->code !!}</b></center></td>
               </tr>
            @endforeach
            <tr>
               <td><b>Total</b></td>
               <td><center>{!! $totalCount !!}</center></td>
               <td><center><b>{!!  number_format($total->sum('total')) !!} {!! Wingu::currency()->code !!}</b></center></td>
            </tr>
         </tbody>
      </table>
   </div>
</body>
</html>