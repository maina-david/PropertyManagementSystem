@extends('layouts.app')
{{-- page header --}}
@section('title','Mail Quote')
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('finance.quotes.show',$quote->quoteID) !!}" class="btn btn-pink"><i class="fas fa-chevron-left"></i> Back to view</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Mail Quote To {!! $client->customer_name !!}</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <form class="" action="{!! route('finance.quotes.mail.send') !!}" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="quoteID" value="{!! $quote->quoteID !!}" required>
                     @csrf
                     <div class="form-group col-md-12">
                        <label for="">Form</label>
                        <input type="email" name="email_from" value="{!! $quote->primary_email !!}" class="form-control">
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
                        <input type="text" name="subject" value="{!! $quote->businessName !!} Quote - {!! $quote->prefix !!}{!! $quote->quote_number !!}  Has been sent to you" class="form-control" required>
                     </div>
                     <div class="form-group col-md-12">
                        <textarea name="message" cols="30" rows="10" class="ckeditor" required>
                           <span style="font-size: 17pt;">Dear <b>{!! $client->customer_name !!}</b></span>
                           <br/><br/>
                           <span style="font-size: 12pt;">Please find the attached Quote <strong># {!! $quote->prefix !!}{!! $quote->quote_number !!}</strong></span>
                           <br/><br/>
                           {{-- <span style="font-size: 12pt;"><strong>Quotes status:</strong> <em>{!! $quote->status !!}</em></span>
                           <br/><br/> --}}
                           {{-- <span style="font-size: 12pt;">You can view the Quote on the following link: <a href="{!! url('/') !!}/storage/files/clients/{!! $quote->email !!}/finance/estimate/{!! $quote->file !!}">{!! $quote->prefix !!}{!! $quote->quote_number !!}</a></span>
                           <br/><br/> --}}
                           <span style="font-size: 12pt;">We look forward to your communication.</span>
                           <br/><br/>
                           <span style="font-size: 12pt;">Kind Regards,</span>
                           <br/><br/>
                           <span style="font-size: 12pt;">
                              <b>
                                 {!! $quote->businessName !!}
                              </b>
                           </span>
                        </textarea>
                     </div>
                     <div class="form-group mt-3">
                        <input type="checkbox" value="Yes" name="attaches" id="attach" class="ml-3" checked>
                        <label for="">Attach PDF Quote</label><br>
                        <a href="{!! asset('businesses/'.$quote->business_code.'/finance/quotes/'.$quote->prefix.$quote->quote_number) !!}.pdf" target="_blank" class="ml-3"> Preview current Attached Quote</a>
                     </div>
                     <div class="form-group col-md-12">
                        <label for="">Attach Files</label>
                        <select name="attach_files[]" class="form-control multiselect" style="width:100%" multiple>
                           @foreach ($files as $file)
                              <option value="{!! $file->id !!}">{!! $file->file_name !!}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group mt-5">
                        <center>
                           <button type="submit" name="button" class="btn btn-pink submit"><i class="fas fa-paper-plane"></i> Send Quote</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                        </center>
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
