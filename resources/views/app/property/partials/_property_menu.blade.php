<div class="col-md-12 mb-3">
   <ul class="nav nav-pills pull-right">
      <li class="nav-item">
         <a class="nav-link {!! Nav::isRoute('property.show') !!}" href="{!! route('property.show', $propertyID) !!}"><i class="fal fa-info-circle"></i> Overview</a>
      </li>
      <li class="nav-item {!! Nav::isRoute('property.tenants') !!}">
         <a class="nav-link {!! Nav::isRoute('property.tenants') !!}" href="{!! route('property.tenants', $propertyID) !!}"><i class="fal fa-users"></i> Tenants</a>
      </li>
      @if($property->property_type == 13 or $property->property_type == 14)
         <li class="nav-item dropdown {!! Nav::isResource('units') !!}">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-car-building"></i> Units</a>
            <div class="dropdown-menu">
               <a class="dropdown-item {!! Nav::isRoute('property.units') !!}" href="{!! route('property.units', $propertyID) !!}">All Units</a>
               <a class="dropdown-item {!! Nav::isRoute('property.units.create') !!}" href="{!! route('property.units.create', $propertyID) !!}">Add Units</a>
               <a class="dropdown-item {!! Nav::isRoute('property.units.bulk.create') !!}" href="{!! route('property.units.bulk.create', $propertyID) !!}">Add Bulk Units</a>
               <a class="dropdown-item {!! Nav::isRoute('property.vacant') !!}" href="{!! route('property.vacant', $propertyID) !!}">Vacant Units</a>
               <a class="dropdown-item {!! Nav::isRoute('property.occupied') !!}" href="{!! route('property.occupied', $propertyID) !!}">Occupied Units</a>
            </div>
         </li>
      @endif
      <li class="nav-item dropdown {!! Nav::isResource('leases') !!}">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-file-contract"></i> Leases</a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="{!! route('property.leases',$propertyID) !!}">All Lease</a>
            <a class="dropdown-item" href="{!! route('property.leases',$propertyID) !!}">Active Leases</a>
            @if($property->property_type == 13 or $property->property_type == 14)
               <a class="dropdown-item" href="{!! route('property.leases.create',$propertyID) !!}">Add Lease</a>
            @else
               @if($property->leaseID == "")
                  <a class="dropdown-item" href="{!! route('property.leases.create',$propertyID) !!}">Add Lease</a>
               @endif
            @endif
         </div>
      </li>
      <li class="nav-item dropdown {!! Nav::isResource('invoices') !!} {!! Nav::isRoute('property.payments') !!} {!! Nav::isRoute('property.payments.create') !!} {!! Nav::isRoute('property.payments.edit') !!} {!! Nav::isRoute('property.payments.show') !!} {!! Nav::isRoute('property.expense') !!} {!! Nav::isRoute('property.expense.create') !!} {!! Nav::isRoute('property.expense.edit') !!} {!! Nav::isResource('creditnote') !!} {!! Nav::isResource('utility') !!}">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-usd-circle"></i> Accounting</a>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="{!! route('property.invoice.index',$propertyID) !!}">Rent Billing</a>
            <a class="dropdown-item" href="{!! route('property.utility.billing.index',$propertyID) !!}">Utility Billing</a>
            <a class="dropdown-item {!! Nav::isResource('creditnote') !!}" href="{!! route('property.creditnote.index',$propertyID) !!}">
               Credit Note
            </a>
            <a class="dropdown-item {!! Nav::isRoute('property.payments') !!}" href="{!! route('property.payments',$propertyID) !!}">
               Payments
            </a>
            <a class="dropdown-item  {!! Nav::isRoute('property.expense') !!}" href="{!! route('property.expense',$propertyID) !!}"> Expenses</a>
         </div>
      </li>
      <li class="nav-item {!! Nav::isRoute('property.documents') !!}">
         <a class="nav-link" href="{!! route('property.documents',$propertyID) !!}"><i class="fal fa-folder"></i> Documents</a>
      </li>
      <li class="nav-item {!! Nav::isRoute('property.images') !!}">
         <a class="nav-link" href="{!! route('property.images',$propertyID) !!}"><i class="fal fa-images"></i> Images</a>
      </li>
      <li class="nav-item {!! Nav::isRoute('property.edit') !!}">
         <a class="nav-link" href="{!! route('property.edit',$propertyID) !!}"><i class="fal fa-edit"></i> Edit</a>
      </li>
      <li class="nav-item {!! Nav::isRoute('property.reports') !!}  {!! Nav::isResource('reports') !!} ">
         <a class="nav-link" href="{!! route('property.reports',$propertyID) !!}"><i class="far fa-chart-pie"></i> Reports</a>
      </li>
      <li class="nav-item dropdown {!! Nav::isResource('settings') !!}">
         <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fal fa-tools"></i> Settings</a>
         <div class="dropdown-menu">
            <a class="dropdown-item {!! Nav::isRoute('property.invoice.settings') !!}" href="{!! route('property.invoice.settings',$propertyID) !!}">Invoice</a>
            <a class="dropdown-item {!! Nav::isRoute('property.creditnote.settings') !!}" href="{!! route('property.creditnote.settings',$propertyID) !!}">Credit Note</a>
            <a class="dropdown-item {!! Nav::isRoute('property.payment.integration.settings') !!}" href="{!! route('property.payment.integration.settings',$propertyID) !!}">Payment details</a>
         </div>
      </li>
   </ul>
</div>
