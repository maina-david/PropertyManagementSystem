<div class="col-md-3">
   @php  
      $property = Wingu::get_account_module_details(1);
   @endphp
   <div class="list-group">
      <a href="{!! route('settings.business.index') !!}" class="list-group-item {{ Nav::isResource('business') }}">
         <i class="fal fa-globe"></i> Business Profile
      </a>
      @permission('create-invoices')
         <a href="{!! route('finance.settings.invoice') !!}" class="list-group-item {{ Nav::isResource('invoice') }}">
            <i class="fal fa-file-invoice-dollar"></i> Invoice
         </a>
      @endpermission
      @permission('create-taxes')
         <a href="{!! route('finance.settings.taxes') !!}" class="list-group-item {{ Nav::isResource('taxes') }}">
            <i class="fal fa-coins"></i> Tax Rates
         </a>
      @endpermission
      @if($property->module_status == 15 && $property->payment_status == 1)
         @permission('create-incomecategory')
            <a href="{!! route('finance.income.category') !!}" class="list-group-item {{ Nav::isResource('income') }}">
               <i class="fal fa-money-bill-alt"></i> Income Categories
            </a>
         @endpermission
         @permission('create-expensecategory')
            <a href="{!! route('finance.expense.category.index') !!}" class="list-group-item {{ Nav::isResource('expense') }}">
               <i class="fal fa-sitemap"></i> Expense Categories
            </a>
         @endpermission
         @if(Wingu::check_plan_function(11,Wingu::business()->plan,1) == 1)
            @permission('create-lpo')
               <a href="{!! route('finance.settings.lpo') !!}" class="list-group-item {{ Nav::isResource('lpo') }}">
                  <i class="fal fa-file-contract"></i> Purchase Order 
               </a>
            @endpermission
         @endif
         @if(Wingu::check_plan_function(9,Wingu::business()->plan,1) == 1)
            @permission('create-quotes')
               <a href="{!! route('finance.settings.quote') !!}" class="list-group-item {{ Nav::isResource('quote') }}">
                  <i class="far fa-file-alt"></i> Quotes
               </a>
            @endpermission
         @endif
         <a href="{!! route('finance.settings.salesorders') !!}" class="list-group-item {{ Nav::isResource('salesorders') }}">
            <i class="fal fa-cart-arrow-down"></i> Sales orders
         </a>
        
         @if(Wingu::check_plan_function(12,Wingu::business()->plan,1) == 1)
            @permission('create-creditnote')
               <a href="{!! route('finance.settings.creditnote') !!}" class="list-group-item {{ Nav::isResource('creditnote') }}">
                  <i class="fal fa-credit-card"></i> Credit Note
               </a>
            @endpermission
         @endif
         @permission('create-payments')
            <a href="{!! route('finance.payment.mode') !!}" class="list-group-item {{ Nav::isResource('mode') }}">
               <i class="fab fa-amazon-pay"></i> Payment Modes
            </a>
         @endpermission
         {{-- <a href="{!! route('finance.settings.invoice') !!}" class="list-group-item">
            <i class="fal fa-upload"></i> Import | Export
         </a> --}}
         {{-- <a href="{!! route('finance.settings.currency') !!}" class="list-group-item {{ Nav::isResource('currency') }}">
            <i class="fal fa-university"></i> Credit Cards & Banking
         </a> --}}
      @endif
   </div>
</div>
