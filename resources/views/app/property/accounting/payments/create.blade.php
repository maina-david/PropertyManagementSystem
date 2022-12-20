@extends('layouts.app')
{{-- page header --}}
@section('title')  {!! $property->title !!} | Add Payments  @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page styles --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.show',$property->id) !!}">{!! $property->title !!}</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.payments',$property->id) !!}">Payments</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Add Payments</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12 mt-3">   
            {!! Form::open(array('route' => 'property.payments.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')) !!}
               <div class="row">
                  <div class="col-md-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4 class="panel-title">Payment Details</h4>
                        </div>
                        <div class="panel-body">
                           <div class="form-group form-group-default">
                              <label class="text-danger">Tenant</label>
                              <select class="form-group form-control multiselect" id="client_select" name="tenant" required="">
                                 <option value="">Choose Tenant</option>
                                 @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}">{!! $tenant->tenant_name !!}</option>
                                 @endforeach
                              </select>
                              <input type="hidden" value="{!! $property->id !!}" name="propertyID" required>
                           </div>
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')) !!}
                                    {!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )) !!}
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Bank Charges (if any)', 'Bank Charges (if any)', array('class'=>'control-label')) !!}
                                    {!! Form::text('bank_charges', null, array('class' => 'form-control', 'placeholder' => 'Bank Charges (if any)')) !!}
                                 </div>
                              </div>
                              {{-- <div class="col-sm-12">
                                 <div class="form-group form-group-default">
                                    <label for="accountID" class="control-label"> Choose Deposit Account</label>
                                    {!! Form::select('accountID',$accounts, null, array('class' => 'form-control multiselect')) !!}
                                 </div>
                              </div> --}}
                              {{-- <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="amount" class="control-label"> Income Category </label>
                                    {!! Form::select('incomeID',$categories, null, array('class' => 'form-control multiselect')) !!}
                                 </div>
                              </div> --}}
                           </div>
                           <div class="form-group form-group-default">
                              {!! Form::label('Payment Date', 'Payment Date', array('class'=>'control-label')) !!}
                              {!! Form::date('payment_date', null, array('class' => 'form-control')) !!}
                           </div><select name="payment_method" class="form-control multiselect">
                                 <option value="">Choose payment method</option>
                                 @foreach($mainMethods as $main)
                                    <option value="{!! $main->id !!}">{!! $main->name !!}</option>
                                 @endforeach
                                 @foreach($paymentmethod as $method)
                                    <option value="{!! $method->id !!}">{!! $method->name !!}</option>
                                 @endforeach
                              </select>
                           <div class="form-group form-group-default">
                              {!! Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')) !!}
                              
                           </div>
                           <div class="form-group form-group-default">
                              <label class="text-danger">Invoice Number</label>
                              <select class="form-control multiselect" id="invoice_no" name="invoice" required="">

                              </select>
                           </div>
                           <div class="form-group form-group-default">
                              <label>Reference Number</label>
                              {!! Form::text('reference_number', null, array('class' => 'form-control', 'placeholder' => 'Reference Number')) !!}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4 class="panel-title">Payment Details</h4>
                        </div>
                        <div class="panel-body">                  
                           <div class="form-group">
                              <label>Upload Payment Documents</label><br>
                              <input type="file" name="files[]" multiple>
                           </div>
                           <div class="form-group mt-4">
                              {!! Form::label('Notes (Internal use. Not visible to customer)', 'Notes (Internal use. Not visible to customer)', array('class'=>'control-label')) !!}
                              {!! Form::textarea('note',null,['class'=>'form-control my-editor', 'rows' => 9, 'placeholder'=>'content']) !!}
                           </div>
                           {{-- <div class="form-group form-group-default required">
                              <div class="checkbox ">
                                 <input type="checkbox" value="yes" id="" name="send_email">
                                 <label for="">Send a "thank you" note for this payment</label>
                              </div>
                           </div> --}}
                        </div>
                     </div>
                  </div>
                  <div class="btn-toolbar col-md-12">
                     <button type="submit" id="" class="btn btn-success submit"><i class="fas fa-save"></i> Submit Payment</button>
                     <img src="{!! url('/') !!}/public/app/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
                  </div>
               </div>
            {{ Form::close() }}
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      $('#client_select').on('change',function(e){
         console.log(e);
         var tenantID =  e.target.value;
         var url = "{{ url('/') }}"
         var propertyID = "{{ $property->id }}"
         var prefix = "{!! $invoiceSetting->prefix !!}"
         var code = "{!! $business->code !!}"
         //ajax
         $.get(url+'/property-management/retrive/'+propertyID+'/invoice/'+tenantID, function(data){
            //success data
            $('#invoice_no').empty();
            $.each(data, function(invoices, info){
               $('#invoice_no').append('<option value="'+ info.id +'">'+info.invoice_prefix+''+info.invoice_number+' | '+code+''+info.balance+' | '+info.invoice_title+'</option>');
            });
         });
      });
   </script>
@endsection
