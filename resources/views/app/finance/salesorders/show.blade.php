@extends('layouts.app')
{{-- page header --}}
@section('title')
{!! $salesorder->prefix !!}{!! $salesorder->salesorder_number !!} | Sales Order | {!! $client->customer_name !!} | 
@endsection
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		@include('partials._messages')
      <div class="row">
         <div class="col-md-10">
				<div class="invoice">
					<!-- begin invoice-company -->
					<div class="invoice-company text-inverse f-w-600">
						<span class="col-md-12">
							{{-- @permission('read-invoice')
								<a href="{!! route('finance.salesorders.mail',$salesorder->salesorderID) !!}" class="btn btn-sm m-b-10 p-l-5 btn-primary"> <i class="fal fa-envelope"></i> Send Sales Order</a></li>
							@endpermission --}}
							@permission('update-invoice')
								<a href="{!! route('finance.salesorders.edit', $salesorder->salesorderID) !!}" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-edit"></i> Edit
								</a>
							@endpermission
							@permission('read-invoice')
								<a href="{!! route('finance.salesorders.pdf', $salesorder->salesorderID) !!}" target="_blank" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF
								</a>
							@endpermission
							@permission('read-invoice')
								<a href="{!! route('finance.salesorders.print', $salesorder->salesorderID) !!}" target="_blank" class="btn btn-sm btn-default m-b-10 p-l-5">
									<i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
								</a>
							@endpermission
							<a href="#" class="btn btn-default btn-sm m-b-10 p-l-5" data-toggle="modal" data-target="#attach-files"><i class="fal fa-paperclip"></i> Attach Files</a>
							@if($salesorder->statusID != 44)
								<a href="{!! route('finance.salesorders.status.change',[$salesorder->salesorderID,44]) !!}" class="btn btn-success btn-sm m-b-10 p-l-5"><i class="fal fa-check-circle"></i> Mark as confirmed</a>
							@endif
							@if($salesorder->statusID == 44)
								@if($salesorder->invoiceID == "")
									<a href="{!! route('finance.salesorders.convert',$salesorder->salesorderID)  !!}" class="btn btn-warning btn-sm m-b-10 p-l-5 delete"><i class="fal fa-exchange-alt"></i> Convert to invoice</a>
								@endif
							@endif
							@if($salesorder->invoiceID != "")
								<a href="{!! route('finance.invoice.show', $salesorder->invoiceID) !!}" class="btn btn-pink btn-sm m-b-10 p-l-5" target="_blank"><i class="fal fa-file-invoice-dollar"></i> view invoice</a>
							@endif
							<a href="{!! route('finance.salesorders.delete', $salesorder->salesorderID) !!}" class="btn btn-danger btn-sm m-b-10 p-l-5 delete"><i class="fal fa-trash"></i> Delete</a>
						</span>
					</div>
					<hr>
					<div class="invoice-content">
						@include('templates.'.$template.'.salesorder.preview')
					</div>
					
					<!-- begin invoice-footer -->
					<div class="invoice-footer">
						<p class="text-center m-b-5 f-w-600">
							THANK YOU FOR YOUR BUSINESS
						</p>
						<p class="text-center">
							@if($salesorder->website != "")
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> {!! $salesorder->website !!}</span>
							@endif
							@if($salesorder->primary_phonenumber != "")
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> {!! $salesorder->primary_phonenumber !!}</span>
							@endif
							@if($salesorder->primary_email != "")
								<span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> {!! $salesorder->primary_email !!}</span>
							@endif
						</p>
					</div>
					<!-- end invoice-footer -->
				</div>
         </div>
      </div>
	</div>

	{{-- attach files to Invoice --}}
	<div class="modal fade" id="attach-files">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Attachment</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="{!! route('finance.salesorders.attachment.files') !!}" class="dropzone" id="my-awesome-dropzone" method="post">
						@csrf()
						<input type="hidden" value="{!! $salesorder->salesorderID !!}" name="salesorderID">
					</form>
					<center><h3 class="mt-5">Attachment Files</h3></center>
					<div class="row">
						<div class="col-md-12">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th></th>
									<th width="10%">Name</th>
									<th>Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($files as $file)
									<tr>
										<td>{!! $filec++ !!}</td>
										<td>
											@if(stripos($file->file_mime, 'image') !== FALSE)
												<center><img src="{!! asset('businesses/'.$salesorder->business_code.'/finance/salesorders/'.$file->file_name) !!}" alt="" style="width:30px;height:30px"></center>
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
											<a href="{!! route('finance.salesorders.attachment.delete',$file->id) !!}" class="btn btn-danger delete"><i class="fal fa-trash"></i> Delete</a>
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
			$.get(url+'/finance/salesorders/file/'+status+'/'+file, function(data){
				//success data
				location.reload();
			});
		}
	</script>
@endsection
