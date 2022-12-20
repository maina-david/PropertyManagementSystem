<div class="col-md-3">
   <div class="list-group">
      <a href="{!! route('property.income.category') !!}" class="list-group-item {{ Nav::isResource('income') }}">
         <i class="fal fa-usd-circle"></i> Income Categories
      </a>
      <a href="{!! route('property.expense.category.index') !!}" class="list-group-item {{ Nav::isResource('expense') }}">
         <i class="fal fa-credit-card"></i> Expense Categories
      </a>
      <a href="{!! route('property.taxes') !!}" class="list-group-item {{ Nav::isResource('taxes') }}">
         <i class="fal fa-balance-scale-left"></i> Tax Rates
      </a>
      <a href="{!! route('property.payment.method') !!}" class="list-group-item {{ Nav::isResource('method') }}">
         <i class="fab fa-amazon-pay"></i> Payment Modes
      </a>
      <a href="{!! route('property.utilities') !!}" class="list-group-item {{ Nav::isResource('utilities') }}">
         <i class="fal fa-outlet"></i> utilities
      </a>
   </div>
</div>
