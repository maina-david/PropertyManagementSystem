@extends('layouts.app')
@section('title','Marketing | Listing')
@section('sidebar')
	@include('app.property.partials._menu')
@endsection
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Marketing</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Inquiries</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullhorn"></i> Marketing - Inquiries </h1>
   	<div class="card card-default">
	      <div class="card-body">
	        <table id="data-table-default" class="table table-striped table-bordered table-hover">
	            <thead>
	               <tr>
	                  <th width="1%">#</th>
	                  <th>Name</th>
	                  <th>Email</th>
	                  <th>Phone Number</th>
	                  <th>Listing</th>
	                  <th>Date</th>
	                  <th width="13%">Action</th>
	               </tr>
	            </thead>
	            <tbody>
	               @foreach($inquiries as $inquiry)
	                  <tr>
	                     <td>{!! $count++ !!}</td>
	                     <td>{!! $inquiry->names !!}</td>
	                     <td>{!! $inquiry->mail_from !!}</td>
	                     <td>{!! $inquiry->phone_number !!}</td>
	                     <td>
	                        @if($inquiry->listingID != "")
	                           {!! Property::listing($inquiry->listingID)->title !!}
	                        @endif
	                     </td>
	                     <td>{!! date('M jS, Y', strtotime($inquiry->created_at)) !!}</td>
	                     <td>
	                        <a href="" class="btn btn-success" data-toggle="modal" data-target="#inquirty{!! $inquiry->id !!}">View Inquiry</a>
	                     </td>
	                  </tr>
	                  <!-- Modal -->
	                  <div class="modal fade" id="inquirty{!! $inquiry->id !!}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	                     <div class="modal-dialog" role="document">
	                     <div class="modal-content">
	                        <div class="modal-header">
	                           <h5 class="modal-title" id="exampleModalLabel">Inquiry Message</h5>
	                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                           <span aria-hidden="true">&times;</span>
	                           </button>
	                        </div>
	                        <div class="modal-body">
	                           {!! $inquiry->message !!}
	                        </div>
	                        <div class="modal-footer">
	                           <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	                        </div>
	                     </div>
	                     </div>
	                  </div>
	               @endforeach
	            </tbody>
	         </table>
	      </div>
	   </div>
	</div>
@endsection
