@extends('layouts.app')
{{-- page header --}}
@section('title','Add Payments')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
      <li class="breadcrumb-item"><a href="{!! route('finance.payments.received') !!}">Payments Received</a></li>
      <li class="breadcrumb-item active">Add Payments</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-cash-register"></i> Add Payment</h1>
   @include('partials._messages')
   {!! Form::open(array('route' => 'finance.payments.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')) !!}
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Payment Details</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group form-group-default required">
                     <label>Customer Name</label>
                     <select class="form-group form-control multiselect" id="client_select" name="customer" required="">
                        <option value="">Choose Customer</option>
                        @foreach ($contacts as $cli)
                           <option value="{{ $cli->id }}">{!! $cli->customer_name !!}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group form-group-default required">
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
                     <div class="col-sm-12">
                        <div class="form-group form-group-default">
                           <label for="accountID" class="control-label"> Choose Deposit Account</label>
                           {!! Form::select('accountID',$accounts, null, array('class' => 'form-control multiselect')) !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group form-group-default">
                     {!! Form::label('Payment Date', 'Payment Date', array('class'=>'control-label')) !!}
                     {!! Form::date('payment_date', null, array('class' => 'form-control')) !!}
                  </div>
                  <div class="form-group form-group-default">
                     {!! Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')) !!}
                     <select name="payment_method" class="form-control multiselect">
                        <option value="">Choose Method of payment</option>                       
                        @foreach($defaultPaymentMethod as $defaultmethod)
                           <option value="{!! $defaultmethod->id !!}">{!! $defaultmethod->name !!}</option>
                        @endforeach
                        @foreach ($paymentmethod as $method)
                           <option value="{!! $method->id !!}">{!! $method->name !!}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group form-group-default required">
                     <label>Invoice Number</label>
                     <select class="form-control multiselect" id="invoice_no" name="invoice" required="">

                     </select>
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
                  <div class="form-group form-group-default">
                     <label>Transaction ID</label>
                     {!! Form::text('reference_number', null, array('class' => 'form-control', 'placeholder' => 'Transaction ID')) !!}
                  </div>
                  {{-- <div class="form-group">
                     <label>Upload Payment Documents</label><br>
                     <input type="file" name="files[]" multiple>
                  </div> --}}
                  <div class="form-group mt-4">
                     {!! Form::label('Notes (Internal use. Not visible to customer)', 'Notes (Internal use. Not visible to customer)', array('class'=>'control-label')) !!}
                     {!! Form::textarea('note',null,['class'=>'form-control ckeditor', 'rows' => 9, 'placeholder'=>'content']) !!}
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
            <button type="submit" id="" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Payment</button>
            <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
         </div>
      </div>
   {{ Form::close() }}
</div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script type="text/javascript">
      $('#client_select').on('change',function(e){
         console.log(e);
         var client_id =  e.target.value;
         var url = "{{ url('/') }}"
         var code = "{!! $settings->code !!}"
         var prefix = "{!! $settings->prefix !!}"
         //ajax
         $.get(url+'/finance/retrive_client/'+client_id, function(data){
            //success data
            //
            $('#invoice_no').empty();
            $.each(data, function(invoices, info){
               $('#invoice_no').append('<option value="'+ info.id +'">'+prefix+''+info.invoice_number+' | '+code+''+info.balance+' | '+info.invoice_title+'</option>');
            });
         });
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
