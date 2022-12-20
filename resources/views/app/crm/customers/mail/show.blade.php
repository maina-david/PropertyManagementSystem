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

@section('stylesheet')
   <style>
      @media (min-width: 992px) {
         .inbox-wrapper .email-aside .aside-content {
            padding-right: 10px;
         }
      }

      .inbox-wrapper .email-aside .aside-content .aside-header {
         padding: 0 0 5px;
         position: relative;
      }

      .inbox-wrapper .email-aside .aside-content .aside-header .title {
         display: block;
         margin: 3px 0 0;
         font-size: 1.1rem;
         line-height: 27px;
         color: #686868;
      }

      .inbox-wrapper .email-aside .aside-content .aside-header .navbar-toggle {
         background: 0 0;
         display: none;
         outline: 0;
         border: 0;
         padding: 0 11px 0 0;
         text-align: right;
         margin: 0;
         width: 100%;
         height: 100%;
         top: 0;
         left: 0;
         position: absolute;
      }

      @media (max-width: 991px) {
         .inbox-wrapper .email-aside .aside-content .aside-header .navbar-toggle {
            display: block;
         }
      }

      .inbox-wrapper .email-aside .aside-content .aside-header .navbar-toggle .icon {
         font-size: 24px;
         color: #71738d;
      }

      .inbox-wrapper .email-aside .aside-content .aside-compose {
         text-align: center;
         padding: 14px 0;
      }

      .inbox-wrapper .email-aside .aside-content .aside-compose .btn,
      .inbox-wrapper .email-aside .aside-content .aside-compose .fc .fc-button,
      .fc .inbox-wrapper .email-aside .aside-content .aside-compose .fc-button,
      .inbox-wrapper .email-aside .aside-content .aside-compose .swal2-modal .swal2-actions button,
      .swal2-modal .swal2-actions .inbox-wrapper .email-aside .aside-content .aside-compose button,
      .inbox-wrapper .email-aside .aside-content .aside-compose .wizard > .actions a,
      .wizard > .actions .inbox-wrapper .email-aside .aside-content .aside-compose a {
         padding: 11px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav {
         visibility: visible;
         padding: 0 0;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav.collapse {
         display: block;
      }

      @media (max-width: 991px) {
         .inbox-wrapper .email-aside .aside-content .aside-nav.collapse {
            display: none;
         }
      }

      @media (max-width: 991px) {
         .inbox-wrapper .email-aside .aside-content .aside-nav.show {
            display: block;
         }
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .title {
         display: block;
         color: #3d405c;
         font-size: 12px;
         font-weight: 700;
         text-transform: uppercase;
         margin: 20px 0 0;
         padding: 8px 14px 4px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li {
         width: 100%;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a {
         display: -webkit-flex;
         display: flex;
         -webkit-align-items: center;
         align-items: center;
         position: relative;
         color: #71748d;
         padding: 7px 14px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a:hover {
         text-decoration: none;
         background-color: rgba(114, 124, 245, 0.1);
         color: #727cf5;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a .icon svg {
         width: 18px;
         margin-right: 10px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a .badge {
         margin-left: auto;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a svg {
         width: 18px;
         margin-right: 10px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li.active a {
         color: #ff3366;
         background: rgba(255, 51, 102, 0.1);
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li.active a .icon {
         color: #ff3366;
      }

      .inbox-wrapper .email-content .email-inbox-header {
         background-color: transparent;
         padding: 18px 18px;
      }

      .inbox-wrapper .email-content .email-inbox-header .email-title {
         display: -webkit-flex;
         display: flex;
         -webkit-align-items: center;
         align-items: center;
         font-size: 1rem;
      }

      .inbox-wrapper .email-content .email-inbox-header .email-title svg {
         width: 20px;
         margin-right: 10px;
         color: #686868;
      }

      .inbox-wrapper .email-content .email-inbox-header .email-title .new-messages {
         font-size: .875rem;
         color: #686868;
         margin-left: 3px;
      }

      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .btn,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .fc .fc-button,
      .fc .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .fc-button,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .swal2-modal .swal2-actions button,
      .swal2-modal .swal2-actions .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn button,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .wizard > .actions a,
      .wizard > .actions .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn a {
         border-radius: 0;
         padding: 4.5px 10px;
      }

      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .btn svg,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .fc .fc-button svg,
      .fc .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .fc-button svg,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .swal2-modal .swal2-actions button svg,
      .swal2-modal .swal2-actions .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn button svg,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .wizard > .actions a svg,
      .wizard > .actions .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn a svg {
         width: 18px;
      }

      .inbox-wrapper .email-content .email-filters {
         padding: 20px;
         border-bottom: 1px solid #e8ebf1;
         background-color: transparent;
         width: 100%;
         border-top: 1px solid #e8ebf1;
      }

      .inbox-wrapper .email-content .email-filters > div {
         display: -webkit-flex;
         display: flex;
         -webkit-align-items: center;
         align-items: center;
      }

      .inbox-wrapper .email-content .email-filters .email-filters-left .btn-group,
      .inbox-wrapper .email-content .email-filters .email-filters-left .fc .fc-toolbar.fc-header-toolbar .fc-left .fc-button-group,
      .fc .fc-toolbar.fc-header-toolbar .fc-left .inbox-wrapper .email-content .email-filters .email-filters-left .fc-button-group,
      .inbox-wrapper .email-content .email-filters .email-filters-left .fc .fc-toolbar.fc-header-toolbar .fc-right .fc-button-group,
      .fc .fc-toolbar.fc-header-toolbar .fc-right .inbox-wrapper .email-content .email-filters .email-filters-left .fc-button-group {
         margin-right: 5px;
      }

      .inbox-wrapper .email-content .email-filters .email-filters-left input {
         margin-right: 8px;
      }

      .inbox-wrapper .email-content .email-filters .email-filters-right {
         text-align: right;
      }

      @media (max-width: 767px) {
         .inbox-wrapper .email-content .email-filters .email-filters-right {
            width: 100%;
            display: flex;
            justify-content: space-between;
         }
      }

      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-indicator {
         display: inline-block;
         vertical-align: middle;
         margin-right: 13px;
      }

      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .btn svg,
      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .fc .fc-button svg,
      .fc .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .fc-button svg,
      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .swal2-modal .swal2-actions button svg,
      .swal2-modal .swal2-actions .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav button svg,
      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .wizard > .actions a svg,
      .wizard > .actions .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav a svg {
         width: 18px;
      }

      .inbox-wrapper .email-content .email-filters .be-select-all.custom-checkbox {
         display: inline-block;
         vertical-align: middle;
         padding: 0;
         margin: 0 30px 0 0;
      }

      .inbox-wrapper .email-content .email-list .email-list-item {
         display: -webkit-flex;
         display: flex;
         -webkit-align-items: center;
         align-items: center;
         border-bottom: 1px solid #e8ebf1;
         padding: 10px 20px;
         width: 100%;
         cursor: pointer;
         position: relative;
         font-size: 14px;
         cursor: pointer;
         transition: background .2s ease-in-out;
      }

      .inbox-wrapper .email-content .email-list .email-list-item:hover {
         background: rgba(114, 124, 245, 0.08);
      }

      .inbox-wrapper .email-content .email-list .email-list-item:last-child {
         margin-bottom: 5px;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions {
         width: 40px;
         vertical-align: top;
         display: table-cell;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .form-check {
         margin-bottom: 0;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .form-check i::before {
         width: 15px;
         height: 15px;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .form-check i::after {
         font-size: .8rem;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .favorite {
         display: block;
         padding-left: 1px;
         line-height: 15px;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .favorite span svg {
         width: 14px;
         color: #686868;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .favorite:hover span {
         color: #8d8d8d;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .favorite.active span svg {
         color: #fbbc06;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail {
         display: -webkit-flex;
         display: flex;
         -webkit-justify-content: space-between;
         justify-content: space-between;
         -webkit-flex-grow: 1;
         flex-grow: 1;
         -webkit-flex-wrap: wrap;
         flex-wrap: wrap;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .from {
         display: block;
         font-weight: 400;
         margin: 0 0 1px 0;
         color: #000;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .msg {
         margin: 0;
         color: #71738d;
         font-size: .8rem;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .date {
         color: #000;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .date .icon svg {
         width: 14px;
         margin-right: 7px;
         color: #3d405c;
      }

      .inbox-wrapper .email-content .email-list .email-list-item.email-list-item--unread {
         background-color: rgba(114, 124, 245, 0.09);
      }

      .inbox-wrapper .email-content .email-list .email-list-item.email-list-item--unread .from {
         color: #000;
         font-weight: 800;
      }

      .inbox-wrapper .email-content .email-list .email-list-item.email-list-item--unread .msg {
         font-weight: 700;
         color: #686868;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-header .navbar-toggle .icon {
         position: absolute;
         top: 0;
         left: 0;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-nav .nav {
         padding-right: 0;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a .icon svg {
         margin-right: 0;
         margin-left: 10px;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a .badge {
         margin-left: 0;
         margin-right: auto;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a svg {
         margin-right: 0;
         margin-left: 10px;
      }

      .rtl .inbox-wrapper .email-content .email-inbox-header .email-title svg {
         margin-right: 0;
         margin-left: 10px;
      }

      .rtl .inbox-wrapper .email-content .email-inbox-header .email-title .new-messages {
         margin-left: 0;
         margin-right: 3px;
      }

      .rtl .inbox-wrapper .email-content .email-filters .email-pagination-indicator {
         margin-right: 0;
         margin-left: 13px;
      }

      .rtl .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .date .icon svg {
         margin-right: 0;
         margin-left: 7px;
      }

      .email-head {
         background-color: transparent;
      }

      .email-head-subject {
         padding: 25px 25px;
         border-bottom: 1px solid #e8ebf1;
      }

      @media (max-width: 767px) {
         .email-head-subject {
            padding: 25px 10px;
         }
      }

      .email-head-subject .title {
         display: block;
         font-size: .99rem;
      }

      .email-head-subject .title a.active .icon {
         color: #fbbc06;
      }

      .email-head-subject .title a .icon {
         color: silver;
         margin-right: 6px;
      }

      .email-head-subject .title a .icon svg {
         width: 18px;
      }

      .email-head-subject .icons {
         font-size: 14px;
         float: right;
      }

      .email-head-subject .icons .icon {
         color: #000;
         margin-left: 12px;
      }

      .email-head-subject .icons .icon svg {
         width: 18px;
      }

      .email-head-sender {
         padding: 13px 25px;
      }

      @media (max-width: 767px) {
         .email-head-sender {
            padding: 25px 10px;
         }
      }

      .email-head-sender .avatar {
         float: left;
         margin-right: 10px;
      }

      .email-head-sender .date {
         float: right;
         font-size: 12px;
      }

      .email-head-sender .avatar {
         float: left;
         margin-right: 10px;
      }

      .email-head-sender .avatar img {
         width: 36px;
      }

      .email-head-sender .sender > a {
         color: #000;
      }

      .email-head-sender .sender span {
         margin-right: 5px;
         margin-left: 5px;
      }

      .email-head-sender .sender .actions {
         display: inline-block;
         position: relative;
      }

      .email-head-sender .sender .actions .icon {
         color: #686868;
         margin-left: 7px;
      }

      .email-head-sender .sender .actions .icon svg {
         width: 18px;
      }

      .email-body {
         background-color: transparent;
         border-top: 1px solid #e8ebf1;
         padding: 30px 28px;
      }

      @media (max-width: 767px) {
         .email-body {
            padding: 30px 10px;
         }
      }

      .email-attachments {
         background-color: transparent;
         padding: 25px 28px 5px;
         border-top: 1px solid #e8ebf1;
      }

      @media (max-width: 767px) {
         .email-attachments {
            padding: 25px 10px 0;
         }
      }

      .email-attachments .title {
         display: block;
         font-weight: 500;
      }

      .email-attachments .title span {
         font-weight: 400;
      }

      .email-attachments ul {
         list-style: none;
         margin: 15px 0 0;
         padding: 0;
      }

      .email-attachments ul > li {
         margin-bottom: 5px;
      }

      .email-attachments ul > li:last-child {
         margin-bottom: 0;
      }

      .email-attachments ul > li a {
         color: #000;
      }

      .email-attachments ul > li a svg {
         width: 18px;
         color: #686868;
      }

      .email-attachments ul > li .icon {
         color: #737373;
         margin-right: 2px;
      }

      .email-attachments ul > li span {
         font-weight: 400;
      }

      .rtl .email-head-subject .title a .icon {
         margin-right: 0;
         margin-left: 6px;
      }

      .rtl .email-head-subject .icons .icon {
         margin-left: 0;
         margin-right: 12px;
      }

      .rtl .email-head-sender .avatar {
         margin-right: 0;
         margin-left: 10px;
      }

      .rtl .email-head-sender .sender .actions .icon {
         margin-left: 0;
         margin-right: 7px;
      }

      .email-head-title {
         padding: 15px;
         border-bottom: 1px solid #e8ebf1;
         font-weight: 400;
         color: #3d405c;
         font-size: .99rem;
      }

      .email-head-title .icon {
         color: #696969;
         margin-right: 12px;
         vertical-align: middle;
         line-height: 31px;
         position: relative;
         top: -1px;
         float: left;
         font-size: 1.538rem;
      }

      .email-compose-fields {
         background-color: transparent;
         padding: 20px 15px;
      }

      .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered {
         margin: -2px -14px;
      }

      .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
         border-radius: 0;
         background: #727cf5;
         color: #ffffff;
         margin-top: 0px;
         padding: 4px 10px;
         font-size: 13px;
         border: 0;
      }

      .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice span {
         color: #ffffff;
      }

      .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-search {
         line-height: 15px;
      }

      .form-group.row {
         margin-bottom: 0;
         padding: 12px 0;
      }

      .form-group.row label {
         white-space: nowrap;
      }

      .email-compose-fields label {
         padding-top: 6px;
      }

      .email.editor {
         background-color: transparent;
      }

      .email.editor .editor-statusbar {
         display: none;
      }

      .email.action-send {
         padding: 8px 0px 0;
      }

      .btn-space {
         margin-right: 5px;
         margin-bottom: 5px;
      }

      .breadcrumb {
         margin: 0;
         background-color: transparent;
      }

      .rtl .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
         float: right;
      }

      .rtl .btn-space {
         margin-right: 0;
         margin-left: 5px;
      }
      .card {
         box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
         -webkit-box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
         -moz-box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
         -ms-box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
      }
      .card {
         position: relative;
         display: flex;
         flex-direction: column;
         min-width: 0;
         word-wrap: break-word;
         background-color: #fff;
         background-clip: border-box;
         border: 1px solid #f2f4f9;
         border-radius: 0.25rem;
      }
      .badge {
         padding: 6px 5px 3px;
      }
      .text-white {
         color: #ffffff !important;
      }
      .font-weight-bold {
         font-weight: 700 !important;
      }
      .float-right {
         float: right !important;
      }
      .badge-danger-muted {
         color: #212529;
         background-color: #f77eb9;
      }
   </style>
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu')
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
					<a href="{{ route('crm.customers.edit', $client->cid) }}" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fal fa-edit"></i> Edit</a>
					<a href="{{ route('crm.customer.send', $client->cid) }}" class="btn btn-primary btn-xs waves-effect mb-2 waves-light"><i class="fal fa-paper-plane"></i> Send Email</a>
					<a href="{!! route('crm.customers.delete', $client->cid) !!}" class="btn btn-danger btn-xs waves-effect mb-2 waves-light delete"><i class="fas fa-trash"></i> Delete</a>
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
							<a href="{{ route('crm.customers.edit', $client->cid) }}" class="btn btn-white"><i class="fal fa-edit"></i> Edit</a>
							<a href="{{ route('crm.customer.send', $client->cid) }}" class="btn btn-white"><i class="fal fa-paper-plane"></i> Send Mail</a>
   						<div class="btn-group">
   							<button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> New Transaction </button>
   							<ul class="dropdown-menu pull-right">
   								<li><a href="{!! route('finance.invoice.product.create') !!}">Invoice</a></li>
   								<li><a href="{!! route('finance.payments.create') !!}">Payment</a> </li>
   								<li><a href="{!! route('finance.quotes.create') !!}">Quotes</a> </li>
   								<li><a href="{!! route('finance.creditnote.create') !!}">Credit Note</a> </li>
   								<li class="divider"></li>
   								<li> <a href="">Project</a> </li>
   							</ul>
   						</div>
   						<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-white dropdown-toggle pull-right"> More </button>
								<ul class="dropdown-menu">
									<li><a href=""><i class="fal fa-sms"></i> SMS</a></li>
									<li><a href="{!! route('crm.customer.mail',$customerID) !!}"><i class="fal fa-paper-plane"></i> Mail</a></li>
									<li class="divider"></li>
									<li><a href=""><i class="fal fa-sticky-note"></i> Notes</a></li>
									<li><a href=""><i class="fal fa-calendar-alt"></i> Meeting</a></li>
									<li><a href=""><i class="fal fa-phone-office"></i> Call log</a></li>
									<li><a href=""><i class="fal fa-tasks"></i> Tasks</a></li>
									<li class="divider"></li>									
									<li><a href="{!! route('crm.customers.delete', $client->cid) !!}"><i class="fas fa-trash"></i> Delete</a></li>
								</ul>
							</div>
							<a href="#" class="btn btn-white"><i class="fal fa-folder"></i> Documents</a>
                  </div>
					</div>
				</div>
				@include('partials._messages')
				<!-- begin nav -->
				@include('app.crm.customers._nav')
            <!-- end nav -->
            <div class="card">
               <div class="card-body">
                  <div class="col-lg-12 email-content">
                     <div class="email-head">
                        <div class="email-head-subject">
                           <div class="title d-flex align-items-center justify-content-between">
                              <div class="d-flex align-items-center">
                                 <span>{!! $mail->subject !!}</span>
                              </div>
                           </div>
                        </div>                       
                     </div>
                     <div class="email-body">
                        {!! $mail->message !!}
                     </div>
                     {{-- <div class="email-attachments">
                        <div class="title">Attachments <span>(3 files, 12,44 KB)</span></div>
                        
                     </div> --}}
                  </div>
               </div>
            </div>			
			</div>
		</div>
	</div>
@endsection
@section('scripts')
@endsection

