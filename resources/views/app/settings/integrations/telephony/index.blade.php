@extends('layouts.app')
{{-- page header --}}
@section('title','Telephony')

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a href="#" class="btn btn-pink" data-toggle="modal" data-target=".gateway"><i class="fas fa-plus"></i> Add Telephony</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-phone-volume"></i> Telephony </h1>
      <!-- begin row -->
      @include('partials._messages')
      <div class="row">
         @foreach ($businessTelephony as $provider)
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <a href="#">
                        <center>
                           <img alt="{!! $provider->name !!}" src="{!! asset('assets/img/telephony/'.$provider->logo) !!}" class="img-responsive payment-logo">
                        </center>
                     </a>
                  </div>
                  <div class="panel-body">
                     <h3 class="text-center">{!! $provider->name !!}.</h3>
                     @if($provider->telephonyID == 1)
                        <a href="{!! route('settings.integrations.telephony.twilio.edit',$provider->businessTelephonyID) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     @endif
                     @if($provider->telephonyID == 2)
                        <a href="{!! route('settings.integrations.telephony.africasTalking.edit',$provider->businessTelephonyID) !!}" class="btn btn-pink btn-sm mt-3"><i class="fas fa-edit"></i> Edit details</a>
                     @endif                     
                     @if($provider->telephonyStatus == 15)
                        <a href="#" class="btn btn-sm btn-success float-right mt-3">Active</a>
                     @else 
                        <a href="#" class="btn btn-sm btn-warning float-right mt-3">Inactive</a>
                     @endif
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   </div>

   <!-- Modal -->
   <form action="{!! route('settings.integrations.telephony.store') !!}" method="post">
      <div class="modal fade gateway" tabindex="-1" role="dialog" aria-labelledby="gatewayTitle" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            @csrf
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Add Telephony</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group form-group-default">
                     <label for="">Choose Telephony</label>
                     {!! Form::select('telephony',$telephony, null,['class' => 'form-control'] ) !!}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="">Choose status</label>
                     {!! Form::select('status',['' => 'Choose status','15' => 'Active', '23' => 'Dormant'], null,['class' => 'form-control'] ) !!}
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Telephony</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </div>
            </div>
         </div>
      </div>
   </form>
@endsection

