<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="robots" content="noindex">

   <title>Income Summary</title>

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
            <h3 class="text-center">{!! $business->name !!}</h3> 
            <h4 class="text-center">Income Summary</h4>
            <h5 class="text-center">From {!! date('F jS, Y', strtotime($from)) !!} To {!! date('F jS, Y', strtotime($to)) !!}</h5>
         </div>
      </div>
      <table class="table zi-table financial-comparison table-no-border">
         <thead>
            <tr class="rep-fin-th"> 
            <th class="text-left"><h3>Income</h3></th> 
            <th class="text-right"><h3>Total</h3></th>  
            </tr>
         </thead> 
         <tbody>  
            @foreach($incomeCategories as $category)
               @if(Finance::check_invoice_in_category_by_period($category->id,$from,$to) != 0)
                  @foreach(Finance::invoices_per_income_category($category->id,$from,$to) as $xx)
                     <tr class=" balance-tr">
                        <td>{!! $category->name !!}</td>  
                        <td class="text-right">{!! $business->code !!}{!! number_format(Finance::invoices_per_income_category_sum($category->id,$from,$to)) !!}</td>  
                     </tr>
                  @endforeach
               @endif
            @endforeach
            @if($unCategorisedInvoicesCount != 0)
               <tr class=" balance-tr">
                  <td>Others</td>  
                  <td class="text-right">{!! $business->code !!}{!! number_format($unCategorisedInvoicesSum) !!}</td>  
               </tr>
            @endif
            <tr>
               <td><b>Total Income</b></td>   
               <td class="text-right"><b>{!! $business->code !!}{!! number_format($income) !!}</b></td>  
            </tr>             
         </tbody>
      </table>
   </div>
</body>
</html>