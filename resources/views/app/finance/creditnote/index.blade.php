@extends('layouts.app')
{{-- page header --}}
@section('title','All Credit notes')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         @if(Finance::count_creditnote() != Wingu::plan()->credit_note && Finance::count_creditnote() < Wingu::plan()->credit_note)
            @permission('create-creditnote')
               <a href="{!! route('finance.creditnote.create') !!}" class="btn btn-pink"><i class="fas fa-plus"></i> New  Credit note</a>
            @endpermission
         @endif
         {{-- <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle pull-right"><i class="fas fa-sliders-h"></i></button>
            <ul class="dropdown-menu">
               <li class="fltheader font-weight-bold"><center>Sort by</center></li>
               <li><a href="#">Created Time</a></li>
               <li><a href="">Last Modified Time</a></li>
               <li><a href="">Date</a></li>
               <li><a href="">Estimate Number</a></li>
               <li><a href="">Customer Name</a></li>
               <li><a href="">Amount</a></li>
               <li class="divider"></li>
               <li><a href=""><i class="fas fa-file-upload"></i> Import Estimates</a></li>
               <li><a href=""><i class="fas fa-file-download"></i> Export Estimates</a></li>
            </ul>
         </div> --}}
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> All  Credit notes</h1>
		@include('partials._messages')
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Client</th>
                     <th>Reference #</th>
                     <th>Amount</th>
                     <th>Balance</th>
                     <th>Status</th>
                     <th>Credit note date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Client</th>
                     <th>Reference #</th>
                     <th>Amount</th>
                     <th>Balance</th>
                     <th>Status</th>
                     <th>Credit note date</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  @foreach ($creditnotes as $crt => $v)
                     <tr role="row" class="odd">
                        <td>{{ $crt+1 }}</td>
                        <td>
                           <b>{!! $v->prefix !!}{!! $v->creditnote_number !!}</b>
                        </td>
                        <td>
                           {!! $v->customer_name !!}
                        </td>
                        <td class="text-uppercase font-weight-bold">
                           {!! $v->reference_number !!}
                        </td>
                        <td>{!! $v->symbol !!}{!! number_format($v->total,2) !!} </td>
                        <td>{!! $v->symbol !!}{!! number_format($v->balance,2) !!} </td>
                        <td>
                           <span class="badge {!! $v->statusName !!}">
                              {!! ucfirst($v->statusName) !!}
                           </span>
                        </td> 
                        <td>
                           {!! date('F j, Y',strtotime($v->creditnote_date)) !!}
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 @permission('read-creditnote')
                                    <li><a href="{{ route('finance.creditnote.show', $v->creditnoteID) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 @endpermission
                                 @permission('update-creditnote')
                                    @if($v->paymentID == "")
                                       <li><a href="{!! route('finance.creditnote.edit', $v->creditnoteID) !!}"><i class="fas fa-edit"></i> Edit</a></li>
                                    @endif
                                 @endpermission
                                 @permission('delete-creditnote')
                                    <li><a href="{!! route('finance.creditnote.delete', $v->creditnoteID) !!}" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
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
