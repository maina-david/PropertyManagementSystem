@extends('layouts.app')
{{-- page header --}}
@section('title','Item Category')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.product.category') !!}">Item Category</a></li>
         <li class="breadcrumb-item active">Categories</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-sitemap"></i> All Categories</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th width="20%">Name</th>
                              <th width="20%">Parent</th>
                              <th width="13%">Items</th>
                              <th class="text-center" width="15.5%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($category as $all)
                              <tr>
                                 <td>{!! $count++ !!}</td>
                                 <td>{!! $all->name !!}</td>
                                 <td class="font-weight-bold">
												@if($all->parentID != "")
													{!! Finance::product_category($all->parentID)->name !!}
												@endif
                                 </td>
                                 <td>{!! Finance::products_by_category_count($all->id) !!}</td>
                                 <td>
                                    @permission('update-productcategory')
                                       <a href="{{ route('finance.product.category.edit', $all->id) }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                    @endpermission
                                    @permission('delete-productcategory')
                                       <a href="{!! route('finance.product.category.destroy', $all->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Add Category</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     {!! Form::open(array('route' => 'finance.product.category.store')) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                           {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                           {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Category Name','required' => '')) !!}
                        </div>
                        <div class="form-group">
                           {!! Form::label('title', 'Parent Category', array('class'=>'control-label')) !!}
                           <select name="parent" class="form-control multiselect">
                              <option value="">Choose parent category</option>
                              @foreach($category as $cat)
                                 <option value="{!! $cat->id !!}">{!! $cat->name !!}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Category</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')

@endsection
