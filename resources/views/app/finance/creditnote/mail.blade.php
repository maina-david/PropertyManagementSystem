@extends('layouts.app')
{{-- page header --}}
@section('title','Mail Credit note')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.creditnote.show',$details->creditnoteID) !!}" class="btn btn-pink"><i class="fas fa-chevron-left"></i> Back to view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Mail Credit note To {!! $client->customer_name !!}</h1>
		@include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="" action="{!! route('finance.creditnote.mail.send') !!}" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="creditnoteID" value="{!! $details->creditnoteID !!}" required>
                     @csrf
                     <div class="form-group col-md-12">
   							<label for="">Form</label>
   							<input type="email" name="email_from" value="{!! $details->primary_email !!}" class="form-control">
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Send To</label>
                        <input type="text" name="send_to" value="{!! $client->email !!}" class="form-control" required readonly>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Cc</label>
                        <select name="email_cc[]" id="" class="form-control multiselect" style="width:100%" multiple>
                           @if($client->email_cc != "")
   								   <option value="{!! $client->email_cc !!}">{!! $client->email_cc !!}</option>
                           @endif
   								@foreach ($contacts as $contact)
   									<option value="{!! $contact->contact_email !!}">{!! $contact->contact_email !!}</option>
   								@endforeach
   							</select>
   						</div>
   						<div class="form-group col-md-12">
   							<label for="">Subject</label>
   							<input type="text" name="subject" value="Credit note - {!!  $details->prefix !!}{!! $details->creditnote_number !!}" class="form-control" required>
   						</div>
   						<div class="form-group col-md-12">
   							<textarea name="message" cols="30" rows="10" class="ckeditor" required>
   								<span style="font-size: 12pt;">Dear {!! $client->customer_name !!}</span>
                           <br/><br/>
                           <span style="font-size: 12pt;">Please find the attached Credit note <strong># {!!  $details->prefix !!}{!! $details->creditnote_number !!}</strong></span>
                           <br/><br/>
                           <span style="font-size: 12pt;"><strong>Credit note status:</strong> <em>{!! ucfirst($details->statusName) !!}</em></span>
                           <br/><br/>
                           <span style="font-size: 12pt;">We look forward to your communication.</span>
                           <br/><br/>
                           <span style="font-size: 12pt;">Kind Regards,</span>
                           <br/>
                           <span style="font-size: 12pt;">
                              <b>
                                 {!! $details->businessName !!}
                              </b>
                           <br /></span>
   							</textarea>
   						</div>
   						<div class="form-group mt-3">
   							<input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-2" checked>
   							<label for="">Attach Credit note</label><br>
                        <a href="{!! asset('businesses/'.$details->businessID.'/finance/creditnote/'.$details->prefix.$details->creditnote_number.'.pdf') !!}" target="_blank" class="ml-3"> Preview current Attached Credit note</a>
         						
   						</div>
   						<div class="form-group">
   							<label for="">Attach Files</label>
   							<select name="attach_files[]" class="form-control multiselect" multiple>
   								@foreach ($files as $file)
   									<option value="{!! $file->id !!}">{!! $file->file_name !!}</option>
   								@endforeach
   							</select>
   						</div>
                     <div class="form-group mt-5">
                        <button type="submit" name="button" class="offset-md-10 btn btn-pink submit"><i class="fas fa-paper-plane"></i> Send Credit note</button>
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

