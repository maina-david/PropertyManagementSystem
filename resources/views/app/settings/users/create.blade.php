@extends('layouts.app')
{{-- page header --}}
@section('title','Add Users')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li>
         <li class="breadcrumb-item"><a href="#">Users</a></li>
         <li class="breadcrumb-item active">Add</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-plus"></i> Add Users </h1>
      <div class="panel panel-default" data-sortable-id="ui-widget-1">
         <div class="panel-heading">
            <h4 class="panel-title">Add User</h4>
         </div>
         <div class="panel-body">
            @include('partials._messages')
            <form action="{!! route('settings.users.store') !!}" method="post" accept-charset="utf-8">
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="column">
                        <div class="field">
                           <div class="form-group">
                              <label for="" class="text-danger">User Name</label>
                              {!! Form::text('name',null,['class' => 'form-control', 'required' => '']) !!}
                           </div>
                           <div class="form-group">
                              <label for="" class="text-danger">Email Address</label>
                              {!! Form::email('email',null,['class' => 'form-control', 'required' => '']) !!}
                           </div>
                           <div class="form-group">
                              <label for="">Branch</label>
                              <select name="branch" class="from-control multiselect" required>
                                 <option value="">Choose Branch</option>
                                 @foreach($branches as $branch)
                                    <option value="{!! $branch->id !!}">{!! $branch->branch_name !!}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group">
                              <label for="" class="text-danger">Password</label>
                              <input type="password" name="password" class="form-control" placeholder="Enter password" required />
                           </div>
                           <div class="form-group">
                              <label for="" class="text-danger">Confirm Password</label>
                              <input type="password" name="password_confirmation" class="form-control" placeholder="Password" required />
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label class="">Roles:</label>
                     <div class="row">
                        @foreach ($roles as $role)
                           <div class="col-md-4">
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" id="{!! $role->display_name !!}"  name="roles[]" value="{{$role->id}}"> 
                                 <label class="custom-control-label" for="{!! $role->display_name !!}">{!! $role->display_name !!}</label>
                              </div>
                           </div>
                        @endforeach
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="column">
                     <hr/>                     
                     <button class="btn btn-pink pull-right submit" type="submit"><i class="fas fa-save"></i> Add user</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
@endsection