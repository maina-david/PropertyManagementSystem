@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $employee->employee_name !!} | Details @endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content content-full-width">
   <div class="profile">
      <div class="profile-header">      
         <div class="profile-header-cover"></div>     
         <div class="profile-header-content">
            <div class="profile-header-img">
               @if ($employee->image != "")
                  <img class="rounded-circle" width="114" height="114" alt="{!! $employee->employee_name !!}" src="{!! asset('businesses/'.$employee->businessCode.'/hr/employee/images/'.$employee->image) !!}">
               @else
                  <img src="https://ui-avatars.com/api/?name={!! $employee->employee_name !!}&rounded=false&size=114" alt="">
               @endif
            </div>         
            <div class="profile-header-info">
               <h4 class="mt-0 mb-1">{!! $employee->employee_name !!}</h4>
               <p class="mb-2">
                  @if($employee->position !="")
                     @if(Hr::check_position($employee->position) == 1)
                        {!! Hr::position($employee->position)->name !!}
                     @endif
                  @endif
               </p>
               <a href="{{ route('hrm.employee.edit',$employee->employeeID) }}" class="btn btn-xs btn-yellow">Edit Profile</a>
            </div>
         </div>
         <ul class="profile-header-tab nav nav-tabs">
            <li class="nav-item"><a href="#" class="nav-link active">Overview</a></li>
            {{-- <li class="nav-item"><a href="#" class="nav-link">Contact Information</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Career</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Leave</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Benefits</a></li>
            <li class="nav-item"><a href="#" class="nav-link">User Account</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Documents</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Notes</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Assets</a></li>           
            <li class="nav-item"><a href="#" class="nav-link">Training</a></li> --}}
         </ul>      
      </div>
   </div>
</div>
<div id="content" class="content">
   <div class="row">
      <div class="col-md-3">
         <div class="card">
            <div class="card-body">
               <p>
                  <b>Name :</b> {!! $employee->employee_name !!}<br>
                  <b>Gender :</b> {!! $employee->gender !!}
               </p>
               <hr>
               <p>
                  <b>CompanyID :</b> {!! $employee->companyID !!}<br>
                  <b>Status :</b> @if($employee->statusID != "")<span class="badge {!! Wingu::status($employee->statusID)->name !!}">{!! Wingu::status($employee->statusID)->name !!} </span>@endif<br>
                  <b>Contract Type :</b> <span class="badge badge-warning">{!! $employee->contract_type !!}</span><br>
                  <b>Position :</b> 
                  @if($employee->position != "")
                     @if(Hr::check_position($employee->position) == 1)
                        {!! Hr::position($employee->position)->name !!}
                     @endif
                  @endif
                  <br>
               </p>
               <hr>
               <p>
                  <b>Personal Phone Number :</b> {!! $employee->personal_number !!} <br>
                  <b>Office Phone Number :</b> {!! $employee->company_phone_number !!} <br>
               </p>
               <hr>
               <p>
                  <b>Personal Email :</b> {!! $employee->personal_email !!} <br>
                  <b>Office Email :</b> {!! $employee->company_email !!} <br>
               </p>
            </div>
         </div>
         <div class="card">
            <div class="card-body">
               <p>
                  <b>Hire Date :</b> {!! date('F jS, Y', strtotime($employee->hire_date)) !!}<br>
                  <b>Source of hire :</b> {!! $employee->source_of_hire !!}
               </p>
               <hr>
               <p>
                  <b>Department :</b> 
                  @if($employee->department != "")
                     @if(Hr::check_department($employee->department) == 1)
                        {!! Hr::department($employee->department)->title !!}
                     @endif
                  @endif
                  <br>
               </p>
               @if(Hr::check_if_has_leader($employee->employeeID) > 0)
               <hr>
                  <p>
                     <b>Reporting to.</b><br>
                     @foreach(Hr::get_employee_leaders($employee->employeeID) as $leader)
                        <span class="badge badge-pink">{!! $leader->names !!}</span>
                     @endforeach                     
                  </p>
               @endif
               @if(Hr::check_if_heads_departments($employee->employeeID) > 0)
                  <hr>
                  <p>
                     <b>Department Head to:</b><br>
                     @foreach(Hr::get_heading_departments($employee->employeeID) as $department)
                     <span class="badge badge-primary">{!! $department->title !!}</span>
                     @endforeach
                  </p>
               @endif
            </div>
         </div>
      </div>
      <div class="col-md-9">
         <div class="card">
            <div class="card-body">
               {{-- <div class="row">
                  <div class="col-xl-4 col-md-6">
                     <div class="widget widget-stats bg-teal">
                        <div class="stats-icon stats-icon-lg"><i class="fal fa-calendar fa-fw"></i></div>
                        <div class="stats-content">
                           <div class="stats-title text-white">Remaining Leave Days</div>
                           <div class="stats-number">52</div>
                           <div class="stats-progress progress">
                              <div class="progress-bar" style="width: 70.1%;"></div>
                           </div>
                           <div class="stats-desc text-white">Remaining (70.1%)</div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-md-6">
                     <div class="widget widget-stats bg-blue">
                        <div class="stats-icon stats-icon-lg"><i class="fal fa-car-building fa-fw"></i></div>
                        <div class="stats-content">
                           <div class="stats-title text-white">Assets</div>
                           <div class="stats-number">5</div>
                           <div class="stats-progress progress">
                              <div class="progress-bar" style="width: 100%;"></div>
                           </div>
                           <div class="stats-desc"><a href="#" class="text-white">View All Assets</a></div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-md-6">
                     <div class="widget widget-stats bg-indigo">
                        <div class="stats-icon stats-icon-lg"><i class="fal fa-chart-line fa-fw"></i></div>
                        <div class="stats-content">
                           <div class="stats-title text-white">Current Performance Score</div>
                           <div class="stats-number">78%</div>
                           <div class="stats-progress progress">
                              <div class="progress-bar" style="width: 78%;"></div>
                           </div>
                           <div class="stats-desc">Performance Score (78%)</div>
                        </div>
                     </div>
                  </div>
               </div> --}}
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
