<ul class="nav nav-tabs">
   <li class="nav-item {!! Nav::isRoute('crm.customers.show') !!}">
      <a class="nav-link {!! Nav::isRoute('crm.customers.show') !!}" href="{!! route('crm.customers.show',$customerID) !!}"><i class="fal fa-info-circle"></i> Overview</a>
   </li>
   <li class="nav-item {{ Nav::isRoute('crm.customers.comments') }}">
      <a href="{!! route('crm.customers.comments', $customerID) !!}" class="nav-link {{ Nav::isRoute('crm.customers.comments') }}">
         <i class="fal fa-comments-alt"></i> Comments
      </a>
   </li>
   <li class="nav-item {{ Nav::isRoute('crm.customers.invoices') }}">
      <a href="{!! route('crm.customers.invoices', $customerID) !!}" class="nav-link {{ Nav::isRoute('crm.customers.invoices') }}"><i class="fal fa-file-invoice-dollar"></i> invoices</span></a>
   </li>
   @if(Wingu::business()->plan != 1)
      <li class="nav-item {{ Nav::isRoute('crm.customers.quotes') }}">
         <a href="{!! route('crm.customers.quotes', $customerID) !!}" class="nav-link {{ Nav::isRoute('crm.customers.quotes') }}"><i class="fal fa-file-invoice"></i> Quote</a>
      </li>
      <li class="nav-item {{ Nav::isRoute('crm.customers.creditnotes') }}">
         <a href="{!! route('crm.customers.creditnotes', $customerID) !!}" class="nav-link {{ Nav::isRoute('crm.customers.creditnotes') }}"><i class="fal fa-file-alt"></i> Credits</a>
      </li>
   @endif
   <li class="nav-item {{ Nav::isRoute('crm.customers.projects') }}">
      <a href="{!! route('crm.customers.projects', $customerID) !!}" class="nav-link {{ Nav::isRoute('crm.customers.projects') }}"><i class="fal fa-tasks"></i> Projects</a>
   </li>
   @if(Wingu::business()->plan != 1)
      <li class="nav-item {{ Nav::isRoute('crm.customers.statement') }} {{ Nav::isRoute('crm.customers.statement.mail') }}">
         <a href="{!! route('crm.customers.statement',$customerID) !!}" class="nav-link {{ Nav::isRoute('crm.customers.statement.mail') }} {{ Nav::isRoute('crm.customers.statement.mail') }}"><i class="fal fa-receipt"></i> Statement</a>
      </li>
      <li class="nav-item {{ Nav::isRoute('crm.customers.subscriptions') }}">
         <a href="{!! route('crm.customers.subscriptions',$customerID) !!}" class="nav-link {{ Nav::isRoute('crm.customers.subscriptions') }}""><i class="fal fa-sync-alt"></i> Subscriptions</a>
      </li>
   @endif
</ul>
