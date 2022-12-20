@extends('layouts.app')
{{-- page header --}}
@section('title','Income Category')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Income</li>
         <li class="breadcrumb-item active">Category</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-tools"></i> Income Category</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.finance.partials._settings_nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('finance.income.category') }}" href="{!! route('finance.income.category') !!}"><i class="fas fa-money-bill-alt"></i> Category</a>
                     </li>
                  </ul>
               </div>
               <div class="card-block">
                  <div class="p-0 m-0">
                     <div class="row mb-3">
                        <div class="col-md-12">
                           @permission('create-incomecategory')
                              <a class="btn btn-pink float-right" href="#add-category" class="btn btn-pink mb-3" data-toggle="modal"><i class="fas fa-plus"></i> Add Category</a>
                           @endpermission
                        </div>
                     </div>
                     <table id="data-table-default" class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>Title</th>
                              <th>Description</th>
                              <th width="20%">Action</th>
                           </tr>
                        </thead>
                        <tfoot>
                           <tr>
                              <th width="1%">#</th>
                              <th>Title</th>
                              <th>Description</th>
                              <th width="20%">Action</th>
                           </tr>
                        </tfoot>
                        <tbody>
                           @foreach ($categories as $category)
                              <tr>
                                 <td>{!! $count++ !!}</td>
                                 <td>{!! $category->name !!}</td>
                                 <td>{!! $category->description !!}</td>
                                 <td>
                                    @permission('update-incomecategory')
                                       <a href="javascript:;" class="btn btn-sm btn-primary edit-income" id="{!! $category->id !!}"><i class="fas fa-edit"></i> Edit</a>
                                    @endpermission
                                    @permission('delete-incomecategory')
                                       <a href="{!! route('finance.income.category.delete', $category->id) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                                    @endpermission
                                 </td>
                              </tr>
                              <!-- #modal-dialog -->
                              {{-- <div class="modal fade" id="modal-dialog{!! $category->id !!}">
                                 <div class="modal-dialog">                                    
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h4 class="modal-title">Update Category</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                       </div>
                                       {!! Form::model($category, ['route' => ['finance.income.category.update',$category->id], 'method'=>'post',]) !!}
                                       <div class="modal-body">
                                          {!! csrf_field() !!}
                                          <div class="form-group">
                                             <label for="">Name</label>
                                             {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}
                                          </div>
                                          <div class="form-group">
                                             <label for="">Descriptions</label>
                                             {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                          <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
                                          <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Category</button>
                                          <img src="{!! url('/') !!}/backend/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
                                       </div>
                                       {!! Form::close() !!}
                                    </div>                                   
                                 </div>
                              </div> --}}
                              <!-- #modal-without-animation -->
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="add-category">
      <div class="modal-dialog">
         <form action="{!! route('finance.income.category.store') !!}" method="POST">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add Category</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
               </div>
               <div class="modal-body">
                  @csrf
                  <div class="form-group">
                     <label for="">Name</label>
                     <input type="text" class="form-control" name="name" required>
                  </div>
                  <div class="form-group">
                     <label for="">Descriptions</label>
                     <textarea type="text" class="form-control" name="description" cols="5" rows="5"></textarea>
                  </div>         
               </div>
               <div class="modal-footer">
                  <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
                  <button type="submit" class="btn btn-primary submit">Submit</button>
                  <img src="{!! asset('assets/backend/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
               </div>
            </div>
         </form>
      </div>
   </div>

   <!-- #edit modal-dialog -->
   <div class="modal fade" id="edit-income" tabindex="-1" role="dialog">
      <div class="modal-dialog">   
         {!! Form::open(array('route' => 'finance.income.category.update','method' =>'post','autocomplete'=>'off')) !!}                                
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Edit Category</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>            
            <div class="modal-body">
               {!! csrf_field() !!}
               <div class="form-group">
                  <label for="">Name</label>
                  {!! Form::text('name', null, array('class' => 'form-control','id' =>'name', 'required' => '')) !!}
                  <input type="hidden" name="incomeID" id="incomeID">
               </div>
               <div class="form-group">
                  <label for="">Descriptions</label>
                  {!! Form::textarea('description', null, array('class' => 'form-control','id' => 'description')) !!}
               </div>
            </div>
            <div class="modal-footer">
               <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
               <button type="submit" class="btn btn-primary submit"><i class="fas fa-save"></i> Update Category</button>
               <img src="{!! asset('assets/backend/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
            </div>            
         </div>   
         {!! Form::close() !!}                                
      </div>
   </div>
   <!-- #modal-without-animation -->

@endsection
@section('scripts')
   <script>
      $(document).on('click', '.edit-income', function(){
         
         var id = $(this).attr('id');
			var url = "{!! url('/') !!}";
         $('#edit-income').html();
         $.ajax({
            url: url+"/finance/income/category/"+id+"/edit",
            dataType:"json",
            success:function(html){
               $('#name').val(html.data.name);
					$('#description').val(html.data.description);
					$('#incomeID').val(id);
               $('#edit-income').modal('show');
            }
         })
      });
   </script>
@endsection
