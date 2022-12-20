@extends('layouts.app')
{{-- page header --}}
@section('title') Payments | {!! $property->title !!}  @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 

@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.show',$property->id) !!}">{!! $property->title !!}</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.payments',$property->id) !!}">Payments</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Payments</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12">
            <a href="{!! route('property.payments.create',$propertyID) !!}" class="btn btn-primary pull-right"><i class="fal fa-plus-circle"></i> Add Payment</a>
         </div>
         <div class="col-md-12 mt-1">   
            <div class="panel">
               <div class="panel-heading"><b>Payments</b></div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr role="row">
                           <th width="1%">#</th>
                           <th width="10%">Date</th>
                           <th width="14%">Reference</th>
                           <th>Tenant</th>
                           <th width="10%">Invoice</th>
                           <th>Paid via</th>
                           <th width="14%">Paid</th>
                           <th width="12%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($payments as $pay)
                           <tr role="row" class="odd">
                              <td>{!! $count++ !!}</td>
                              <td>
                                 @if($pay->payment_date != "")
                                    {!! date('d M, Y',strtotime($pay->payment_date)) !!}
                                 @endif
                              </td>
                              <td><p class="font-weight-bold">{!! $pay->reference_number !!}</p></td>
                              <td>
                                 {!! $pay->tenant_name !!}               
                                 @if($property->property_type == 2 or $property->property_type == 4)      
                                    @if(Property::check_property_unit($property->id,$pay->unit) == 1)
                                       <br> <span class="text-primary"><b>Unit :</b> {!! Property::property_unit($property->id,$pay->unit)->serial !!}</span>
                                    @endif
                                 @endif
                              </td>
                              <td>
                                 {!! $pay->invoice_prefix !!}{!! $pay->invoice_number !!}
                              </td>
                              <td>
                                 @if(Finance::check_payment_method($pay->payment_method) == 1)
                                    {!! Finance::payment_method($pay->payment_method)->name !!}
                                 @else 
                                    Not defined
                                 @endif
                              </td>
                              <td><b>{!! $business->code !!} {!! number_format($pay->amount) !!}</b></td>
                              <td>
                                 @permission('read-payments')
                                    <a href="{!! route('property.payments.show',[$property->id,$pay->paymentID]) !!}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                 @endpermission
                                 @permission('update-payments')
                                    <a href="{!! route('property.payments.edit',[$property->id,$pay->paymentID]) !!}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                 @endpermission                       
                                 @permission('delete-payments')
                                    <a href="{!! route('property.payments.delete',[$property->id,$pay->paymentID]) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                                 @endpermission
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection 