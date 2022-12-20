@extends('layouts.app')
@section('title',' My Leave List')
@section('sidebar')
@include('app.hr.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
         <li class="breadcrumb-item"><a href="#">Leave</a></li>
         <li class="breadcrumb-item active">My Leave List </li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fad fa-calendar-check"></i> My Leave List</h1>
      @include('partials._messages')
      <div class="row">
         @foreach ($leaves as $leave)
            <div class="widget-list widget-list-rounded mb-2 col-md-4">
               <!-- begin widget-list-item -->
               <div class="widget-list-item">
                  <div class="widget-list-media">
                     @if($leave->statusID == 7)
                        <i class="fas fa-calendar-day fa-4x"></i>
                     @endif
                     @if($leave->statusID == 20)
                        <i class="fas fa-calendar-times fa-4x"></i>
                     @endif
                     @if($leave->statusID == 19)
                        <i class="fas fa-calendar-check fa-4x"></i>
                     @endif
                  </div>
                  <div class="widget-list-content">
                     <h4 class="widget-list-title font-weight-bold">
                        {!! $leave->names !!}
                     </h4>
                     <p class="widget-list-desc">
                        <i class="text-info">
                           <b>
                              {!! $leave->leaveName !!}
                           </b>
                        </i>
                        <br>
                        From : <b>{!! date('d F, Y', strtotime($leave->start_date)) !!}</b><br>
                        To : <b>{!! date('d F, Y', strtotime($leave->end_date)) !!}</b><br>
                        <b>{!! Helper::date_difference($leave->end_date,$leave->start_date) !!} days</b>
                        <br>
                        Status : <span class="badge {!! $leave->statusName !!}">{!! $leave->statusName !!}</span>
                     </p>
                  </div>
                  <div class="widget-list-action">
                     <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                        <i class="fa fa-ellipsis-h f-s-14"></i>
                     </a>
                     <ul class="dropdown-menu dropdown-menu-right">
                        @if($leave->statusID  != 19)
                           <li><a href="{!! route('hrm.leave.apply.edit',$leave->leaveID) !!}">Edit</a></li>
                        @endif
                        @if($leave->end_date > new DateTime(""))
                           @if($leave->statusID  != 19)
                              <li><a href="#">Approve</a></li>
                           @endif
                           @if($leave->statusID  != 20)
                              <li><a href="#">Denay</a></li>
                           @endif
                        @endif
                     </ul>
                  </div>
               </div>
               <!-- end widget-list-item -->
            </div>
         @endforeach
      </div>
   </div>
@endsection
