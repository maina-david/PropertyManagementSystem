@extends('layouts.app')
{{-- page header --}}
@section('title','Digital Marketing Accounts')
{{-- page styles --}}
@section('stylesheet')

@endsection

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
         <li class="breadcrumb-item"><a href="#">Digital Marketing</a></li>
         <li class="breadcrumb-item">Accounts</li>
         <li class="breadcrumb-item active">Channels</li>
      </ol>
      <!-- end breadcrumb --> 
      <!-- begin page-header -->
      <h1 class="page-header">Channels</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="row">
         <div class="col-md-7">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Account Channels</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <th width="1%">#</th>
                        <th>Medium</th>
                        <th>Channel</th>
                        <th>Date Added</th>
                        <th width="26%">Action</th>
                     </thead>
                     <tbody>
                        @foreach ($channels as $channel)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $channel->name !!}</td>
                              <td>{!! $channel->channel_name !!}</td>
                              <td>{!! date('d F, Y', strtotime($channel->channel_date)) !!}</td>
                              <td>
                                 <a href="{!! route('crm.channel.edit',[$channel->accountID,$channel->channelID]) !!}" class="btn btn-pink"><i class="fas fa-edit"></i> Edit</a>
                                 <a href="{!! route('crm.channel.delete',$channel->channelID) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-5">
            <div class="panel panel-default">
               <div class="panel-heading">
                  Add channel to account
               </div>
               <div class="panel-body">
                  <form action="{!! route('crm.channel.store') !!}" method="post">
                     @csrf
                     <input type="hidden" name="accountID" value="{!! $accountID !!}" required>  
                     <div class="form-group form-group-default">
                        <label for="">Medium</label>
                        {!! Form::select('medium',$mediums,null,['class'=>'form-control multiselect']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Channel name</label>
                        {!! Form::text('channel_name',null,['class'=>'form-control','placeholder' => 'Enter channel name']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Client ID</label>
                        {!! Form::text('client_id',null,['class'=>'form-control','placeholder' => 'Enter Client ID']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Client secret</label>
                        {!! Form::text('client_secret',null,['class'=>'form-control','placeholder' => 'Enter Client secret']) !!}
                     </div>
                     <div class="form-group form-group-default">
                        <label for="">Redirect</label>
                        {!! Form::text('redirect',null,['class'=>'form-control','placeholder' => 'Enter redirect URL']) !!}
                     </div>
                     <div class="form-group">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Save Channel</button>
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