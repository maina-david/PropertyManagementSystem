@extends('layouts.app')
{{-- page header --}}
@section('title')Add Role @endsection

{{-- dashboad menu --}}
@section('sidebar')
   @include('app.settings.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li>
         <li class="breadcrumb-item"><a href="javascript:;">Roles</a></li>
         <li class="breadcrumb-item active">List</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-shield-alt"></i>  Add Role</h1>
      @include('partials._messages')
      <form action="{!! route('settings.roles.store') !!}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
         @csrf
         <div class="panel panel-default" data-sortable-id="ui-widget-1">
            <div class="panel-heading">
               <h4 class="panel-title">Add Role</h4>
            </div>
            <div class="panel-body">
               <div class="col-md-12">
                  <div class="form-group">
                     <label for="name" class="">Role Name</label>
                     {!! Form::text('display_name', null, array('class' => 'form-control')) !!}
                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     {!! Form::textarea('description', null, array('class' => 'form-control ckeditor')) !!}
                  </div>
               </div>
            </div>
         </div>
         <div id="accordion" class="accordion">  
            @foreach ($modules as $module)
               <div class="card">
                  <div class="card-header pointer-cursor d-flex align-items-center @if($module->modID != 1) collapsed @endif" data-toggle="collapse" data-target="#collapse{!! $module->modID !!}">
                     {!! $module->name !!}
                  </div>
                  <div id="collapse{!! $module->modID !!}" class="collapse @if($module->modID == 1) show @endif" data-parent="#accordion">
                     <div class="card-body">
                        <div class="row">
                           @foreach(Wingu::get_module_funations($module->modID) as $group)
                              <div class="col-md-6">
                                 <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                       <th colspan="5">{!! $group->title !!}</th>
                                    </thead>
                                    <tr>
                                       @foreach(Wingu::permissions_by_group($group->id) as $permission )
                                          <td>
                                             <div class="">
                                                <input type="checkbox" value="{!! $permission->id !!}" name="permissions[]">
                                                @php
                                                   echo substr($permission->display_name, 0, strrpos($permission->display_name, ' '));
                                                @endphp
                                             </div>
                                          </td>
                                       @endforeach
                                    </tr>
                                 </table>
                              </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
         <button type="submit" class="btn btn-pink submit float-right mb-5"><i class="fas fa-save"></i> Create Role</button>
         <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none loat-right" alt="" width="10%">
      </form>
   </div>
@endsection
@section('scripts')
	<script src="{!! asset('assets/plugins/ckeditor/4/full/ckeditor.js') !!}"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
