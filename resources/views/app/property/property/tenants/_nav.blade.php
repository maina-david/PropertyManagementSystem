<div class="col-md-12">
   <a href="{!! route('property.show',$propertyID) !!}" class="btn btn-warning float-left"><i class="fal fa-arrow-circle-left"></i> Back to property</a>
   <ul class="nav nav-pills pull-right">
      <li class="nav-item {!! Nav::isRoute('property.tenants.show') !!}">
         <a class="nav-link {!! Nav::isRoute('property.show') !!}" href="{!! route('property.tenants.show',[$propertyID,$tenantID]) !!}"><i class="fal fa-info-circle"></i> Overview</a>
      </li>
      <li class="nav-item {!! Nav::isResource('lease') !!}">
         <a class="nav-link" href="{!! route('property.tenant.lease',[$propertyID,$tenantID]) !!}"><i class="fal fa-file-signature"></i> Leases</a>
      </li>
      @if($property->property_type == 13 || $property->property_type == 14)
         <li class="nav-item {!! Nav::isResource('units') !!}">
            <a class="nav-link" href="{!! route('tenants.units.index',[$propertyID,$tenantID]) !!}"><i class="fal fa-building"></i> Units</a> 
         </li>
      @endif
      {{-- <li class="nav-item {!! Nav::isResource('notes') !!}"> 
         <a class="nav-link" href="{!! route('tenants.notes',[$propertyID,$tenantID]) !!}"><i class="fal fa-sticky-note"></i> Notes</a>
      </li>  --}}
      {{-- <li class="nav-item {!! Nav::isResource('invoices') !!}"> 
         <a class="nav-link" href="{!! route('tenants.invoice.index',[$propertyID,$tenantID]) !!}"><i class="fal fa-money-check-alt"></i> Billing</a>
      </li> --}}
      {{-- <li class="nav-item">
         <a class="nav-link" href="#"><i class="fal fa-credit-card"></i> Credits</a>
      </li> --}}
      {{-- <li class="nav-item">
         <a class="nav-link" href="#"><i class="fal fa-receipt"></i> Statements</a>
      </li> --}}
      {{-- <li class="nav-item">
         <a class="nav-link" href="#"><i class="fal fa-paper-plane"></i> Mails</a>
      </li> --}}
      {{-- <li class="nav-item">
         <a class="nav-link" href="#"><i class="fal fa-sms"></i> SMS</a>
      </li> --}}
      {{-- <li class="nav-item">
         <a class="nav-link" href="#"><i class="fal fa-tools"></i> Maintenance Requests</a>
      </li> --}}
   </ul>
</div>