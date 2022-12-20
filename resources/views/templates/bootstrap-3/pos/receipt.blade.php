<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">
   <title>Receipt</title>

   <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="{!! asset('assets/templates/bootstrap-3/style.css') !!}" media="all" />

   <style>
      .text-right {
         text-align: right;
      }
   </style> 
</head>
<body>
   <div>
      <div class="row">
         <div class="col-xs-12">
            <h3 class="text-center">Receipt</h3> 
            <h4 class="text-center">#{!! $invoice->prefix !!}{!! $invoice->number !!}</h4>
            <h5 class="text-center">{!! date('F jS, Y', strtotime($invoice->invoice_date)) !!}</h5>
         </div>
      </div>
      <table class="table">
         <thead>
            <th>Item</th>
            <th>Amount</th>
         </thead>
         <tbody>
            @foreach($products as $product)
               <tr>
                  <td><p>{!! $product->quantity !!} x {!! $product->product_name !!} @ {!! $invoice->symbol !!}{!! number_format($product->selling_price,2) !!}</p></td>
                  <td>{!! $invoice->symbol !!}{!! number_format($product->total_amount,2) !!}</td>
               </tr>
            @endforeach
         </tbody>
      </table>
      <div class="row">
         <div class="col-md-6"></div>
         <div class="col-md-6">
            <table class="table">
               <tr>
                  <th>Discount</th>
                  <th>{!! $invoice->symbol !!}{!! number_format($invoice->discount,2) !!}</th>
               </tr>
               <tr>
                  <th>Subtotal</th>
                  <th>{!! $invoice->symbol !!}{!! number_format($invoice->sub_total,2) !!}</th>
               </tr>
               <tr>
                  <th>Tax ({!! $invoice->taxRate !!}%)</th>
                  <th>{!! $invoice->symbol !!}{!! number_format($invoice->taxvalue,2) !!}</th>
               </tr>
               <tr>
                  <th>Total</th>
                  <th>{!! $invoice->symbol !!}{!! number_format($invoice->total,2) !!}</th>
               </tr>
               <tr>
                  <th>Paid</th>
                  <th>{!! $invoice->symbol !!}{!! number_format($invoice->total,2) !!}</th>
               </tr>
            </table>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <hr>
            <center>Served By {!! Wingu::user($invoice->salesperson)->name !!}</center>
            <center>{!! date('F jS, Y', strtotime($invoice->invoice_date)) !!}</center>
         </div>
      </div>
   </div>
</body>
</html>