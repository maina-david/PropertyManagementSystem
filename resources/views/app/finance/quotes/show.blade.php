@extends('layouts.app')
{{-- page header --}}
@section('title')
	Quotes | {!! $customer->customer_name !!} 
@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		@include('partials._messages')
		<a href="#"  class="btn {!! $quote->statusName !!} mb-2"><i class="fal fa-bell"></i> {!! ucfirst($quote->statusName) !!}</a>
		@if($quote->statusID == 13 && $quote->invoice_link != "")
		   <a href="#" class="btn pink float-right"><i class="fal fa-check-circle"></i> Converted to invoice</a>
		@endif
		<div class="panel">
			<div class="panel-body">
				<div class="invoice-company text-inverse f-w-600">
					<span class="pull-right hidden-print">
						@permission('create-quotes')
							<a href="{!! route('finance.quotes.mail', $quote->quoteID) !!}" class="btn btn-sm btn-default m-b-10 p-l-5">
								<i class="fal fa-envelope"></i> Email Quote
							</a>
						@endpermission
						@if($quote->statusID != 13)
							@permission('update-quotes')
								<a href="{!! route('finance.quotes.edit', $quote->quoteID) !!}" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-edit"></i> Edit
								</a>
							@endpermission
						@endif
						@permission('create-quotes')
							<a href="{!! route('finance.quotes.pdf', $quote->quoteID) !!}" class="btn btn-sm btn-white m-b-10 p-l-5">
								<i class="fal fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
							</a>
						@endpermission
						@permission('create-quotes')
							<a href="{!! route('finance.quotes.print', $quote->quoteID) !!}" target="_blank" class="btn btn-sm btn-white m-b-10 p-l-5">
								<i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
							</a>
						@endpermission
						<div class="btn-group">
							<button type="button" class="btn btn-default btn-sm m-b-10 p-l-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								More
							</button>
							<ul class="dropdown-menu dropdown-menu-right">
								{{-- <li><a href="{!! url('/') !!}/storage/files/finance/Quotess/{!! $quote->file !!}" target="_blank">View Quote as customer</a></li> --}}
								<li><a href="#" data-toggle="modal" data-target="#attach-files">Attach Files</a></li>
								@permission('create-quotes')
								@if($quote->statusID != 10)
									<li><a href="{!! route('finance.quotes.status.change',[$quote->quoteID,10]) !!}">Mark as Draft</a></li>
								@endif
								@if($quote->statusID != 11)
								<li><a href="{!! route('finance.quotes.status.change',[$quote->quoteID,11]) !!}">Mark as Expired</a></li>
								@endif
								@if($quote->statusID != 12)
								<li><a href="{!! route('finance.quotes.status.change',[$quote->quoteID,12]) !!}">Mark as Declined</a></li>
								@endif
								@if($quote->statusID != 13)
								<li><a href="{!! route('finance.quotes.status.change',[$quote->quoteID,13]) !!}">Mark as Accepted</a></li>
								@endif
								@if($quote->statusID != 6)
								<li><a href="{!! route('finance.quotes.status.change',[$quote->quoteID,6]) !!}">Mark as Sent</a></li>
								@endif
								@endpermission
								<li class="divider"></li>
								{{-- <li><a href="#">Cloan Quotes </a></li> --}}
								<li><a href="{!! route('finance.quotes.delete',$quote->quoteID) !!}" class="text-danger delete">Delete Quotes</a></li>
							</ul>
						</div>
						@if($quote->statusID == 13)
							@permission('create-quotes')
								@if($quote->invoice_link == "")
									<a href="{!! route('finance.quotes.convert',$quote->quoteID) !!}" class="btn btn-success btn-sm m-b-10 p-l-5"><i class="fal fa-rocket"></i> Convert to Invoice</a>
								@endif
							@endpermission
						@endif
					</span>
					{!! $customer->customer_name !!}
				</div>
			</div>
		</div>
		<div class="invoice">
			@include('templates.'.$template.'.quotes.preview')				
			<!-- end invoice-content -->
			<!-- begin invoice-footer -->
			<div class="invoice-footer">
				<p class="text-center m-b-5 f-w-600">
					THANK YOU FOR YOUR BUSINESS
				</p>
				<p class="text-center">
					@if($quote->website != "")
					<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> {!! $quote->website !!}</span>
					@endif
					@if($quote->primary_phonenumber != "")
						<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> {!! $quote->primary_phonenumber !!}</span>
					@endif
					@if($quote->primary_email != "")
						<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> {!! $quote->primary_email !!}</span>
					@endif
				</p>
			</div>
			<!-- end invoice-footer -->
		</div>
	</div>

	{{-- attach files to Quotes --}}
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="{!! route('finance.quotes.attachment.files') !!}" class="dropzone" id="my-awesome-dropzone" method="post">
						@csrf()
						<input type="hidden" value="{!! $quote->quoteID !!}" name="quoteID">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
							<table id="data-table-default" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="1%">#</th>
										<th></th>
										<th>Name</th>
										<th>Type</th>
										<th  width="15%">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($files as $file)
										<tr>
											<td>{!! $filec++ !!}</td>
											<td>
												@if(stripos($file->file_mime, 'image') !== FALSE)
													<center><i class="fal fa-image fa-4x"></i></center>
												@endif
												@if(stripos($file->file_mime, 'pdf') !== FALSE)
													<center><i class="fal fa-file-pdf fa-4x"></i></center>
												@endif
												@if(stripos($file->file_mime, 'octet-stream') !== FALSE)
													<center><i class="fal fa-file-alt fa-4x"></i></center>
												@endif
											</td>
											<td width="10%">{!! $file->file_name !!}</td>
											<td>{!! $file->file_mime !!}</td>
											
											<td>
												<a href="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/quotes/'.$file->file_name) !!}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
												<a href="{!! route('finance.quotes.attachment.delete',$file->id) !!}" class="btn btn-danger btn-sm"><i class="fal fa-trash"></i></a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
		function change_status() {
			var url = '{!! url('/') !!}';
			var status = document.getElementById("status").value;
			var file = document.getElementById("fileID").value;
			$.get(url+'/finance/quotes/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
@endsection
