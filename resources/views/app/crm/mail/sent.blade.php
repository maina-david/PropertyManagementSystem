@extends('layouts.app')
{{-- page header --}}
@section('title','Sent Mail')
{{-- page styles --}}
@section('stylesheet')
	<style>
	</style>
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<!-- begin #content -->
<div class="content">
	<!-- begin breadcrumb -->
	<ol class="breadcrumb pull-right">
		<li class="breadcrumb-item"><a href="javascript:;">CRM</a></li>
		<li class="breadcrumb-item"><a href="#">Email</a></li>
		<li class="breadcrumb-item active">List</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="far fa-paper-plane"></i> Sent Emails </h1>
	<!-- Right Sidebar -->
	<div class="row">
		<div class="col-md-12">		
			<div class="card">
				<div class="card-body">
					<!-- Left sidebar -->
					@include('app.crm.mail._nav')
					
					<!-- End Left sidebar -->

					<div class="page-aside-right">
						{{-- <div class="btn-group">
							<button type="button" class="btn btn-secondary"><i class="mdi mdi-archive font-16"></i></button>
							<button type="button" class="btn btn-secondary"><i class="mdi mdi-alert-octagon font-16"></i></button>
							<button type="button" class="btn btn-secondary"><i class="mdi mdi-delete-variant font-16"></i></button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-secondary dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
									<i class="mdi mdi-folder font-16"></i>
									<i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu">
									<span class="dropdown-header">Move to:</span>
									<a class="dropdown-item" href="javascript: void(0);">Social</a>
									<a class="dropdown-item" href="javascript: void(0);">Promotions</a>
									<a class="dropdown-item" href="javascript: void(0);">Updates</a>
									<a class="dropdown-item" href="javascript: void(0);">Forums</a>
							</div>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-secondary dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
									<i class="mdi mdi-label font-16"></i>
									<i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu">
									<span class="dropdown-header">Label as:</span>
									<a class="dropdown-item" href="javascript: void(0);">Updates</a>
									<a class="dropdown-item" href="javascript: void(0);">Social</a>
									<a class="dropdown-item" href="javascript: void(0);">Promotions</a>
									<a class="dropdown-item" href="javascript: void(0);">Forums</a>
							</div>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-secondary dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false">
								<i class="mdi mdi-dots-horizontal font-16"></i> More
								<i class="mdi mdi-chevron-down"></i>
							</button>
							<div class="dropdown-menu">
								<span class="dropdown-header">More Options :</span>
								<a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a>
								<a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
								<a class="dropdown-item" href="javascript: void(0);">Add Star</a>
								<a class="dropdown-item" href="javascript: void(0);">Mute</a>
							</div>
						</div> --}}

						<div class="mt-3">
							<ul class="list-group list-group-lg no-radius list-email">
								@foreach ($emails as $email)
									<li class="list-group-item">
										<div class="email-checkbox">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox1">
												<label class="custom-control-label" for="emailCheckbox1"></label>
											</div>
										</div>
										<a href="{!! route('crm.mail.details',$email->mailID) !!}" class="email-user bg-blue">
											<span class="text-white">{!! mb_substr($email->customer_name, 0, 1); !!}</span>
										</a>
										<div class="email-info">
											<a href="{!! route('crm.mail.details',$email->mailID) !!}">
												<span class="email-sender"><b>{!! $email->customer_name !!}</b></span>
												<span class="email-title">{!! $email->subject !!}</span>
												<span class="email-time">{!! date('jS M, Y', strtotime($email->sentDate)) !!}</span>
											</a>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
						<!-- end .mt-4 -->

						<div class="row">
							<div class="col-7 mt-3">
									Showing 1 - {!! $emails->currentPage() * 16 !!} of {!! $totalEmails !!}
							</div> <!-- end col-->
							<div class="col-5 mt-3">
								<div class="btn-group float-right">
									@if ($emails->lastPage() > 1)
										<a href="{{ $emails->url(1) }}" class="btn btn-light btn-sm"><i class="mdi mdi-chevron-left"></i></a>
										<a href="{{ $emails->url($emails->currentPage()+1) }}" class="btn btn-info btn-sm"><i class="mdi mdi-chevron-right"></i></a>
									@endif
								</div>
							</div> <!-- end col-->
						</div>
						<!-- end row-->
					</div> 
					<!-- end inbox-rightbar-->
				</div>
				<!-- end card-body -->
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- end #content -->
@endsection
{{-- page scripts --}}
@section('scripts')
	
@endsection
