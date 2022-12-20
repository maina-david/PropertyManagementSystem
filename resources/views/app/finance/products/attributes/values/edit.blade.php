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
         <li class="breadcrumb-item">Values</li>
         <li class="breadcrumb-item">{!! $attribute->name !!}</li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Attributes > {!! $attribute->name !!} > Edit</h1>
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
                              <th>Values</th>
                              <th width="20%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($values as $value)
                              <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>{!! $value->value !!}</td>
                                    <td>
                                       <a href="{{ route('finance.product.attributes.value.edit', $value->id) }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                       @permission('delete-productcategory')
                                          <a href="{!! route('finance.product.attributes.value.delete', $value->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                  <h4 class="panel-title">Edit value</h4>
               </div>
               <div class="panel-body">
                  <div class="panel-body">
                     {!! Form::model($edit, ['route' => ['finance.product.attributes.value.update',$edit->id], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                        @csrf
                        <div class="form-group form-group-default required">
                           {!! Form::label('value', 'value', array('class'=>'control-label')) !!}
                           {!! Form::text('value', null, array('class' => 'form-control', 'placeholder' => 'Enter value','required' => '')) !!}
                           <input type="hidden" value="{!! $attribute->id !!}" name="attributeID" required>
                        </div>
                        <div class="form-group mt-4">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update value</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
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