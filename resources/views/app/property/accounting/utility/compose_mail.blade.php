@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Utility Billing | Compose Mail @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 

{{-- content section --}} 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="#">Accounting</a></li>
         <li class="breadcrumb-item"><a href="#">Utility Billing</a></li>
         <li class="breadcrumb-item active"><a href="{!! route('property.utility.billing.show',[$propertyID,$invoice->invoiceID]) !!}">{!! $invoice->invoice_prefix.$invoice->invoice_number !!}</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Utility Billing | Compose Mail </h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12">
            <div class="col-md-8">
               <div class="panel panel-inverse">
                  <div class="panel-body">
                     <form class="" action="{!! route('property.utility.send.mail',$propertyID) !!}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="invoiceID" value="{!! $invoice->invoiceID !!}" required>
                        @csrf
                        <div class="form-group col-md-12">
                           <label for="">Form</label>
                           <input type="email" name="email_from" value="{!! $invoice->primary_email !!}" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                           <label for="">Send To</label>
                           <input type="text" name="send_to" value="{!! $tenant->contact_email !!}" class="form-control" required readonly>
                        </div>
                        <div class="form-group col-md-12">
                           <label for="">Cc</label>
                           <select name="email_cc[]" id="" class="form-control multiselect" style="width:100%" multiple>
                              @if($tenant->email_cc != "")
                                 <option value="{!! $tenant->email_cc !!}">{!! $tenant->email_cc !!}</option>
                              @endif
                              @foreach ($contacts as $contact)
                                 <option value="{!! $contact->contact_email !!}">{!! $contact->contact_email !!}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group col-md-12">
                           <label for="">Subject</label>
                           <input type="text" name="subject" value="Invoice - {!! $invoice->prefix !!}{!! $invoice->invoice_number !!} from {!! $invoice->business_name !!}" class="form-control" required>
                        </div>
                        <div class="form-group col-md-12">
                           <textarea name="message" cols="30" rows="10" class="my-editor" required>
                              <span>Dear {!! $tenant->tenant_name !!}</span><br><br>
                              <span><em><b>Bill Payment.</b></em></span><br>
                              <span>Utility No <b>: {!! $invoice->utility_No !!}</b>.</span><br/>
                              <span>Previous Consumption <b>: {!! number_format($product->previous_units,2) !!}</b>.</span><br/>
                              <span>Current Consumption <b>: {!! number_format($product->current_units,2) !!}</b>.</span><br/>
                              <span>Consumption <b>: {!! number_format($product->current_units - $product->previous_units,2) !!}</b>.</span><br/>
                              <span>Price Per Unit <b>: {!! $invoice->code !!}{!! $product->price !!}</b>.</span><br/>
                              <span>Bill Total <b>: {!! $invoice->code !!}{!! $invoice->bill_total !!}</b>.</span><br/>
                              <span>Amount Paid <b>: {!! $invoice->code !!}{!! $invoice->bill_paid !!}</b>.</span><br/>
                              @if($balance != 0) 
                                 <span>Account Arrears <b>: {!! $invoice->code!!} {!! number_format($balance,2) !!}</b>.</span><br/>
                              @endif
                              -----------------------------------------------------------------------------------------------------------------------<br>
                              <span style="font-size: 12pt;">Please contact us for more information.</span><br /><br />
                              <span style="font-size: 12pt;">Kind Regards,</span><br />
                              <span style="font-size: 12pt;">{!! $invoice->business_name !!}</span>
                           </textarea>
                        </div>
                        <div class="form-group mt-3">
                           <input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-2" checked>
                           <label for="">Attach Invoice</label><br>
                           <a href="{!! asset('businesses/'.$invoice->businessID.'/property/'.$property->property_code.'/utility/'.$invoice->invoice_prefix.$invoice->invoice_number.'.pdf') !!}" target="_blank" class="ml-3" id="preview"> Preview current Attached Invoice</a>
                        </div>
                        <div class="form-group col-md-12" style="display:none">
                           <label for="">Attach Files</label>
                           <select name="attach_files[]" class="form-control multiselect" style="width:100%" multiple>
                              @foreach ($files as $file)
                                 <option value="{!! $file->id !!}">{!! $file->file_name !!}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group mt-5">
                           <button type="submit" name="button" class="btn btn-success submit"><i class="fas fa-save"></i> Send Invoice</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>    
      </div> 
   </div>
@endsection
@section('script2')
   <script type="text/javascript">
      $('#attach').click(function(){
         this.checked?$('#preview').show(1000):$('#preview').hide(1000); //time for show
      });
   </script>
@endsection