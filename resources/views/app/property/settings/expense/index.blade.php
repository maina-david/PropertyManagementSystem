@extends('layouts.app')
@section('title','Settings | Expense Categories')
@section('sidebar')
	@include('app.property.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings | Expense Categories</h1>
      <div class="row">
         @include('app.property.settings._settings_nav')
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <a href="#" class="btn btn-danger float-right" title="Add Category" data-toggle="modal" data-target="#category">
                           <i class="fal fa-plus-circle"></i> Add Category
                        </a>
                     </div>
                     <div class="col-md-12">
                        <div class="card">
                           <div class="card-body">
                              <table id="example5" class="table table-striped table-bordered">
                                 <thead>
                                    <tr>
                                       <th width="1%">#</th>
                                       <th>Name</th>
                                       <th>Description</th>
                                       <th width="21%"><center>Action</center></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($category as $cat)
                                       <tr>
                                          <td>{!! $count++ !!}</td>
                                          <td><p>{!! $cat->category_name !!}</p></td>
                                          <td>{!! $cat->category_description !!}</td>
                                          <td>
                                             <a href="#" data-toggle="modal" data-target="#edit-category-{!! $cat->id !!}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a>
                                             <a href="{{ route('property.expense.category.destroy', $cat->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>&nbsp;&nbsp; Delete</a>
                                          </td>
                                       </tr>
                                       <div class="modal fade" id="edit-category-{!! $cat->id !!}">
                                          <div class="modal-dialog">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                   <h4 class="modal-title">Edit Category</h4>
                                                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                {!! Form::model($cat, ['route' => ['property.expense.category.update',$cat->id], 'method'=>'post']) !!}
                                                   @csrf
                                                   <div class="modal-body">
                                                      <div class="form-group form-group-default">
                                                         {!! Form::label('Category Name', 'Category Name', array('class'=>'control-label text-danger')) !!}
                                                         {!! Form::text('category_name', null, array('class' => 'form-control', 'placeholder' => 'Category Name', 'required' =>'' )) !!}
                                                      </div>
                                                      <div class="form-group">
                                                         {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                                                         {!! Form::textarea('category_description', null, array('class' => 'form-control', 'size' => '6x10', 'placeholder' => 'Description')) !!}
                                                      </div>
                                                   </div>
                                                   <div class="modal-footer">
                                                      <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Update Category</button>
                                                      <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                                                   </div>
                                                {!! Form::close() !!}
                                             </div>
                                          </div>
                                       </div>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      {!! Form::open(array('route' => 'property.expense.category.store','enctype'=>'multipart/form-data','data-parsley-validate' => '', 'method'=>'post' )) !!}
         @csrf
         <div class="modal fade" id="category">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title">Add Category</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group form-group-default required ">
                        {!! Form::label('Category Name', 'Category Name', array('class'=>'control-label')) !!}
                        {!! Form::text('category_name', null, array('class' => 'form-control', 'placeholder' => 'Category Name', 'required' =>'' )) !!}
                     </div>
                     <div class="form-group">
                        {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                        {!! Form::textarea('category_description', null, array('class' => 'form-control', 'size' => '6x10', 'placeholder' => 'Description')) !!}
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-primary submit"><i class="fas fa-save"></i> Submit Information</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                  </div>
               </div>
            </div>
         </div>
      {!! Form::close() !!}
   </div>
@endsection
