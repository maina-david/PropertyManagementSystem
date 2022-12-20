<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Inventory Summary</title>

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
            <h3 class="text-center">Inventory Summary</h3>
            <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
         </div>
      </div>
      <table class="table table-bordered">
         <thead>
            <tr>  
               <th>Item Name</th>  
               <th>SKU</th>  
               <th>Quantity Out</th>
               <th>Stock on Hand</th> 
            </tr>
         </thead> 
         <tbody> 
            @foreach($products as $product)
               <tr>
                  <td>{!! $product->product_name !!}</td>
                  <td>{!! $product->sku_code !!}</td>
                  <td>{!! Finance::product_sales_report($product->productID,$from,$to)->quantity !!}</td>
                  <td>{!! $product->current_stock !!}</td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</body>
</html>