<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Sales by Customer</title>

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
            <h3 class="text-center">Sales by Customer</h3>
            <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
         </div>
      </div>
      <table class="table table-bordered">
         <thead>
            <tr>  
               <th>Name</th>  
               <th><center>Invoice Count</center></th>  
               <th align="right"><center>Sales</center></th>  
            </tr>
         </thead> 
         <tbody> 
            @foreach($sales as $sale)
               <tr>
                  <td>{!! $sale->customerName !!}</td>
                  <td><center>{!! Finance::total_client_invoices($sale->customerID) !!}</center></td>
                  <td align="right"><b>{!! $sale->code !!}{!! number_format($sale->total) !!}</b></td>
               </tr>
            @endforeach
            <tr>
               <td><b>Total</b></td>
               <td><center>{!! $countInvoice !!}</center></td>
               <td align="right"><b>{!! Wingu::currency()->code !!}{!!  number_format($sales->sum('total')) !!}</b></td>
            </tr>
         </tbody>
      </table>
   </div>
</body>
</html>