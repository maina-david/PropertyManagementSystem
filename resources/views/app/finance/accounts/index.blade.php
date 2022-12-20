@extends('layouts.app')
{{-- page header --}}
@section('title','Manage Accounts')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb --> 
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.account') !!}">Bank & Cash</a></li>
         <li class="breadcrumb-item active">Manage Accounts</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-piggy-bank"></i> Manage Accounts</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Accounts</h4>
            </div>
            <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                  <thead>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Account</th>
                     <th>Description</th>
                     <th width="13%">Balance</th>
                     <th width="15%">Action</th>
                  </thead>
                  <tbody>
                     @foreach ($accounts as $account)
                        <tr>
                           <td>{!! $count++ !!}</td>
                           <td>{!! $account->title !!}</td>
                           <td>{!! $account->account_number !!}</td>
                           <td>{!! $account->description !!}</td>
                           <td>{!! $account->code !!} {!! number_format($account->initial_balance) !!}</td>
                           <td>
                              @permission('update-bankaccount')
                                 <a href="{!! route('finance.account.edit',$account->accountID) !!}" class="btn btn-pink"><i class="fas fa-edit"></i> Edit</a>
                              @endpermission
                              @permission('delete-bankaccount')
                                 <a href="{!! route('finance.account.delete',$account->accountID) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
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
@endsection