<ul class="nav nav-tabs">
   <li class="nav-item {!! Nav::isRoute('finance.contact.show') !!}">
      <a class="nav-link {!! Nav::isRoute('finance.contact.show') !!}" href="{!! route('finance.contact.show',$customerID) !!}"><i class="fal fa-info-circle"></i> Overview</a>
   </li>
   <li class="nav-item {{ Nav::isRoute('finance.customers.comments') }}">  
      <a href="{!! route('finance.customers.comments', $customerID) !!}" class="nav-link {{ Nav::isRoute('finance.customers.comments') }}">
         <i class="fal fa-comments-alt"></i> Comments
      </a>
   </li>
   <li class="nav-item {{ Nav::isRoute('finance.customers.invoices') }}">
      <a href="{!! route('finance.customers.invoices', $customerID) !!}" class="nav-link {{ Nav::isRoute('finance.customers.invoices') }}"><i class="fal fa-file-invoice-dollar"></i> invoices</span></a>
   </li>
   @if(Wingu::business()->plan != 1)
      <li class="nav-item {{ Nav::isRoute('finance.customers.quotes') }}">
         <a href="{!! route('finance.customers.quotes', $customerID) !!}" class="nav-link {{ Nav::isRoute('finance.customers.quotes') }}"><i class="fal fa-file-invoice"></i> Quote</a>
      </li>
      <li class="nav-item {{ Nav::isRoute('finance.customers.creditnotes') }}">
         <a href="{!! route('finance.customers.creditnotes', $customerID) !!}" class="nav-link {{ Nav::isRoute('finance.customers.creditnotes') }}"><i class="fal fa-file-alt"></i> Credits</a>
      </li>
   @endif
   <li class="nav-item {{ Nav::isRoute('finance.customers.projects') }}">
      <a href="{!! route('finance.customers.projects', $customerID) !!}" class="nav-link {{ Nav::isRoute('finance.customers.projects') }}"><i class="fal fa-tasks"></i> Projects</a>
   </li>
   @if(Wingu::business()->plan != 1)
      <li class="nav-item {{ Nav::isRoute('finance.customers.statement') }} {{ Nav::isRoute('finance.customers.statement') }}">
         <a href="{!! route('finance.customers.statement',$customerID) !!}" class="nav-link {{ Nav::isRoute('finance.customers.statement') }} {{ Nav::isRoute('finance.customers.statement') }}"><i class="fal fa-receipt"></i> Statement</a>
      </li>
      {{-- <li class="nav-item {{ Nav::isRoute('finance.customers.subscriptions') }}">
         <a href="{!! route('finance.customers.subscriptions',$customerID) !!}" class="nav-link {{ Nav::isRoute('finance.customers.subscriptions') }}""><i class="fal fa-sync-alt"></i> Subscriptions</a>
      </li>   --}}
   @endif 
</ul>