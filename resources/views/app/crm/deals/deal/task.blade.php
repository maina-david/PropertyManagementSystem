<a href="#create-task" class="btn btn-pink float-right mb-3" data-toggle="modal"><i class="fal fa-tasks"></i> Add Tasks</a>

@foreach ($tasks as $task)
   <div class="widget-list-item mb-1">
      <div class="widget-list-media">
         @if($task->status == 'Completed')
            <img src="{!! asset('assets/img/complete.png') !!}" alt="" class="rounded lazy">
         @else
            @if($task->priority == 'High')
               <img src="{!! asset('assets/img/urgent.png') !!}" alt="" class="rounded lazy">
            @elseif($task->priority == 'Normal')
               <img src="{!! asset('assets/img/medium.png') !!}" alt="" class="rounded lazy">
            @else
               <img src="{!! asset('assets/img/deafult.png') !!}" alt="" class="rounded lazy">
            @endif
         @endif
      </div>
      <div class="widget-list-content">
         <h4 class="widget-list-title mb-1 mt-1">  {!! $task->task !!} </h4>
         <p class="widget-list-desc font-bold">Priority :<span class="font-weight-bold">{!! $task->priority !!}</span> | Status : <span class="font-weight-bold">{!! $task->status !!}</span> |  Assigned To :<span class="text-primary">@if(Hr::check_employee($task->assigned_to) == 1) {!! Hr::employee($task->assigned_to)->names !!} @endif </span> | Due Date : <b>{!! date('d F Y', strtotime($task->date)) !!}</b>
         </p>
         <a href="{!! route('crm.deals.task.delete',$task->id) !!}" class="float-right ml-2 badge badge-danger delete"><i class="fas fa-trash"></i> Delete</a>
         {{-- <a href="#" class="float-right ml-2 badge badge-warning"><i class="fas fa-eye"></i> View</a> --}}
         <a href="#update-task-{!! $task->id !!}" class="float-right ml-2 badge badge-primary" data-toggle="modal"><i class="fas fa-pen-square"></i> Edit</a>
      </div>
   </div>
   <div class="modal fade" id="update-task-{!! $task->id !!}" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
         {!! Form::model($task, ['route' => ['crm.deals.task.update', $task->id], 'method'=>'post', 'autocomplete'=>'off']) !!}
            <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add Task</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="row">
                  <div class="col-sm-6">
   						<div class="form-group form-group-default required">
   							{!! Form::label('names', 'Task', array('class'=>'control-label')) !!}
   							{!! Form::text('task', null, array('class' => 'form-control', 'placeholder' => 'Enter task')) !!}
                        <input type="hidden" name="dealID" value="{!! $deal->dealID !!}" required>
   						</div>
   					</div>
   					<div class="col-sm-6">
   						<div class="form-group form-group-default required">
   							{!! Form::label('Category', 'Category', array('class'=>'control-label')) !!}
   							{{ Form::select('category',[''=>'Choose Category','Call'=>'Call','Email'=>'Email','Follow_up' => 'Follow_up','Meeting' => 'Meeting','Milestone' => 'Milestone','Tweet' => 'Tweet','Other' => 'Other'], null, ['class' => 'form-control']) }}
   						</div>
   					</div>
   				</div>
               <div class="row">
                  <div class="col-sm-6">
   						<div class="form-group form-group-default required">
   							{!! Form::label('names', 'Date (Due)', array('class'=>'control-label')) !!}
   							{!! Form::text('date', null, array('class' => 'form-control datepicker', 'placeholder' => '')) !!}
   						</div>
   					</div>
   					<div class="col-sm-6">
   						<div class="form-group form-group-default">
   							{!! Form::label('Time', 'Time', array('class'=>'control-label')) !!}
   							{!! Form::time('time', null, array('class' => 'form-control', 'placeholder' => '')) !!}
   						</div>
   					</div>
   				</div>
               <div class="row">
                  <div class="col-sm-6">
   						<div class="form-group form-group-default required">
   							{!! Form::label('names', 'Assigned To', array('class'=>'control-label')) !!}
   							{!! Form::select('assigned_to', $employees, null, array('class' => 'form-control', 'placeholder' => '')) !!}
   						</div>
   					</div>
   					<div class="col-sm-6">
   						<div class="form-group form-group-default">
   							{!! Form::label('Time', 'Priority', array('class'=>'control-label')) !!}
   							{{ Form::select('priority',[''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, ['class' => 'form-control']) }}
   						</div>
   					</div>
   				</div>
               <div class="row">
                  <div class="col-sm-6">
   						<div class="form-group form-group-default required">
   							{!! Form::label('status', 'Status', array('class'=>'control-label')) !!}
   							{{ Form::select('status',[''=>'Choose status','Yet to Start'=>'Yet to Start','In Progress'=>'In Progress','Completed' => 'Completed'], null, ['class' => 'form-control']) }}
   						</div>
   					</div>
   				</div>
               <div class="form-group">
                  {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                  {{ Form::textarea('description', null, ['class' => 'form-control ckeditor']) }}
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Task</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
            </div>
         </div>
         {!! Form::close() !!}
      </div>
   </div>

@endforeach
{{-- create task --}}
<div class="modal fade" id="create-task" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg">
      <form action="{!! route('crm.deals.task.store',$deal->dealID) !!}" method="post" autocomplete="off">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Add Task</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('names', 'Task', array('class'=>'control-label')) !!}
                        {!! Form::text('task', null, array('class' => 'form-control', 'placeholder' => 'Enter task')) !!}
                        <input type="hidden" name="dealID" value="{!! $deal->dealID !!}" required>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Category', 'Category', array('class'=>'control-label')) !!}
                        {{ Form::select('category',[''=>'Choose Category','Call'=>'Call','Email'=>'Email','Follow_up' => 'Follow_up','Meeting' => 'Meeting','Milestone' => 'Milestone','Tweet' => 'Tweet','Other' => 'Other'], null, ['class' => 'form-control']) }}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('names', 'Date (Due)', array('class'=>'control-label')) !!}
                        {!! Form::text('date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Choose date')) !!}
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('Time', 'Time', array('class'=>'control-label')) !!}
                        {!! Form::time('time', null, array('class' => 'form-control', 'placeholder' => '')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('names', 'Assigned To', array('class'=>'control-label')) !!}
                        {!! Form::select('assigned_to', $employees, null, array('class' => 'form-control', 'placeholder' => '')) !!}
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('Time', 'Priority', array('class'=>'control-label')) !!}
                        {{ Form::select('priority',[''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, ['class' => 'form-control']) }}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('status', 'Status', array('class'=>'control-label')) !!}
                        {{ Form::select('status',[''=>'Choose status','Yet to Start'=>'Yet to Start','In Progress'=>'In Progress','Completed' => 'Completed'], null, ['class' => 'form-control']) }}
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                  {{ Form::textarea('description', null, ['class' => 'form-control ckeditor']) }}
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Task</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
            </div>
         </div>
      </form>
   </div>
</div>
