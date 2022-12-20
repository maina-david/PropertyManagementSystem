@extends('layouts.app')
{{-- page header --}}
@section('title','Update Tags')

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
         <li class="breadcrumb-item"><a href="{!! route('finance.product.tags') !!}">Product Tags</a></li>
         <li class="breadcrumb-item active">Update Product Tags</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Update Product Tags </h1>
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
                              @foreach($tags as $tg)
                                 <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>{!! $tg->name !!}</td>
                                    {{-- <td>{!! Finance::products_by_tags_count($tg->id) !!}</td> --}}
                                    <td>
                                       @permission('update-producttags')
                                    <a href="{{ route('finance.product.tags.edit', $tg->id) }}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                    @endpermission
                                    @permission('delete-producttags')
                                    <a href="{!! route('finance.product.tags.destroy', $tg->id) !!}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
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
                     <h4 class="panel-title">Update Tag</h4>
                  </div>
                  <div class="panel-body">
                     <div class="panel-body">
                        {!! Form::model($tag, ['route' => ['finance.product.tags.update',$tag->id], 'method'=>'post','enctype'=>'multipart/form-data','data-parsley-validate' => '']) !!}
                           @csrf
                           <div class="form-group form-group-default required">
                              {!! Form::label('name', 'Name', array('class'=>'control-label')) !!}
                              {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter Tag Name','required' => '')) !!}
                           </div>
                           <div class="form-group mt-4">
                              <center>
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update tags</button>
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
