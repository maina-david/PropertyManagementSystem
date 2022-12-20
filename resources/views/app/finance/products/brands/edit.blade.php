@extends('layouts.app')
{{-- page header --}}
@section('title','Update Brand ')

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
         <li class="breadcrumb-item"><a href="{!! route('finance.product.brand') !!}">Product Brand</a></li>
         <li class="breadcrumb-item active">Update Product Brand</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Update Product Brand </h1>
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
                              <th>Name</th>
                              {{-- <th>Products</th> --}}
                              <th width="20%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($brands as $br)
                              <tr>
                                 <td>{!! $count++ !!}</td>
                                 <td>{!! $br->name !!}</td>
                                 {{-- <td>{!! Finance::products_by_brand_count($br->id) !!}</td> --}}
                                 <td>
                                    @permission('update-productbrand')
                                    <a href="{{ route('finance.product.brand.edit', $br->id) }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                    @endpermission
                                    @permission('delete-productbrand')
                                    <a href="{!! route('finance.product.brand.destroy', $br->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                  <h4 class="panel-title">Update Brand</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     {!! Form::model($brand, ['route' => ['finance.product.brand.update',$brand->id], 'method'=>'post','enctype'=>'multipart/form-data','data-parsley-validate' => '']) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                           {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                           {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Brand Name','required' => '')) !!}
                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update brand</button>
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
