@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Edit Payments @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.show',$property->id) !!}">{!! $property->title !!}</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.payments',$property->id) !!}">Payments</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Edit Payments</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12 mt-3">   
            {!! Form::model($payment, ['route' => ['property.payments.update',[$property->id,$payment->paymentID]], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
               <div class="row">
                  <div class="col-md-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4 class="panel-title">Payment Details</h4>
                        </div>
                        <div class="panel-body">
                           <div class="form-group form-group-default">
                              <label class="text-danger">Tenant</label>
                              <input type="text" class="form-control"  value="{!! $payment->tenant_name !!}" readonly>
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
                           </div>
                           <div class="form-group form-group-default">
                              {!! Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')) !!}
                              <select name="payment_method" class="form-control multiselect">
                                 @if(Finance::check_payment_method($payment->payment_method) == 1)
                                    <option value="{!! $payment->payment_method !!}">{!! Finance::payment_method($payment->payment_method)->name !!}</option>
                                 @else 
                                    <option value="">Choose payment method</option>
                                 @endif
                                 @foreach($mainMethods as $main)
                                    <option value="{!! $main->id !!}">{!! $main->name !!}</option>
                                 @endforeach
                                 @foreach($paymentmethod as $method)
                                    <option value="{!! $method->id !!}">{!! $method->name !!}</option>
                                 @endforeach
                              </select> 
                           </div>
                           <div class="form-group form-group-default">
                              <label class="text-danger">Invoice Number</label>
                              <input type="text" class="form-control" value="{!! $invoice->invoice_prefix !!}{!! $invoice->invoice_number !!}" readonly>
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
                           <div class="row">
                              @foreach ($files as $file)
                                 <div class="col-md-2">
                                    @if(stripos($file->file_mime, 'image') !== FALSE)
                                       <img src="{!! asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/payments/'.$file->file_name) !!}" alt="" style="width:100%;height:80px">
                                    @elseif(stripos($file->file_mime, 'pdf') !== FALSE)
                                       <center><i class="fas fa-file-pdf fa-4x" style="width:100%;height:80px"></i></center>
                                    @elseif(stripos($file->file_mime, 'octet-stream') !== FALSE)
                                       <center><i class="fas fa-file-alt fa-4x" style="width:100%;height:80px"></i></center>
                                    @elseif(stripos($file->file_mime, 'officedocument') !== FALSE)
                                       <center><i class="fas fa-file-word fa-4x" style="width:100%;height:80px"></i></center>
                                    @else
                                       <center><i class="fas fa-file fa-4x" style="width:100%;height:80px"></i></center>
                                    @endif
                                    <center>
                                       <a href="{!! route('property.payments.delete.file',[$property->id,$file->id,$payment->paymentID]) !!}" title="delete" class="delete badge badge-danger badge-sm"><i class="fas fa-trash"></i></a>
                                       <a href="{!! asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/payments/'.$file->file_name) !!}" title="download" class="badge badge-primary badge-sm mt-1"><i class="fas fa-download"></i></a>
                                       <a href="{!! asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/payments/'.$file->file_name) !!}" title="view" class="badge badge-sm badge-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
                                    </center>
                                 </div>
                              @endforeach
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="btn-toolbar col-md-12">
                     <button type="submit" id="" class="btn btn-success submit"><i class="fas fa-save"></i> Update Payment</button>
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
         $.get(url+'/property/'+propertyID+'/invoice/'+tenantID, function(data){
            //success data
            $('#invoice_no').empty();
            $.each(data, function(invoices, info){
               $('#invoice_no').append('<option value="'+ info.id +'">'+info.invoice_prefix+''+info.invoice_number+' | '+code+''+info.balance+' | '+info.invoice_title+'</option>');
            });
         });
      });
   </script>
@endsection
