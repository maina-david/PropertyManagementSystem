@extends('layouts.app')
{{-- page header --}}
@section('title')@if($client->company_name != ""){!! $client->company_name !!} @else {!! $client->client_name !!} @endif | information @endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		{{-- <ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Client</a></li>
			<li class="breadcrumb-item active">Details</li>
		</ol> --}}
		<div class="row">
			<div class="col-md-3">
				<div class="card-box text-center">
               @if($client->image == "")
                  <img alt="{!! $client->names !!}" src="{!! "https://www.gravatar.com/avatar/". md5(strtolower(trim($client->contact_email))) . "?s=200&d=wavatar" !!}" class="img-circle" width="80" height="80">
               @else
                  <img width="150" height="150" alt="" class="img-circle" src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/clients/'.$client->contact_email .'/images/'.$client->image) !!}">
               @endif
					<h4 class="mb-1 mt-2">@if($client->company_name != ""){!! $client->company_name !!} @else {!! $client->client_name !!} @endif</h4>
					<p class="text-muted"><i class="fas fa-at"></i> {!! $client->contact_email !!}<br><i class="fas fa-phone"></i> {!! $client->primary_phone_number !!}</p>
					<a href="{{ route('finance.contact.edit', $client->cid) }}" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fas fa-user-edit"></i> Edit</a>
					<a href="#" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fas fa-envelope-open-text"></i> Send Email</a>
					<a href="{!! route('finance.contact.delete', $client->cid) !!}" class="btn btn-danger btn-xs waves-effect mb-2 waves-light"><i class="fas fa-trash"></i> Delete</a>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fas fa-file-invoice-dollar"></i> Billing Address</h4>
					</div>
					<div class="panel-body">
						<p><b>Billing Information</b></p>
						<p>{!! $client->bill_attention !!}<br>
							@if($client->bill_country != "")
							{!! Wingu::country($client->bill_country)->name !!}<br>
							@endif
							{!! $client->bill_city !!}<br>
							{!! $client->bill_street !!}<br>
							{!! $client->bill_state !!}<br>
							{!! $client->bill_address !!} - {!! $client->bill_zip_code !!}<br>
							{!! $client->bill_fax !!}</b>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fas fa-truck"></i> Shipping Address</h4>
					</div>
					<div class="panel-body">
						<p><b>Shipping Information</b></p>
						<p>{!! $client->ship_attention !!}<br>
							@if($client->ship_country != "")
							{!! Settings::country($client->ship_country)->name !!}<br>
							@endif
							{!! $client->ship_city !!}<br>
							{!! $client->ship_street !!}<br>
							{!! $client->ship_state !!}<br>
							{!! $client->ship_address !!} - {!! $client->ship_zip_code !!}<br>
							{!! $client->ship_fax !!}</b>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fas fa-info-circle"></i> Other Information</h4>
					</div>
					<div class="panel-body">
						<p>Currency Code <span class="float-right text-primary"> @if($client->currency != "") {!! Finance::currency($client->currency)->currency_name !!} - {!! Finance::currency($client->currency)->symbol !!} @endif</span></p>
						<p>Portal Status <span class="float-right text-primary">@if($client->portal != "") Portal Set @else Not Set @endif</span></p>
						<p>Portal Language <span class="float-right text-primary">@if($client->language != "") {!! Wingu::Language($client->language)->name !!} @endif </span></p>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row mb-3">
					<div class="col-md-6"></div>
					<div class="col-md-6">
						<a href="{{ route('finance.contact.edit', $client->cid) }}" class="btn btn-default"><i class="fas fa-user-edit"></i> Edit</a>
						<a href="#" class="btn btn-default"><i class="fas fa-paperclip"></i> Attach Files</a>
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"> New Transaction </button>
							<ul class="dropdown-menu pull-right">
								<li><a href="{!! route('finance.contact.invoices', $clientID) !!}">Invoice</a></li>
								<li><a href="">Customer Payment</a> </li>
								<li><a href="">Estimate</a> </li>
								<li><a href="">Recurring Invoice  </a> </li>
								<li><a href="">Credit Note</a> </li>
								<li><a href="">Expense</a> </li>
								<li><a href="">Recurring Expense</a> </li>
								<li class="divider"></li>
								<li> <a href="">Project</a> </li>
							</ul>
						</div>
						<div class="btn-group">
							<button data-toggle="dropdown" class="btn btn-default dropdown-toggle pull-right"> More </button>
							<ul class="dropdown-menu">
								<li><a href="#">Associate Templates</a></li>
								<li><a href="">Stop all Reminders</a></li>
								<li><a href="">Email Contact</a></li>
								<li class="divider"></li>
								<li><a href="">Configure Client Portal</a></li>
								<li><a href="">Clone</a></li>
								<li><a href="">Merge Contacts</a></li>
								<li class="divider"></li>
								<li><a href="">Mark as Inactive</a></li>
								<li><a href="">Delete</a></li>
							</ul>
						</div>
					</div>
				</div>
				@include('partials._messages')
				<!-- begin nav -->
				@include('app.finance.contacts.nav')
				<!-- end nav -->

				<!-- main client page -->
				@if(Request::is('finance/contact/'.$clientID.'/show'))
					<div class="contact-dashboard">
						<div class="row">
							<!-- begin col-3 -->
							<div class="col-lg-4 col-md-6">
								<div class="widget widget-stats bg-gradient-teal">
									<div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i></div>
									<div class="stats-content">
										<div class="stats-title">Unused Credits</div>
										<div class="stats-number">ksh 42,900</div>
										<div class="stats-progress progress">
											<div class="progress-bar" style="width: 100%;"></div>
										</div>
										<div class="stats-desc">view</div>
									</div>
								</div>
							</div>
							<!-- end col-3 -->
							<!-- begin col-3 -->
							<div class="col-lg-4 col-md-6">
								<div class="widget widget-stats bg-gradient-blue">
									<div class="stats-icon stats-icon-lg"><i class="fas fa-file-invoice-dollar fa-fw"></i></div>
									<div class="stats-content">
										<div class="stats-title">Outstanding Receivables</div>
										<div class="stats-number">ksh 180,200</div>
										<div class="stats-progress progress">
											<div class="progress-bar" style="width: 100%;"></div>
										</div>
										<div class="stats-desc">view</div>
									</div>
								</div>
							</div>
							<!-- end col-3 -->
							<!-- begin col-3 -->
							<div class="col-lg-4 col-md-6">
								<div class="widget widget-stats bg-gradient-purple">
									<div class="stats-icon stats-icon-lg"><i class="fas fa-hammer fa-fw"></i></div>
									<div class="stats-content">
										<div class="stats-title">Projects</div>
										<div class="stats-number">38,900</div>
										<div class="stats-progress progress">
											<div class="progress-bar" style="width: 100%;"></div>
										</div>
										<div class="stats-desc">view</div>
									</div>
								</div>
							</div>
							<!-- end col-3 -->
						</div>
						<!-- end row -->
						<div class="row">
							<!-- begin col-8 -->
							<div class="col-lg-12">
								<div class="widget-chart with-sidebar inverse-mode">
									<div class="widget-chart-content bg-black">
										<h4 class="chart-title">
											Income and Expense
										</h4>
										<div id="visitors-line-chart" class="widget-chart-full-width nvd3-inverse-mode" style="height: 260px;"></div>
									</div>
									<div class="widget-chart-sidebar bg-black-darker">
										<div class="chart-number">
											ksh 1,225,729
											<small>Total Income</small>
										</div>
										<div id="visitors-donut-chart" class="nvd3-inverse-mode p-t-10" style="height: 180px"></div>
										<ul class="chart-legend f-s-11">
											<li><i class="fa fa-circle fa-fw text-primary f-s-9 m-r-5 t-minus-1"></i> 34.0% <span>Income</span></li>
											<li><i class="fa fa-circle fa-fw text-success f-s-9 m-r-5 t-minus-1"></i> 56.0% <span>Expense</span></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- end col-8 -->
						</div>
					</div>
				@endif

				<!-- comments -->
				@if(Request::is('finance/contact/'.$clientID.'/comments'))
					@include('app.finance.contacts.comments')
				@endif

				<!-- invoice -->
				@if(Request::is('finance/contact/'.$clientID.'/invoices'))
					@include('app.finance.contacts.invoices')
				@endif
			</div>
		</div>
	</div>
@endsection
@section('scripts')
  
@endsection
