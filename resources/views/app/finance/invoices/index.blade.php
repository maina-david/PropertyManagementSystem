@extends('layouts.app')
{{-- page header --}}
@section('title','All Invoices')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<div class="pull-right">
         @if(Finance::count_invoice() != Wingu::plan()->invoices && Finance::count_invoice() < Wingu::plan()->invoices)
            @permission('create-invoice')
               <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-pink dropdown-toggle"> <i class="fas fa-plus"></i> New invoice</button>
                  <ul class="dropdown-menu">
                     <li><a href="{!! route('finance.invoice.product.create') !!}">Create New Invoice</a></li>
                     {{-- <li><a href="{!! route('finance.invoice.random.create') !!}">Random Invoice</a></li> --}}
                     {{-- <li><a href="{!! route('finance.invoice.recurring.create') !!}">Recurring Invoice</a></li> --}}
                  </ul>
               </div>
            @endpermission
         @else 
            <a href="{!! route('wingu.plans') !!}" class="btn btn-danger">You have reached your invoice limit of {!! Wingu::plan()->invoices !!}, Upgrade your current plan</a>
         @endif
         {{-- <a href="#" class="btn btn-pink"><i class="fas fa-chart-pie"></i> Reports</a> --}}
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> All Invoices</h1>
      @include('partials._messages')
      {{-- <div class="panel panel-default">
         <div class="panel-heading">
				<div class="panel-heading-btn">
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
					<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
				</div>
				<h4 class="panel-title">Filter</h4>
			</div>
         <div class="panel-body">
            <form action="" class="row" autocomplete="off">
               @csrf
               <div class="col-md-3">
                  <div class="form-group-default form-group">
                     <label for="">Issue Date</label>
                     {!! Form::text('due_date',null,['class' => 'form-control datepicker','placeholder' => 'Choose date']) !!}
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group-default form-group">
                     <label for="">Due date</label>
                     {!! Form::text('due_date',null,['class' => 'form-control datepicker','placeholder' => 'Choose date']) !!}
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group-default form-group">
                     <label for="">Status</label>
                     {!! Form::select('due_date',[],null,['class' => 'form-control datepicker','placeholder' => 'Choose date']) !!}
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group-default form-group">
                     <label for="">Customer</label>
                     {!! Form::text('due_date',null,['class' => 'form-control datepicker','placeholder' => 'Choose date']) !!}
                  </div>
               </div>
               <div class="col-md-12">
                  <button class="btn btn-pink submit float-right" type="submit"><i class="fas fa-search"></i> Filter</button>
                  <img src="{!! url('/') !!}/backend/img/btn-loader.gif" class="submit-load none float-right" alt="" width="15%">
               </div>
            </form>
         </div>
      </div> --}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Invoice List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="10%">Invoice #</th>
                     <th>Title </th>
                     <th width="21%">Customer</th>
                     <th>Paid</th>
                     <th>Balance</th>
                     <th>Issue Date</th>
                     <th>Due Date</th>
                     <th>Status</th>
                     <th width="10%">Action</th> 
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th width="8%">Invoice #</th>
                     <th>Title </th>
                     <th width="18%">Customer</th>
                     <th>Paid</th>
                     <th>Balance</th>
                     <th width="10%">Issue Date</th>
                     <th width="10%">Due Date</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
						@foreach ($invoices as $crt => $v)
                     <tr role="row" class="odd">
                        <td>{{ $crt+1 }}</td>
                        <td>
                           @if($v->invoice_prefix == ""){{ $v->prefix }}@else{{ $v->invoice_prefix }}@endif{{ $v->invoice_number }}
                        </td>
                        <td>{!! $v->invoice_title !!} </td>
                        <td>
							      {!! $v->customer_name !!}
                        </td>
                        <td>
                           @if( $v->paid < 0 )
                              <b class="text-info">{!! $v->symbol !!}{!! number_format((float)$v->main_amount) !!} </b>
                           @else 
                              <b class="text-info">{!! $v->symbol !!}{!! number_format((float)$v->paid) !!} </b>
                           @endif   
                        </td>
                        <td>
                           @if( $v->statusID == 1 )
                              <span class="badge {!! $v->statusName !!}">{!! ucfirst($v->statusName) !!}</span>
                           @else
                              @if($v->balance < 0)
                                 <b class="text-primary">0 {!! $v->symbol !!}</b>
                              @else 
                                 <b class="text-primary">{!! $v->symbol !!}{{ number_format(round($v->balance)) }}</b>
                              @endif
                           @endif
                        </td>
                        <td>@if($v->invoice_date != ""){!! date('M j, Y',strtotime($v->invoice_date)) !!}@endif</td>
                        <td>@if($v->invoice_due != ""){!! date('M j, Y',strtotime($v->invoice_due)) !!}@endif</td>
                        @if((int)$v->total - (int)$v->paid < 0)
                           <td><span class="badge {!! $v->statusName !!}">{!! ucfirst($v->statusName) !!}</span></td>
                        @else
                            <td>
                                <span class="badge {!! Helper::seoUrl($v->statusName) !!}">{!! ucfirst($v->statusName) !!}</span>
                            </td>
                        @endif
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 @permission('read-invoice')
                                    <li><a href="{{ route('finance.invoice.show', $v->invoiceID) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 @endpermission
                                 @permission('update-invoice')
                                 @if($v->invoice_type == 'Product')
                                    <li><a href="{!! route('finance.invoice.product.edit', $v->invoiceID) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 @endif
                                 @if($v->invoice_type == 'Subscription' && $v->subscriptionID != "")
                                    <li><a href="{!! route('subscriptions.edit',$v->subscriptionID) !!}" target="_blank"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 @endif
                                 @endpermission
                                 @permission('delete-invoice')
                                    <li><a href="{!! route('finance.invoice.delete', $v->invoiceID) !!}" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                                 @endpermission
                              </ul>
                           </div>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
