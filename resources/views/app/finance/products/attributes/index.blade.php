@extends('layouts.app')
{{-- page header --}}
@section('title','Product Attributes')
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
         <li class="breadcrumb-item"><a href="{!! route('finance.product.attributes') !!}">Product Attributes</a></li>
         <li class="breadcrumb-item active">All</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">All Attributes</h1>
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
                                 <th>Name</th>
                                 <th>Values</th>
                                 <th width="26%">Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($attributes as $attribute)
                                 <tr>
                                       <td>{!! $count++ !!}</td>
                                       <td>{!! $attribute->name !!}</td>
                                       <td>{!! Finance::values_per_attribute($attribute->id) !!}</td>
                                       <td>
                                          @permission('update-productattributevalues')
                                          <a href="{{ route('finance.product.attributes.edit', $attribute->id) }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                          @endpermission
                                          @permission('create-productattributevalues')
                                          <a href="{!! route('finance.product.attributes.value.create', $attribute->id) !!}" class="btn btn-info"><i class="fas fa-plus"></i></a>
                                          @endpermission
                                          @permission('delete-productattributevalues')
                                          <a href="{!! route('finance.product.attributes.delete', $attribute->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                  <h4 class="panel-title">Add Attributes</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     {!! Form::open(array('route' => 'finance.product.attributes.store')) !!}
                           @csrf
                           <div class="form-group form-group-default required">
                              {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Attribute Name','required' => '')) !!}
                           </div>
                           <div class="form-group mt-4">
                              <center>
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Attributes</button>
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