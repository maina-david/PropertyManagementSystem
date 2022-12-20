@extends('layouts.app')
@section('title','Human Resource ')
@section('sidebar')
@include('app.hr.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- end page-header -->
      <div class="row">
         <div class="col-md-12">
            @include('partials._messages')
         </div>
      </div>
      <!-- begin row --> 
      <div class="row">
         <!-- begin col-3 -->
         <div class="col-lg-4 col-md-4">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-users fa-fw"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Employes</div>
                  <div class="stats-number">{!! $employees !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('hrm.employee.index') !!}" class="text-white">Total Employes</a></div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-4 col-md-4">
            <div class="widget widget-stats bg-gradient-red">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-users-medical fa-fw"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Active Employees</div>
                  <div class="stats-number">{!! $activeEmployees !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('hrm.employee.index') !!}" class="text-white">Total Active Employees</a></div>
               </div>
            </div>
         </div>
         <!-- end col-3 -->
         <!-- begin col-3 -->
         <div class="col-lg-4 col-md-4">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="far fa-calendar-alt fa-fw"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Leave Requests</div>
                  <div class="stats-number">{!! $leaveRequests !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc"><a href="{!! route('hrm.leave.index') !!}" class="text-white">Total leave request</a></div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header"><i class="fas fa-calendar-week"></i> Leave Reports</div>
                  <div class="card-body" style="min-height: 380px">
                     {!! $leaveReport->container() !!}
                  </div>
               </div>
            </div>  
         </div>
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
	<script src="{!! url('/') !!}/public/backend/plugins/chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
	{!! $leaveReport->script() !!} 
@endsection
