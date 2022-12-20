@extends('layouts.app')
{{-- page header --}}
@section('title')
	Details |
	@if($client->contact_type == 'Individual') 
		{!! $client->salutation !!} {!! $client->customer_name !!}
	@else 
		{!! $client->customer_name !!}
	@endif
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<div class="row">
			<div class="col-md-3">
				<div class="card-box text-center"> 
               @if($client->image != "")
						<img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$client->customer_code.'/images/'.$client->image) !!}" alt="" style="width:90px;height:90px" class="rounded-circle">
					@else
						<img src="https://ui-avatars.com/api/?name={!! $client->customer_name !!}&rounded=true&size=90" alt="">
					@endif
					<h4 class="mb-1 mt-2">
						@if($client->contact_type == 'Individual') 
							{!! $client->salutation !!} {!! $client->customer_name !!}
						@else 
							{!! $client->customer_name !!}
						@endif
					</h4>  
					<p class="text-muted"><i class="fas fa-at"></i> {!! $client->email !!}<br><i class="fas fa-phone"></i> {!! $client->primary_phone_number !!}</p>
					<a href="{{ route('finance.contact.edit', $customerID) }}" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fal fa-edit"></i> Edit</a>
					@if(Wingu::business()->plan != 1)
						<a href="{!! route('finance.customer.mail',$customerID) !!}" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fal fa-paper-plane"></i> Send Email</a>
					@endif
					<a href="{!! route('finance.contact.delete', $customerID) !!}" class="btn btn-danger btn-xs waves-effect mb-2 waves-light delete"><i class="fas fa-trash"></i> Delete</a>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-file-invoice-dollar"></i> Billing Information</h4>
					</div>
					<div class="panel-body">
						<p>{!! $client->bill_attention !!}<br>
							@if($client->bill_country != "")
							{!! Wingu::country($client->bill_country)->name !!}<br>
							@endif
							{!! $client->bill_city !!}<br>
							{!! $client->bill_street !!}<br>
							{!! $client->bill_state !!}<br>
							{!! $client->bill_address !!}<br>
							{!! $client->bill_zip_code !!}<br>
							{!! $client->bill_fax !!}</br>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-shipping-fast"></i> Shipping Information</h4>
					</div>
					<div class="panel-body">
						<p>{!! $client->ship_attention !!}<br>
							@if($client->ship_country != "")
							{!! Wingu::country($client->ship_country)->name !!}<br>
							@endif
							{!! $client->ship_city !!}<br>
							{!! $client->ship_street !!}<br>
							{!! $client->ship_state !!}<br>
							{!! $client->ship_address !!} <br>
							{!! $client->ship_zip_code !!}<br>
							{!! $client->ship_fax !!}</br>
						</p>
					</div>
				</div>
				<div class="panel panel-default" data-sortable-id="ui-widget-1">
					<div class="panel-heading">
						<div class="panel-heading-btn">
							<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
						</div>
						<h4 class="panel-title"><i class="fal fa-users-medical"></i> Contact Persons</h4>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								@foreach ($contacts as $contact)
									<div class="row">
										<div class="col-md-3">
											<img src="https://ui-avatars.com/api/?name={!! $contact->names !!}&rounded=true&size=50" alt="">
										</div>
										<div class="col-md-9">
											<p>
												<b>Name :</b> <span class="text-pink">{!! $contact->names !!}</span><br>
												<b>Phone number :</b> <span class="text-pink">{!! $contact->phone_number !!}</span><br>
												<b>Email :</b> <span class="text-pink">{!! $contact->contact_email !!}</span><br>
												<b>Designation :</b> <span class="text-pink">{!! $contact->designation !!}</span><br>
											</p>
										</div>
										<div class="col-md-12">
											<hr>
										</div>
									</div>
								@endforeach								
							</div>
						</div>
					</div>
				</div>
				{{-- <div class="panel panel-default" data-sortable-id="ui-widget-1">
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
				</div> --}}
			</div>
			<div class="col-md-9">
				<div class="row mb-3">
					<div class="col-md-12">
                  <div class="float-right">
							<a href="{{ route('finance.contact.edit', $customerID) }}" class="btn btn-white"><i class="fas fa-edit"></i> Edit</a>
							@if(Wingu::business()->plan != 1)
								<a href="{{ route('finance.customer.send', $customerID) }}" class="btn btn-white"><i class="fal fa-paper-plane"></i> Send Mail</a>
							@endif
   						<div class="btn-group">
   							<button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> New Transaction </button>
   							<ul class="dropdown-menu pull-right">
   								<li><a href="{!! route('finance.invoice.product.create') !!}">Invoice</a></li>
									<li><a href="{!! route('finance.payments.create') !!}">Payment</a> </li>
									@if(Wingu::business()->plan != 1)
										<li><a href="{!! route('finance.quotes.create') !!}">Quotes</a> </li>
										<li><a href="{!! route('finance.creditnote.create') !!}">Credit Note</a> </li>
									@endif
   								<li class="divider"></li>
   								<li> <a href="">Project</a> </li>
   							</ul> 
   						</div>
   						<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-white dropdown-toggle pull-right"> More </button>
								<ul class="dropdown-menu">
									@if(Wingu::business()->plan != 1)
										<li><a href="{!! route('finance.customer.sms',$customerID) !!}"><i class="fal fa-sms"></i> SMS</a></li>
										<li><a href="{!! route('finance.customer.mail',$customerID) !!}"><i class="fal fa-paper-plane"></i> Mail</a></li>
									@endif
									<li class="divider"></li>
									<li><a href="{!! route('finance.customer.notes',$customerID) !!}"><i class="fal fa-sticky-note"></i> Notes</a></li>
									<li><a href="{!! route('finance.customer.events',$customerID) !!}"><i class="fal fa-calendar-alt"></i> Meeting</a></li>
									<li><a href="{!! route('finance.customer.calllog',$customerID) !!}"><i class="fal fa-phone-office"></i> Call log</a></li>
									<li class="divider"></li>									
									<li><a href="{!! route('finance.contact.delete', $customerID) !!}" class="delete"><i class="fas fa-trash"></i> Delete</a></li>
								</ul>
							</div>
							@if(Wingu::business()->plan != 1)
								<a href="{!! route('finance.customer.documents',$customerID) !!}" class="btn btn-white"><i class="fal fa-folder"></i> Documents</a>
							@endif
                  </div>
					</div>
				</div>
				@include('partials._messages')
				<!-- begin nav -->
				@include('app.finance.contacts._nav')
				<!-- end nav -->

				<!-- main client page -->
				@if(Request::is('finance/customer/'.$customerID.'/show'))
					@include('app.finance.contacts.show')					
				@endif

				<!-- comments -->
				@if(Request::is('finance/customer/'.$customerID.'/comments'))
					@include('app.finance.contacts.comments')
				@endif

				<!-- invoice -->
				@if(Request::is('finance/customer/'.$customerID.'/invoices'))
					@include('app.finance.contacts.invoices')
				@endif
 
            <!-- estimates -->
				@if(Request::is('finance/customer/'.$customerID.'/quotes'))
					@include('app.finance.contacts.quotes')
				@endif

            <!-- creditnote -->
				@if(Request::is('finance/customer/'.$customerID.'/creditnotes'))
					@include('app.finance.contacts.creditnotes')
				@endif

				<!-- projects -->
				@if(Request::is('finance/customer/'.$customerID.'/projects'))
					@include('app.finance.contacts.projects')
				@endif

				<!-- statement -->
				@if(Request::is('finance/customer/'.$customerID.'/statement'))
					@include('app.finance.contacts.statement')
				@endif

				<!-- statement mail -->
				@if(Request::is('finance/customer/'.$customerID.'/statement/mail'))
					@include('app.finance.contacts.statementMail')
				@endif

				<!-- subscription -->
				@if(Request::is('finance/customer/'.$customerID.'/subscriptions'))
					@include('app.finance.contacts.subscriptions')
				@endif

            <!-- contacts -->
				@if(Request::is('finance/customer/'.$customerID.'/contacts'))
					@include('app.finance.contacts.contacts')
				@endif

				<!-- mails -->
				@if(Request::is('finance/customer/'.$customerID.'/mail'))
					@include('app.finance.contacts.mail.index')
				@endif

				<!-- send -->
				@if(Request::is('finance/customer/'.$customerID.'/send'))
					@include('app.finance.contacts.mail.mail')
				@endif

				<!-- documents -->
				@if(Request::is('finance/customer/'.$customerID.'/documents'))
					@include('app.finance.contacts.documents')
				@endif

				<!-- sms -->
				@if(Request::is('finance/customer/'.$customerID.'/sms'))
					@include('app.finance.contacts.sms')
				@endif

				<!-- notes -->
				@if(Request::is('finance/customer/'.$customerID.'/notes'))
					@include('app.finance.contacts.notes')
				@endif

				<!-- events -->
				@if(Request::is('finance/customer/'.$customerID.'/events'))
					@include('app.finance.contacts.events')
				@endif

				<!-- events -->
				@if(Request::is('finance/customer/'.$customerID.'/calllogs'))
					@include('app.finance.contacts.calllogs')
				@endif
			</div>
		</div>
	</div>
@endsection
@section('scripts')
	<script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection

