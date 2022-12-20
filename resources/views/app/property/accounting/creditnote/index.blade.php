@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Credit Notes @endsection
@section('sidebar')
	@include('app.property.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="j{!! route('property.creditnote.index',$property->id) !!}">Credit Notes</a></li>
         <li class="breadcrumb-item active"><a href="{!! route('property.creditnote.index',$property->id) !!}">Index</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Credit Notes</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12 mt-2 mb-2">
            <a href="{!! route('property.creditnote.create',$property->id) !!}" class="btn btn-primary"><i class="fal fa-plus-circle"></i> Add Credit Note</a>
         </div>
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Number</th>
                           <th>Tenant</th>
                           <th>Reference #</th>
                           <th>Amount</th>
                           <th>Balance</th>
                           <th>Status</th>
                           <th>Credit date</th>
                           <th width="12%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($creditnotes as $crt => $v)
                           <tr role="row" class="odd">
                              <td>{{ $crt+1 }}</td>
                              <td>
                                 <b>{!! $v->creditnote_prefix !!}{!! $v->creditnote_number !!}</b>
                              </td>
                              <td>
                                 {!! $v->tenant_name !!}
                              </td>
                              <td class="text-uppercase font-weight-bold">
                                 @if($v->title != "")
                                    {!! $v->title !!}<br>
                                 @endif
                                 {!! $v->reference_number !!}
                              </td>
                              <td>{!! $v->symbol !!}{!! number_format($v->total) !!} </td>
                              <td>{!! $v->symbol !!}{!! number_format($v->balance) !!} </td>
                              <td>
                                 <span class="badge {!! $v->statusName !!}">
                                    {!! ucfirst($v->statusName) !!}
                                 </span>
                              </td>
                              <td>
                                 {!! date('M j, Y',strtotime($v->creditnote_date)) !!}
                              </td>
                              <td>
                                 <a href="{{ route('property.creditnote.show',[$property->id,$v->creditnoteID]) }}" class="btn btn-sm btn-warning"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                 @if($v->paymentID == "")
                                    <a href="{!! route('property.creditnote.edit',[$property->id,$v->creditnoteID]) !!}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                 @endif
                                 <a href="{!! route('finance.creditnote.delete', $v->creditnoteID) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash-alt"></i></a>
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
