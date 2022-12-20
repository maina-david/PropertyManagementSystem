@extends('layouts.app')
{{-- page header --}}
@section('title','Purchase Orders')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         @if(Finance::lpo_count() != Wingu::plan()->lpos && Finance::lpo_count() < Wingu::plan()->lpos)
            @permission('create-lpo')
               <a href="{!! route('finance.lpo.create') !!}" class="btn btn-pink"><i class="fas fa-plus"></i> New Purchase Orders</a>
            @endpermission
         @endif
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-contract"></i> Purchase Orders</h1>
		@include('partials._messages')
		<div class="panel panel-inverse">
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Number</th>
                     <th>Supplier</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Number</th>
                     <th>Supplier</th>
                     <th>Reference Number</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Issue Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  @foreach ($lpos as $crt => $v)
                     <tr role="row" class="odd">
                        <td>{{ $crt+1 }}</td>
                        <td>
                           {!! $v->lpo_title !!}
                        </td>
                        <td>
                           <b>{!! $v->prefix !!}{!! $v->lpo_number !!}</b>
                        </td>
                        <td>
                           {!! $v->supplierName !!}
                        </td>
                        <td class="text-uppercase font-weight-bold">
                           {!! $v->reference_number !!}
                        </td>
                        <td>{!! $v->symbol !!}{!! number_format($v->main_amount) !!}</td>
                        <td><span class="badge {!! $v->statusName !!}">{!! ucfirst($v->statusName) !!}</span></td>
                        <td>
                           {!! date('F j, Y',strtotime($v->lpo_date)) !!}
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 @permission('read-lpo')
                                    <li><a href="{{ route('finance.lpo.show', $v->lpoID) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 @endpermission
                                 @permission('update-lpo')
                                    <li><a href="{!! route('finance.lpo.edit', $v->lpoID) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 @endpermission
                                 @permission('delete-lpo')
                                    <li><a href="{!! route('finance.lpo.delete', $v->lpoID) !!}" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
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