@permission('create-payments')
   <div class="row mb-3">
      <div class="col-md-12">
         <a class="btn btn-pink float-right" href="#add-mode" class="btn btn-pink mb-3" data-toggle="modal"><i class="fas fa-plus"></i> Add Payment Modes</a>
      </div>
   </div>
@endpermission
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
      @foreach ($defaults as $default)
         <tr>
            <td>{!! $count++ !!}</td>
            <td>{!! $default->name !!}</td>
            <td>{!! $default->description !!}</td>
            <td>
               <a href="" class="btn btn-sm btn-default btn-block">Default</a>
            </td>
         </tr>
      @endforeach
      @foreach($accounts as $account)
         <tr>
            <td>{!! $count++ !!}</td>
            <td>{!! $account->name !!}</td>
            <td>{!! $account->description !!}</td>
            <td>
               @permission('update-payments')
                  <a href="#modal-dialog{!! $account->id !!}" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fas fa-edit"></i> Edit</a>
               @endpermission
               @permission('delete-payments')
                  <a href="{!! route('finance.payment.mode.delete', $account->id) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
               @endpermission
            </td>
         </tr>
         <!-- #modal-dialog -->
         <div class="modal fade" id="modal-dialog{!! $account->id !!}">
            <div class="modal-dialog">
               {!! Form::model($account, ['route' => ['finance.payment.mode.update',$account->id], 'method'=>'post',]) !!}
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title">Update Payment Mode</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     </div>
                     <div class="modal-body">
                        {!! csrf_field() !!}
                        <div class="form-group">
                           <label for="">Mode Name</label>
                           {!! Form::text('name', null, array('class' => 'form-control', 'required' => '')) !!}
                        </div>
                        <div class="form-group">
                           <label for="">Descriptions</label>
                           {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </div>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
         <!-- #modal-without-animation -->
      @endforeach
   </tbody>
</table>
{!! Form::open(array('route' => 'finance.payment.mode.store','enctype'=>'multipart/form-data','method'=>'post' )) !!}
   @csrf
   <div class="modal fade" id="add-mode">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add payment mode</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <div class="form-group form-group-default required ">
                  {!! Form::label('Mode name', 'Mode name', array('class'=>'control-label')) !!}
                  {!! Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Mode Name', 'required' =>'' )) !!}
               </div>
               <div class="form-group">
                  {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                  {!! Form::textarea('description', null, array('class' => 'form-control', 'size' => '6x10', 'placeholder' => 'Description')) !!}
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit Information</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
            </div>
         </div>
      </div>
   </div>
{!! Form::close() !!}