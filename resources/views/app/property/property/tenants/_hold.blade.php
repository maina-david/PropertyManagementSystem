<ul class="nav nav-pills mb-4">
   <li class="nav-items {{ Nav::isRoute('pm.tenants.show') }}">
      <a href="{!! route('pm.property.tenants.show', $tenantID) !!}">
         <span class="d-sm-none"><i class="fas fa-chart-bar"></i> Overview</span>
         <span class="d-sm-block d-none"><i class="fas fa-chart-bar"></i> Overview</span>
      </a>
   </li>
   {{-- <li class="nav-items">
      <a href="{!! route('pm.tenants.comments', $tenantID) !!}">
         <span class="d-sm-none"><i class="fas fa-info-circle"></i> Lease</span>
         <span class="d-sm-block d-none"><i class="fas fa-info-circle"></i> Lease</span>
      </a>
   </li> --}}
   {{-- <li class="nav-items">
      <a href="{!! route('pm.tenants.comments', $tenantID) !!}">
         <span class="d-sm-none"><i class="fas fa-info-circle"></i> Properties</span>
         <span class="d-sm-block d-none"><i class="fas fa-info-circle"></i> Properties</span>
      </a>
   </li> --}}
   <li class="nav-items {{ Nav::isRoute('pm.tenants.comments') }}">
      <a href="{!! route('pm.tenants.comments', $tenantID) !!}">
         <span class="d-sm-none"><i class="fas fa-comment"></i> Comments</span>
         <span class="d-sm-block d-none"><i class="fas fa-comment"></i> Comments</span>
      </a>
   </li>
   <li class="nav-items {{ Nav::isRoute('pm.tenants.invoices') }}">
      <a href="{!! route('pm.tenants.invoices', $tenantID) !!}">
         <span class="d-sm-none"><i class="fas fa-file-invoice-dollar"></i> invoices</span>
         <span class="d-sm-block d-none"><i class="fas fa-file-invoice-dollar"></i> invoices</span>
      </a>
   </li>
   {{-- <li class="nav-items">
      <a href="#">
         <span class="d-sm-none"><i class="fas fa-receipt"></i> Estimate</span>
         <span class="d-sm-block d-none"><i class="fas fa-receipt"></i> Estimate</span>
      </a>
   </li>
   <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-funnel-dollar"></i> Credits</span>
         <span class="d-sm-block d-none"><i class="fas fa-funnel-dollar"></i> Credits</span>
      </a>
   </li> --}}
   <li class="nav-items {{ Nav::isResource('statement') }}">
      <a href="{!! route('pm.tenants.statement',$tenantID) !!}">
         <span class="d-sm-none"><i class="fas fa-file-invoice"></i> Statements</span>
         <span class="d-sm-block d-none"><i class="fas fa-file-invoice"></i> Statements</span>
      </a>
   </li>
   {{-- <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-hammer"></i> work orders</span>
         <span class="d-sm-block d-none"><i class="fas fa-hammer"></i> Projects</span>
      </a>
   </li> --}}
   {{-- <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-address-book"></i> Contacts</span>
         <span class="d-sm-block d-none"><i class="fas fa-address-book"></i> Contacts</span>
      </a>
   </li>
   <li class="nav-items">
      <a href="#nav-pills-tab-4">
         <span class="d-sm-none"><i class="fas fa-envelope-open-text"></i> Mail</span>
         <span class="d-sm-block d-none"><i class="fas fa-envelope-open-text"></i> Mail</span>
      </a>
   </li> --}}
</ul>
