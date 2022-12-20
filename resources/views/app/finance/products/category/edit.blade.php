@extends('layouts.app')
{{-- page header --}}
@section('title','Update Category')

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
         <li class="breadcrumb-item active">Update Item Category</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-sitemap"></i> Update Product Category </h1>
      <!-- end page-header -->
      @include('partials._messages')
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
                              @foreach($categories as $cat)
                                 <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>{!! $cat->name !!}</td>
                                    <td class="font-weight-bold">
                                       @if($cat->parentID != "")
                                          {!! Finance::product_category($cat->parentID)->name !!}
                                       @endif
                                    </td>
                                    <td>{!! Finance::products_by_category_count($cat->id) !!}</td>
                                    <td>
                                       @permission('update-productcategory')
                                          <a href="{{ route('finance.product.category.edit', $cat->id) }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                       @endpermission
                                       @permission('delete-productcategory')
                                          <a href="{!! route('finance.product.category.destroy', $cat->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                     <h4 class="panel-title">Update Category</h4>
                  </div>
                  <div class="panel-body">
                     <div class="panel-body">
                        {!! Form::model($category, ['route' => ['finance.product.category.update',$category->id], 'method'=>'post','enctype'=>'multipart/form-data','data-parsley-validate' => '']) !!}
                           @csrf
                           <div class="form-group form-group-default required">
                              {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Category Name','required' => '')) !!}
                           </div>
                           <div class="form-group">
                              {!! Form::label('title', 'Parent Category', array('class'=>'control-label')) !!}
                              <select name="parent" class="form-control multiselect">
                                 @if($category->parent == 0)
                                    <option value="">Choose parent category if any</option>
                                 @else
                                    <option value="{!! $category->parent !!}">
                                       {!! App\Models\finance\products\category::where('id',$category->parent)->where('businessID',Auth::user()->businessID)->first()->name !!}
                                    </option>
                                 @endif
                                 @foreach($parents as $paro)
                                    <option value="{!! $paro->id !!}">{!! $paro->name !!}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="form-group mt-4">
                              <center>
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Category</button>
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
@section('script')

@endsection
