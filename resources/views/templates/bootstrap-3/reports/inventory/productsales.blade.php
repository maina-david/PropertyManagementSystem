<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Product Sales Report</title>

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
            <h3 class="text-center">Product Sales Report</h3>
            <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
         </div>
      </div>
      <table class="table table-bordered">
         <thead>
            <tr>  
               <th>Item Name</th>  
               <th><center>sku</center></th>  
               <th><center>Quantity sold</center></th> 
               <th><center>Amount</center></th>  
            </tr>
         </thead> 
         <tbody> 
            @foreach($products as $product)
               <tr>
                  <td><a href="#">{!! $product->name !!}</a></td>
                  <td><center>{!! $product->sku !!}</center></td>
                  <td><center>{!! Finance::count_invoice_products($product->productID) !!}</center></td>
                  <td><center><b>{!! number_format($product->total) !!} {!! $product->code !!}</b></center></td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</body>
</html>