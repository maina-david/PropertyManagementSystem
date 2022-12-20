@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $lead->customer_name !!} | Lead Details @endsection
{{-- page styles --}}


{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}} 
@section('content')
   <div id="content" class="content">
      <div class="row">
         {{-- @include('app.crm.leads._sidebar') --}}
         <div class="col-md-12">
            <div class="row mb-3">
               <div class="col-md-6"><h3>{!! $lead->customer_name !!}</h3></div>
               <div class="col-md-6">
                  <div class="float-right">
                     <a href="{!! route('crm.leads.edit',$customerID) !!}" class="btn btn-primary"><i class="fas fa-phone-volume"></i> Edit</a>
                     <a href="{!! route('crm.leads.send',$customerID) !!}" class="btn btn-white"><i class="fas fa-paper-plane"></i> Send Email</a>
                     @if($lead->category != "")
                        <a href="{!! route('crm.leads.convert',$customerID) !!}" class="btn btn-success delete"> Convert to customer</a>
                     @endif
                     <a href="{!! route('crm.leads.delete', $customerID) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                  </div>
               </div>
            </div>
            @include('app.crm.leads._nav')
            @include('partials._messages')
            @if(Request::is('crm/leads/'.$customerID.'/show'))
               @include('app.crm.leads.view')
            @endif
            @if(Request::is('crm/leads/'.$customerID.'/calllog'))
               @include('app.crm.leads.calllog.index')
            @endif
            @if(Request::is('crm/leads/'.$customerID.'/notes'))
               @include('app.crm.leads.notes.notes')
            @endif
            @if(Request::is('crm/leads/'.$customerID.'/tasks'))
               @include('app.crm.leads.tasks.index')
            @endif
            @if(Request::is('crm/leads/'.$customerID.'/events'))
               @include('app.crm.leads.events.index')
            @endif
            @if(Request::is('crm/leads/'.$customerID.'/mail'))
               @include('app.crm.leads.mail.index')
            @endif
            @if(Request::is('crm/leads/'.$customerID.'/send'))
               @include('app.crm.leads.mail.send')
            @endif

            @if(Request::route()->getName() == 'crm.leads.details')
               @include('app.crm.leads.mail.details')
            @endif
            @if(Request::is('crm/leads/'.$customerID.'/sms'))
               @include('app.crm.leads.sms.index')
            @endif
            @if(Request::is('crm/leads/'.$customerID.'/documents'))
               @include('app.crm.leads.documents.index')
            @endif
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
