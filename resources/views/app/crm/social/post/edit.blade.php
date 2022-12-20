@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Post')

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Social Media Marketing</a></li>
         <li class="breadcrumb-item active">Edit Post</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-bullhorn"></i> Edit Post</h1>
      <!-- end page-header -->
      @include('partials._messages') 
      <div class="row mb-3">
         <div class="col-md-12">
            <h4>
               Channels : 
               @foreach ($channels as $ch)
                  <a href="{!! route('crm.publications.post.channel',[$edit->id,$ch->id]) !!}" class="btn btn-sm btn-info">{!! $ch->channel_name !!}</a>
               @endforeach
            </h4>
         </div>
      </div>

      {!! Form::model($edit, ['route' => ['crm.publications.update',$edit->id], 'method'=>'post','class' => 'row']) !!}
         @csrf
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Edit Post</h4>
               </div>
               <div class="panel-body"> 
                  <div class="form-grou[">
                     <label for="">Post Title</label>
                     {!! Form::text('title', null,['class' => 'form-control','required' => '']) !!}
                  </div>
                  <div class="form-group"> 
                     <label for="">Account</label>
                     <select name="account" class="form-control" id="account"  required> 
                        @if($edit->accountID != "")
                           <option value="{!! $currentAccounts->accountID !!}">{!! $currentAccounts->customer_name !!}</option>
                        @else
                           <option value="">Choose account</option> 
                        @endif
                        @foreach($accounts as $account)
                           <option value="{!! $account->accountID !!}">{!! $account->customer_name !!}</option>
                        @endforeach 
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="">Select Channels</label>
                     <select class="form-control multiselect" id="channel" name="channel[]" multiple required="">
                        @foreach ($channels as $channel)
                           <option value="{!! $channel->id !!}" selected>{!! $channel->channel_name !!}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="">Post</label>
                     {!! Form::textarea('post', null,['class' => 'form-control','required' => '']) !!}
                  </div>
                  <hr>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Edit Post</h4>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="postlink" @if($edit->link != "") checked @endif>
                        <label class="custom-control-label" for="postlink">Add Link to the post</label>
                     </div>
                  </div>
                  @if($edit->link != "")
                     <div class="form-group" id="link">
                        <label for="">Link</label>
                        {!! Form::text('link',null,['class' => 'form-control','placeholder' => 'e.x https://winguplus.com/']) !!}
                     </div>
                     <div class="form-group" id="linkDetails">
                        <label for="">Link Description</label>
                        {!! Form::textarea('link_description', null,['class' => 'form-control','size' => '3x4', 'placeholder' => 'start typing....','maxlength' => '180']) !!}
                     </div>
                     <hr>
                  @endif
                  <div class="form-group">
                     <label for="">Add Images</label><br>
                     <input type="file" name="media[]" id="files" accept="audio/*,video/*,image/*" multiple>
                  </div>
                  <div class="form-group">
                     <label for="">When to post Specific day and time Open</label>
                     {!! Form::text('upload_time',null,['class' => 'form-control datetimepicker', 'placeholder' => 'choose date and time' ]) !!}
                  </div>
                  <div class="form-group">
                     <center>
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update post</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>
         </div>
      {!! Form::close() !!}
   </div>
@endsection
@section('scripts')
   <script type="text/javascript">
      $('#account').on('change',function(e){
         console.log(e);
         var account =  e.target.value;
         var url = "{{ url('/') }}"
         //ajax
         $.get(url+'/crm/marketing/retrive/channel/'+account, function(data){
            //success data
            //
            //$('#channel').empty();
            $.each(data, function(channel, info){
               $('#channel').append('<option value="'+ info.id +'">'+info.channel_name+'</option>');
            });
         });
      });
   </script> 
   <script type="text/javascript">
      $('#postlink').click(function(){
         this.checked?$('#link').show(1000):$('#linkDetails').hide(1000); //time for show
         this.checked?$('#linkDetails').show(1000):$('#linkDetails').hide(1000);
      });
   </script>
@endsection