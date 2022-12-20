@extends('layouts.app')
@section('title') {!! $property->title !!} | Create Lease @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">   
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Leases</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> {!! $property->title !!} | Create Lease</h1>
      <div class="row">
         @include('app.property.partials._property_menu') 
         <div class="col-md-12">      
            <form action="{!! route('property.leases.store') !!}" class="row" method="POST" enctype="multipart/form-data">  
               @csrf  
               <div class="col-md-12">
                  <div class="panel">
                     <div class="panel-heading">Lease Details</div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 {!! Form::label('Property Name', 'Property Name', array('class'=>'control-label')) !!}
                                 <input type="text"  value="{!! $property->title !!}" class="form-control" disabled>
                                 <input type="hidden" name="propertyID" value="{!! $property->id !!}">
                              </div>
                           </div>
                           <div class="col-md-4">
                              @if($property->property_type == 13 || $property->property_type == 14)
                                 <div class="form-group form-group-default required ">
                                    {!! Form::label('Unit', 'Unit', array('class'=>'control-label text-danger')) !!}
                                    {!! Form::select('unitID',$units, null, array('class' => 'form-control multiselect','required' => '')) !!}
                                 </div>
                              @else 
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Serials', 'Property ID', array('class'=>'control-label')) !!}
                                    <input type="text" value="{!! $property->serial !!}" class="form-control" readonly>
                                    <input type="hidden" name="unitID" value="{!! $property->id !!}">
                                 </div>                           
                              @endif
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 {!! Form::label('Select Tenant', 'Select Tenant', array('class'=>'control-label')) !!}
                                 <select name="tenant" class="form-control multiselect">
                                    <option value="">Choose Tenant</option>
                                    @foreach($tenants as $tenant)
                                       <option value="{!! $tenant->id !!}">{!! $tenant->tenant_name !!}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 {!! Form::label('Lease Type', 'Lease Type', array('class'=>'control-label text-danger')) !!}
                                 {!! Form::select('lease_type', ['' => 'Choose Type','Commercial Lease' => 'Commercial Lease', 'Residential Lease' => 'Residential Lease'], null, array('class' => 'form-control multiselect','required' => '')) !!}
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 {!! Form::label('Start Date', 'Start Date', array('class'=>'control-label text-danger')) !!}
                                 {!! Form::date('lease_start_date', null, array('class' => 'form-control', 'required' => '')) !!}
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default">
                                 {!! Form::label('End Date', 'End Date', array('class'=>'control-label')) !!}
                                 {!! Form::date('lease_end_date', null, array('class' => 'form-control')) !!}
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel">
                     <div class="panel-heading">Recurring Details</div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group form-group-default">
                                 {!! Form::label('Deposit', 'Deposit', array('class'=>'control-label')) !!}
                                 {!! Form::number('deposit', null, array('class' => 'form-control', 'placeholder' => 'Enter Amount')) !!}
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 {!! Form::label('Rent Amount', 'Rent Amount', array('class'=>'control-label text-danger')) !!}
                                 <input type="number" value="{!! $property->rent_price !!}" name="rent_amount" class="form-control" placeholder = "Enter Rent Amount" required>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required ">
                                 {!! Form::label('Billing schedule', 'Billing schedule', array('class'=>'control-label text-danger')) !!}
                                 {!! Form::select('billing_schedule', [''=>'Choose',7 => 'Weekly',1 => 'Monthly',3 => 'Quarterly',6 => 'Half Year',12 => 'Yearly'], null, array('class' => 'form-control', 'required' => '')) !!}
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('First invoice date', 'First invoice date', array('class'=>'control-label text-danger')) !!}
                                 {!! Form::date('first_invoice_date', null, array('class' => 'form-control')) !!}
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('Due Day', 'Due Day', array('class'=>'control-label text-danger')) !!}
                                 {!! Form::select('due_day', ['1' => '1st','2' => '2nd','3' => '3rd','4' => '4th','5' => '5th','6' => '6th','7' => '7 th','8' => '8th','9' => '9th','10' => '10th','11' => '11th','12' => '12th','13' => '13th','14' => '14th','15' => '15th','16' => '16th','17' => '17th','18' => '18th','19' => '19th','20' => '20th','21' => '21st','22' => '22nd','23' => '23rd','24' => '24th','25' => '25th','26' => '26th','27' => '27th','28' => '28th'], null, array('class' => 'form-control multiselect', 'required' => '')) !!}
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group form-group-default">
                                 {!! Form::label('Tax rate', 'Tax Rate', array('class'=>'control-label')) !!}
                                 <select name="tax_rate" id="" class="form-control multiselect">
                                       <option value="0">Choose tax rate</option>
                                       <option value="0">No Tax</option>
                                       @foreach ($taxes as $tax)
                                          <option value="{!! $tax->rate !!}">{!! $tax->name !!} - {!! $tax->rate !!}%</option>
                                       @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel">
                     <div class="panel-heading">Escalation Rate</div>
                     <div class="panel-body">
                        <div class="row">                    
                           <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 {!! Form::label('Escalation Rate', 'Escalation Rate in %', array('class'=>'control-label')) !!}
                                 {!! Form::number('escalation_rate', null, array('class' => 'form-control','step' => '0.01', 'placeholder' => 'Enter rate')) !!}
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 {!! Form::label('Escalation Period', 'Escalation Period', array('class'=>'control-label')) !!}
                                 {!! Form::select('escalation_period', ['Monthly' => 'Monthly', 'quarterly' => 'quarterly', 'Half year' => 'Half year', 'Yearly' => 'Yearly','After 2 Yearly' => 'After 2 Yearly','After 3 Yearly' => 'After 3 Yearly' ], null, array('class' => 'form-control multiselect')) !!}
                              </div>
                           </div>
                           <div class="col-md-6">
                              <h5 class="font-weight-bolder">Escalation Items </h5>
                              <div class="row">
                                 <div class="col-md-4">
                                    <input type="checkbox" name="escalating_items[]" value="Rent"> Rent
                                 </div>
                                 <div class="col-md-4">
                                    <input type="checkbox" name="escalating_items[]" value="Service charge"> Service charge
                                 </div>
                                 <div class="col-md-4">
                                    <input type="checkbox" name="escalating_items[]" value="Parking fee"> Parking fee
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel">
                     <div class="panel-heading">Service charge & Parking</div>
                     <div class="panel-body">
                        <div class="row">  
                           <div class="col-md-6">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                       {!! Form::label('Service Charge', 'Service Charge', array('class'=>'control-label')) !!}
                                       {!! Form::number('service_charge', null, array('class' => 'form-control', 'placeholder' => 'Enter amount')) !!}
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                       {!! Form::label('Price per parking', 'Price per parking', array('class'=>'control-label')) !!}
                                       {!! Form::number('parking_price', null, array('class' => 'form-control', 'placeholder' => 'Enter price')) !!}
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                       {!! Form::label('Allocated parking spaces', 'Allocated parking spaces', array('class'=>'control-label')) !!}
                                       {!! Form::number('parking_spaces', null, array('class' => 'form-control', 'placeholder' => 'Enter spaces')) !!}
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="">Define what is under service charge</label>
                                 {!! Form::textarea('define_service_charge',null,['class' => 'form-control']) !!}
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel">
                     <div class="panel-heading">Utilities</div>
                     <div class="panel-body">
                        <div class="row">  
                           <div class="col-md-6">
                              <div class="form-group form-group-default">
                                 {!! Form::label('Do you want to include utilities ?', 'Do you want to include utilities ?', array('class'=>'control-label')) !!}
                                 {!! Form::select('include_utility', ['No' => 'Choose your option', 'Yes' => 'Yes Include utilities to the lease','No' => 'No Dont include utilities to the lease'], null, array('class' => 'form-control multiselect','id' => 'utility')) !!}
                              </div>
                           </div>
                           <div class="col-md-12" style="display: none" id="Add_utility">
                              <table class="table table-striped table-bordered table-hover mt-3" id="table">
                                 <thead>
                                    <tr>
                                       <th width="1%">#</th>
                                       <th>Utility</th>
                                       <th>Name/No</th>
                                       <th>Current Reading</th>
                                       <th>Current Pricing</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td><input class="case" type="checkbox"/></td>
                                       <td>
                                          <select name="utilityID[]" class="form-control">
                                             <option value="">Choose Utility</option>
                                             @foreach($utilities as $utility)
                                                <option value="{!! $utility->id !!}">{!! $utility->name !!}</option>
                                             @endforeach
                                          </select>
                                       </td>
                                       <td>
                                          <input type="text" name="utility_No[]" class="form-control">
                                       </td>
                                       <td>
                                          <input type="number" name="current_reading[]" step="0.01" class="form-control" value="00">
                                       </td>
                                       <td>
                                          <input type="number" name="current_price[]" step="0.01" class="form-control" value="1">
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <button class="btn btn-danger delete" type="button">- Delete</button>
                              <button class="btn btn-primary addmore" type="button">+ Add More</button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="panel">
                     <div class="panel-heading">Lease Agreement Details</div>
                     <div class="panel-body">
                        <div class="row">  
                           <div class="col-md-12">
                              {!! Form::label('Agreement', 'Agreement', array('class'=>'control-label')) !!}
                              <textarea name="agreement" id="" cols="30" rows="10" class="ckeditor"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 mb-5">
                  <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Add Lease</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
               </div>
            </form>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script>
      $(document).ready(function(){
         var x = 1;
         $(".addmore").click(function () {
            $("#table tbody tr:first").clone().find("input").each(function () {
               $(this).val('').attr({
                  'id': function (_, id) {
                     return id + x
                  }
               });

            }).end().appendTo("table");
            x++;
         });

      });

      $(document).ready(function() {
         $('#utility').on('change', function() {
            if (this.value == 'Yes') {
               $('#Add_utility').show();
            } else {
               $('#Add_utility').hide();
            }
         });
      });

      //deletes the selected table rows
      $(".delete").on('click', function() {
         $('.case:checkbox:checked').parents("tr").remove();
         $('#check_all').prop("checked", false);
         calculateTotal();
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
