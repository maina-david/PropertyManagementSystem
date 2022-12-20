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

						<div class="mt-3">
                     <h5>
                        {!! $email->subject !!}
                        <span class="float-right">
                           Opened {!! $email->view_count !!} times
                        </span>
                     </h5>
                     <hr>
                     <div class="media mb-3 mt-1">
                        @if($email->image == "")
                           <img alt="{!! $email->customer_name !!}" src="{!! "https://www.gravatar.com/avatar/". md5(strtolower(trim($email->email))) . "?s=200&d=wavatar" !!}" class="d-flex mr-2 rounded-circle" width="40" height="40">
                        @else
                           <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/clients/'.$email->email.'/images/'.$email->image) !!}">
                        @endif
                        <div class="media-body">
                           <small class="float-right">{!! date('jS F, Y h:i:A', strtotime($email->sentDate)) !!}</small>
                           <h6 class="m-0 font-14">{!! $email->customer_name !!}</h6>
                           <small class="text-muted">To: {!! $email->mail_to !!}</small>
                        </div>
                     </div>

                     {!! $email->message !!}
                     {{-- <hr>

                     <h5 class="mb-3">Attachments</h5> --}}
                     {{-- 
                     <div class="row">
                           <div class="col-xl-4">
                              <div class="card mb-1 shadow-none border">
                                 <div class="p-2">
                                       <div class="row align-items-center">
                                          <div class="col-auto">
                                             <div class="avatar-sm">
                                                   <span class="avatar-title bg-primary-lighten text-primary rounded">
                                                      .ZIP
                                                   </span>
                                             </div>
                                          </div>
                                          <div class="col pl-0">
                                             <a href="javascript:void(0);" class="text-muted font-weight-bold">Hyper-admin-design.zip</a>
                                             <p class="mb-0">2.3 MB</p>
                                          </div>
                                          <div class="col-auto">
                                             <!-- Button -->
                                             <a href="javascript:void(0);" class="btn btn-link btn-lg text-muted">
                                                   <i class="dripicons-download"></i>
                                             </a>
                                          </div>
                                       </div>
                                 </div>
                              </div>
                           </div> <!-- end col -->
                           <div class="col-xl-4">
                              <div class="card mb-1 shadow-none border">
                                 <div class="p-2">
                                       <div class="row align-items-center">
                                          <div class="col-auto">
                                             <img src="assets/images/projects/project-1.jpg" class="avatar-sm rounded" alt="file-image">
                                          </div>
                                          <div class="col pl-0">
                                             <a href="javascript:void(0);" class="text-muted font-weight-bold">Dashboard-design.jpg</a>
                                             <p class="mb-0">3.25 MB</p>
                                          </div>
                                          <div class="col-auto">
                                             <!-- Button -->
                                             <a href="javascript:void(0);" class="btn btn-link btn-lg text-muted">
                                                   <i class="dripicons-download"></i>
                                             </a>
                                          </div>
                                       </div>
                                 </div>
                              </div>
                           </div> <!-- end col -->
                           <div class="col-xl-4">
                              <div class="card mb-0 shadow-none border">
                                 <div class="p-2">
                                       <div class="row align-items-center">
                                          <div class="col-auto">
                                             <div class="avatar-sm">
                                                   <span class="avatar-title bg-secondary rounded">
                                                      .MP4
                                                   </span>
                                             </div>
                                          </div>
                                          <div class="col pl-0">
                                             <a href="javascript:void(0);" class="text-muted font-weight-bold">Admin-bug-report.mp4</a>
                                             <p class="mb-0">7.05 MB</p>
                                          </div>
                                          <div class="col-auto">
                                             <!-- Button -->
                                             <a href="javascript:void(0);" class="btn btn-link btn-lg text-muted">
                                                   <i class="dripicons-download"></i>
                                             </a>
                                          </div>
                                       </div>
                                 </div>
                              </div>
                           </div> <!-- end col -->
                     </div>
                     <!-- end row--> --}}                        
                     {{-- <div class="mt-5">
                        <a href="" class="btn btn-secondary mr-2"><i class="mdi mdi-reply mr-1"></i> Resend</a>
                        <a href="" class="btn btn-light">Forward <i class="mdi mdi-forward ml-1"></i></a>
                     </div> --}}
                  </div>
						<!-- end .mt-4 -->
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
