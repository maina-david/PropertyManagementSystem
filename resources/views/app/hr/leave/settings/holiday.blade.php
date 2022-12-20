<a href="#add-holiday" data-toggle="modal" class="btn btn-pink mb-2"><i class="far fa-calendar-plus"></i> Add Holiday</a>
<table id="data-table-default" class="table table-striped table-bordered">
   <thead>
      <tr>
         <th width="1%">
            <input type="checkbox" id="cssCheckbox1" checked />
         </th>
         <th width="5%"></th>
         <th class="text-nowrap">Holiday</th>
         <th class="text-nowrap">Dates</th>
         <th class="text-nowrap" width="12%">Action</th>
      </tr>
   </thead>
   <tbody>

   </tbody>
</table>
<div class="modal fade" id="add-holiday" tabindex="-1" role="dialog">
   <div class="modal-dialog">
      {!! Form::open(array('route' => 'hrm.leave.settings.holiday.store','method' =>'post','autocomplete'=>'off')) !!}
         <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Add Holiday</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            @csrf
            <div class="form-group form-group-default required">
               {!! Form::label('names', 'Holiday Name', array('class'=>'control-label')) !!}
               {!! Form::text('holiday', null, array('class' => 'form-control', 'required' => '')) !!}
            </div>
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group form-group-default required">
                     {!! Form::label('names', 'Start', array('class'=>'control-label')) !!}
                     {!! Form::text('start', null, array('class' => 'form-control datepicker', 'required' => '')) !!}
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group form-group-default">
                     {!! Form::label('Time', 'End', array('class'=>'control-label')) !!}
                     {!! Form::text('end', null, array('class' => 'form-control datepicker', 'required' => '')) !!}
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Holiday</button>
         </div>
      </div>
      {!! Form::close() !!}
   </div>
</div>
