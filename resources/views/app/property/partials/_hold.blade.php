<div id="sidebar" class="sidebar">
   @php  $module = 'Point of sale' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub {{ Nav::isResource('dashboard') }}">
            <a href="{!! route('pos.dashboard') !!}">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a> 
         </li>
         {{-- <li class="has-sub">
            <a href="{!! route('sales.history') !!}">
               <i class="fal fa-clipboard-list"></i>
               <span>Cash Register </span>
            </a>
         </li> --}}
         <li class="has-sub {{ Nav::isResource('terminal') }}">
            <a href="{!! route('pos.sell') !!}">
               <i class="fal fa-cash-register"></i>
               <span>Sales Terminal</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('history') }}">
            <a href="{!! route('sales.history') !!}">
               <i class="fal fa-history"></i>
               <span>Sales history</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isRoute('pos.items') }}">
            <a href="{!! route('pos.items') !!}">
               <i class="fal fa-shopping-basket"></i>
               <span>Items</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-inventory"></i>
               <span>Inventory </span>
            </a>
            <ul class="sub-menu">
               {{-- <li class="#"><a href="#">Dashboard</a></li>
               <li class="#"><a href="#">My inventory</a></li> --}}
               <li class="{{ Nav::isRoute('finance.lpo.create') }}"><a href="{!! route('finance.lpo.create') !!}" target="_blank">purchase</a></li>
               {{-- <li class="#"><a href="#">transfers</a></li>
               <li class="#"><a href="#">Count, Stocktake</a></li> --}}
            </ul>
         </li>
         <li class="has-sub">
            <a href="#" target="_blank">
               <i class="fal fa-users-cog"></i>
               <span>Suppliers</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="{!! route('finance.contact.index') !!}" target="_blank">
               <i class="fal fa-users"></i>
               <span>Customers</span>
            </a>
         </li>
         <li class="has-sub">
            <a href="#" target="_blank">
               <i class="fal fa-chart-pie"></i>
               <span>Reports</span>
            </a>
         </li>
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-tools"></i>
               <span>Settings </span>
            </a>
            <ul class="sub-menu">
               <li class="#"><a href="#">General</a></li>
               <li class="#"><a href="#">Outlets and cash registers</a></li>
               <li class="#"><a href="#">Receipt templates</a></li>
               <li class="#"><a href="#">Email templates</a></li>
               <li class="#"><a href="#">Payment types</a></li>
               <li class="#"><a href="#">Tax rules</a></li>
               <li class="#"><a href="#">Loyalty points</a></li>
               <li class="#"><a href="#">Integrations</a></li>
            </ul>
         </li> --}}
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
