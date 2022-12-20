@extends('layouts.app')
{{-- page header --}}
@section('title','Users ')
{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a class="btn btn-pink" href="{!! route('settings.users.create') !!}"><i class="fal fa-user-plus"></i> Add New User</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> Users </h1>
      <div class="panel panel-default" data-sortable-id="ui-widget-1">
         <div class="panel-heading">
            <h4 class="panel-title">All User</h4>
         </div>
         <div class="panel-body">
            @include('partials._messages')
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th width="1%"></th>
                     <th width="10%">Name</th>
                     <th width="12%">email</th>
                     <th width="12%">Last Login</th>
                     <th width="12%">Roles</th>
                     <th width="4%">Status</th>
                     <th width="3%"><center>Action</center></th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($users as $user)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>
                           @if($user->avatar != "")
                              <img class="rounded-circle" width="40" height="40" alt="" class="img-circle FL" src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID .'/hr/employee/images/'.$user->avatar) !!}">
                           @else
                              <img src="https://ui-avatars.com/api/?name={!! $user->name !!}&rounded=true&size=32" alt="">
                           @endif
                        </td>
                        <td>
                           <p>
                              {!! $user->name !!}
                              @if($user->branch_id != "")
                                 <br>
                                 @if(Hr::check_branch($user->branch_id) == 1)
                                    <span class="badge badge-pink">{!! Hr::branch($user->branch_id)->branch_name !!}</span>
                                 @endif
                              @endif
                           </p>
                        </td>
                        <td>{!! $user->email !!}</td>
                        <td>
                           @if($user->last_login != "" && $user->last_login_ip != "") 
                              <p>
                                 <b>Date :</b> {!! date("F jS, Y", strtotime($user->last_login)) !!}@ {!! date("h:i:sa", strtotime($user->last_login)) !!}<br>
                                 <b>IP :</b> {!! $user->last_login_ip !!}
                              </p>
                           @endif
                        </td>
                        <td>
                           @foreach($user->roles as $role) 
                              <a href="#" class="badge badge-primary">{{ $role->name }}</a>
                           @endforeach
                        </td>
                        <td>
                           @if($user->statusID != "")
                              <span class="btn btn-sm {!! Wingu::status($user->statusID)->name !!}">{!! Wingu::status($user->statusID)->name !!}</span>
                           @endif
                        </td>
                        <td>
                           <a href="{!! route('settings.users.edit',$user->id) !!}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
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
@section('script')

@endsection
