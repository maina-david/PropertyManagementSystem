@extends('layouts.app')
{{-- page header --}}
@section('title','All Requests')

@section('sidebar')
@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Leave</li>
         <li class="breadcrumb-item active">Requests</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">All Requests</h1>
		@include('partials._messages')
		<!-- begin widget-list -->
		<div class="row">
			<div class="col-md-9">
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
										<i class="fas fa-calendar-times fa-4x text-danger"></i>
									@endif
									@if($leave->statusID == 19)
										<i class="fas fa-calendar-check fa-4x text-success"></i>
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
										<b>{!! $leave->days !!} days</b>
										<br>
										Status : <span class="badge {!! $leave->statusName !!}">{!! $leave->statusName !!}</span>
									</p>
								</div>
								<div class="widget-list-action">
									<a href="#" data-toggle="dropdown" class="text-muted pull-right">
										<i class="fa fa-ellipsis-h f-s-14"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="{!! route('hrm.leave.edit',$leave->leaveID) !!}">Edit</a></li>
										@if($leave->statusID  != 19)
											<li><a href="{!! route('hrm.leave.approve',$leave->leaveID) !!}">Approve</a></li>
										@endif
										@if($leave->statusID  != 20)
											<li><a href="{!! route('hrm.leave.denay',$leave->leaveID) !!}">Denay</a></li> 
										@endif
										@permission('delete-leave')
											<li><a href="{!! route('hrm.leave.delete',$leave->leaveID) !!}">Delete</a></li>
										@endpermission
									</ul>
								</div>
							</div>
							<!-- end widget-list-item -->
						</div>
					@endforeach
				</div>
			</div>
			<div class="col-md-3">
				<div class="card">
					<div class="card-body">
						<div class="leave-tip">
							<h2>{!! $current !!}</h2>
							<p>Employees on leave currently</p>
						</div>
						<div class="leave-tip">
							<h2>{!! $pending !!}</h2>
							<p>Pending Requests</p>
						</div>
						<div class="leave-tip">
							<h2>{!! $approved !!}</h2>
							<p>Approved Request</p>
						</div>
						<div class="leave-tip">
							<h2>{!! $rejected !!}</h2>
							<p>Rejected Request</p>
						</div>
						{{-- <center><a href="" class="btn btn-pink mt-3"><i class="fas fa-calendar-week"></i> View Leave Calender</a></center> --}}
					</div>
				</div>
			</div>
		</div>
	   <!-- end widget-list -->
	</div>
@endsection
@section('scripts')

@endsection
