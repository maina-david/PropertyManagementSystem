<div class="row">
   <div class="col-md-12">
      @permission('create-expensecategory')
         <a href="#" class="btn btn-pink btn-sm m-b-10 p-l-5 offset-md-10 float-right" title="Add Category" data-toggle="modal" data-target="#category">
            <i class="fal fa-plus-circle"></i> Add Category 
         </a>
      @endpermission
   </div>
</div>
<table id="data-table-default" class="table table-striped table-bordered">
   <thead>
      <tr>
         <th width="1%">#</th>
         <th>Name</th>
         <th>Description</th>
         <th width="20%"><center>Action</center></th>
      </tr>
   </thead>
   <tbody>
      @foreach ($category as $cat)
         <tr>
            <td>{!! $count++ !!}</td>
            <td>{!! $cat->category_name !!}</td>
            <td>{!! $cat->category_description !!}</td>
            <td>
               @permission('update-expensecategory')
                  <a href="#" data-toggle="modal" data-target="#edit-category-{!! $cat->id !!}" class="btn btn-pink btn-sm"><i class="far fa-edit"></i> Edit</a>
               @endpermission
               @permission('create-expensecategory')
                  <a href="{{ route('finance.expense.category.destroy', $cat->id) }}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i>&nbsp;&nbsp; Delete</a>
               @endpermission
            </td>
         </tr>      
         <div class="modal fade" id="edit-category-{!! $cat->id !!}">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title">Edit Category</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  {!! Form::model($cat, ['route' => ['finance.expense.category.update',$cat->id], 'method'=>'post']) !!}
                  @csrf
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
                        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-pink submit">Update Category</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>      
      @endforeach
   </tbody>
</table>

{!! Form::open(array('route' => 'finance.expense.category.store','enctype'=>'multipart/form-data','data-parsley-validate' => '', 'method'=>'post' )) !!}
   @csrf
   <div class="modal fade" id="category">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add Expense Category</h4>
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
               <button type="submit" class="btn btn-success submit">Submit Information</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="20%">
            </div>
         </div>
      </div>
   </div>
{!! Form::close() !!}