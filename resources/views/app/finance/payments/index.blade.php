@extends('layouts.app')
{{-- page header --}}
@section('title','All Payments ')
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <div class="pull-right">      
      @permission('create-payments')
         <a href="{{ route('finance.payments.create') }}" title="" class="btn btn-pink"><i class="fal fa-plus"></i> Add Payment</a>
      @endpermission
   </div>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-cash-register"></i> All Payments</h1>
   @include('partials._messages')
   <div class="panel panel-default mt-2">
      <div class="panel-heading">
         <h4 class="panel-title">Payment List</h4>
      </div>
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered table-hover">
            <thead>
               <tr role="row">
                  <th width="1%">#</th>
                  <th>Date</th>
                  <th>Reference</th>
                  <th>Customer Name</th>
                  <th>Invoice#</th>
                  <th>Payment Method</th>
                  <th>Amount Paid</th>
                  <th width="3%">Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($payments as $pay)
                  <tr role="row" class="odd">
                     <td>{!! $count++ !!}</td>
                     <td>@if($pay->payment_date != ""){!! date('d F, Y',strtotime($pay->payment_date)) !!}@endif</td>
                     <td><p class="font-weight-bold">{!! $pay->transactionID !!}</p></td>
                     <td>
                        {!! $pay->customer_name !!}
                     </td>
                     <td>
                        @if($pay->invoice_prefix == ""){!! $pay->prefix !!}@else{!! $pay->invoice_prefix !!}@endif{!! $pay->invoice_number !!}
                     </td>
                     <td>
                        @if(Finance::check_default_payment_method($pay->payment_method) == 1)
                           {!! Finance::default_payment_method($pay->payment_method)->name !!}
                        @else 
                           @if(Finance::check_payment_method($pay->payment_method) == 1)
                              {!! Finance::payment_method($pay->payment_method)->name !!}
                           @endif
                        @endif
                     </td>
                     <td>
                        <b>{!! $pay->code !!} {!! number_format($pay->amount) !!}</b>
                     </td>
                     <td>
                        <div class="btn-group">
                           <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                           <ul class="dropdown-menu">
                              @permission('update-payments')
                                 <li><a href="{{ route('finance.payments.edit', $pay->paymentID) }}"><i class="far fa-edit"></i> Edit</a></li>
                              @endpermission
                              @permission('read-payments')
                                 <li><a href="{{ route('finance.payments.show', $pay->paymentID) }}"><i class="fas fa-eye"></i> View</a></li>
                              @endpermission
                              @permission('delete-payments')
                                 <li><a href="{!! route('finance.payments.delete', $pay->paymentID) !!}" class="delete"><i class="fas fa-trash"></i> Delete</a></li>
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

