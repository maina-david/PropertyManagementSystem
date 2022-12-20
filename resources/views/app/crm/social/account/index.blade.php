@extends('layouts.app')
{{-- page header --}}
@section('title','Digital Marketing Accounts')

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Digital Marketing</a></li>
         <li class="breadcrumb-item active">Accounts</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-share-alt"></i> Account</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">All Account</h4>
            </div>
            <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                  <thead>
                     <th width="1%">#</th>
                     <th>Client Name</th>
                     <th>Description</th>
                     <th>Budget Estimate</th>
                     <th>Status</th>
                     <th>Account Date</th>
                     <th width="21%">Action</th>
                  </thead>
                  <tbody>
                     @foreach ($accounts as $account)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>
                           {!! $account->customer_name !!}
                        </td>
                        <td>{!! $account->description !!}</td>
                        <td>{!! $account->budget !!}</td>
                        <td><span class="btn btn-sm {!! $account->name !!}">{!! $account->name !!}</span></td>
                        <td>{!! date('jS F, Y', strtotime($account->account_date)) !!}</td>
                        <td>
                           <a href="{!! route('crm.account.edit',$account->accountID) !!}" class="btn btn-pink"><i class="fas fa-edit"></i> Edit</a>
                           <a href="{!! route('crm.channel.index',$account->accountID) !!}" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
                           <a href="{!! route('crm.marketing.account.delete',$account->accountID) !!}" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
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