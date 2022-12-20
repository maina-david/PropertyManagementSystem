@extends('layouts.app')
{{-- page header --}}
@section('title')Mail To {!! $details->customer_name !!} @endsection 
{{-- page styles --}}
@section('stylesheet')
@endsection
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.payments.show',$details->invoicePaymentID) !!}" class="btn btn-pink"><i class="fas fa-chevron-left"></i> Back to view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Mail To {!! $details->customer_name !!}</h1>
		@include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="" action="{!! route('finance.payments.send') !!}" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="paymentID" value="{!!$details->invoicePaymentID !!}" required>
                     @csrf
                     <div class="form-group col-md-12">
   							<label for="">Form</label>
   							<input type="email" name="email_from" value="{!!$details->primary_email !!}" class="form-control">
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Send To</label>
                        <input type="text" name="send_to" value="{!! $details->email !!}" class="form-control" required readonly>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Cc</label>
                        <select name="email_cc[]" id="" class="form-control multiselect" style="width:100%" multiple>
                           @if($details->email_cc != "")
   								   <option value="{!! $details->email_cc !!}">{!! $details->email_cc !!}</option>
                           @endif
   								@foreach ($contacts as $contact)
   									<option value="{!! $contact->contact_email !!}">{!! $contact->contact_email !!}</option>
   								@endforeach
   							</select>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Subject</label>
   							<input type="text" name="subject" value="Payment Received by {!! $details->businessName !!}" class="form-control" required>
   						</div>
   						<div class="form-group col-md-12">
   							<textarea name="message" cols="30" rows="10" class="ckeditor" required>
   								<h2><strong>Payment Received</strong></h2>
                           <p>Dear {!! $details->customer_name !!},<br/><br/>
                           Thank you for your payment. It was a pleasure doing business with you. We look forward to working together again!</p>
                           <div style="background:#fefff1; border:1px solid #e8deb5; padding:3%">
                              <h3>Payment Received</h3>
                              <h2>{!! $details->code !!} {!! number_format($details->amount) !!}</h2>
                              <p>Invoice No : <strong>{!! $details->prefix !!}{!! $details->invoice_number !!}</strong></p>
                              <p>&nbsp;</p>
                              <p>Payment Date<strong>{!! date('jS F, Y', strtotime($details->payment_date)) !!}</strong></p>
                           </div>
   							</textarea>
   						</div>
   						<div class="form-group mt-3">
   							<input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-2" checked>
   							<label for="">Attach Receipt</label><br>
                        <a href="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/payments/'.$details->invoicePaymentID.'payment.pdf') !!}" target="_blank" class="ml-3" id="preview"> Preview current Attached Receipt</a>
   						</div>
                     <div class="form-group mt-5">
                        <button type="submit" name="button" class="offset-md-10 btn btn-pink submit"><i class="fas fa-paper-plane"></i> Send Receipt</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      $('#attach').click(function(){
         this.checked?$('#preview').show(1000):$('#preview').hide(1000); //time for show
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection

