<div class="row">
   <div class="col-md-12">
      <a href="#create-event" class="btn btn-pink mb-3 pull-right" data-toggle="modal"><i class="fas fa-calendar-plus"></i> Add Appointment</a>
   </div>
</div>
<div class="row">
   @foreach ($appointments as $event) 
      <div class="col-md-4">
         <!-- begin widget-list -->
         <div class="widget-list widget-list-rounded mb-2">
            <!-- begin widget-list-item -->
            <div class="widget-list-item">
               <div class="widget-list-content">
                  <h4 class="widget-list-title font-weight-bold">{!! $event->event_name !!}</h4>
                  <p class="widget-list-desc mt-1">
                     <b>Start Date :</b> {!! date("F m, Y", strtotime($event->start_date)) !!}<br>
                     <b>Start Time :</b> {!! $event->start_time !!}<br>
                     <b>Added :</b> {!! Helper::get_timeago(strtotime($event->created_at)) !!}<br>
                     <b>Status :</b> {!! $event->status !!}<br>
                     @if($event->owner != "")
                        <b>Owner :</b>  @if(Hr::check_employee($event->owner) > 0){!! Hr::employee($event->owner)->names !!}@endif
                     @endif   
                  </p>
               </div>
               <div class="widget-list-action">
                  <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                  <i class="fa fa-ellipsis-h f-s-14"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right">
                     <li><a href="#edit-event-{!! $event->id !!}" data-toggle="modal">Edit</a></li>
                     <li><a href="{!! route('crm.deals.appointments.delete',$event->id) !!}" class="delete">Delete</a></li>
                  </ul>
               </div>
            </div>
            <!-- end widget-list-item -->
         </div>
         <!-- end widget-list -->
      </div>
      <div class="modal fade" id="edit-event-{!! $event->id !!}" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-lg">
            {!! Form::model($event, ['route' => ['crm.deals.appointments.update', $event->id], 'method'=>'post', 'autocomplete'=>'off']) !!}
               <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title"> Edit Appointment</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  @csrf
                  <div class="row">
                     <div class="col-sm-6">
      						<div class="form-group form-group-default required">
      							{!! Form::label('names', 'Title', array('class'=>'control-label')) !!}
      							{!! Form::text('title', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter title')) !!}
                           <input type="hidden" name="dealID" value="{!! $deal->dealID !!}" required>
      						</div>
      					</div>
                     <div class="col-sm-6">
      						<div class="form-group form-group-default">
      							{!! Form::label('Time', 'Priority', array('class'=>'control-label')) !!}
      							{{ Form::select('priority',[''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, ['class' => 'form-control', 'required' => '']) }}
      						</div>
      					</div>
      				</div>
                  <div class="row">
                     <div class="col-sm-6">
      						<div class="form-group form-group-default required">
      							{!! Form::label('Status', 'Status', array('class'=>'control-label')) !!}
      							{{ Form::select('status',[''=>'Choose status','completed'=>'Completed','rescheduled'=>'Rescheduled','cancelled' => 'Cancelled','No Show' => 'No Show','Still to meet' => 'Still to meet'], null, ['class' => 'form-control', 'required' => '']) }}
      						</div>
      					</div>
                     <div class="col-sm-6">
      						<div class="form-group form-group-default required">
      							{!! Form::label('names', 'Owner', array('class'=>'control-label')) !!}
      							{!! Form::select('owner', $employees, null, array('class' => 'form-control', 'required' => '')) !!}
      						</div>
      					</div>
      				</div>
                  <div class="row">
                     <div class="col-sm-6">
      						<div class="form-group form-group-default required">
      							{!! Form::label('names', 'Start Date', array('class'=>'control-label')) !!}
      							{!! Form::text('start_date', null, array('class' => 'form-control datepicker', 'required' => '')) !!}
      						</div>
      					</div>
      					<div class="col-sm-6">
      						<div class="form-group form-group-default">
      							{!! Form::label('Start Time', 'Start Time', array('class'=>'control-label')) !!}
      							{!! Form::time('start_time', null, array('class' => 'form-control', 'required' => '')) !!}
      						</div>
      					</div>
      				</div>
                  <div class="row">
                     <div class="col-sm-6">
      						<div class="form-group form-group-default">
      							{!! Form::label('names', 'End Date', array('class'=>'control-label')) !!}
      							{!! Form::text('end_date', null, array('class' => 'form-control datepicker')) !!}
      						</div>
      					</div>
      					<div class="col-sm-6">
      						<div class="form-group form-group-default">
      							{!! Form::label('End Time', 'End Time', array('class'=>'control-label')) !!}
      							{!! Form::time('end_time', null, array('class' => 'form-control')) !!}
      						</div>
      					</div>
      				</div>
                  <div class="row">
                     <div class="col-sm-6">
                        <label class="i-checks i-checks-sm c-p">
                           <input type="checkbox" name="send_invitation" value="yes"> Send Email Invitation
                        </label>
      					</div>
      				</div>
                  <div class="form-group">
                     {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                     {{ Form::textarea('description', null, ['class' => 'form-control ckeditor']) }}
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Appointment</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </div>
            </div>
            {!! Form::close() !!}
         </div>
      </div>
   @endforeach
</div>
{{-- create events --}}
<div class="modal fade" id="create-event" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg">
      <form action="{!! route('crm.deals.appointments.store',$deal->id) !!}" method="post" autocomplete="off">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> Add Appointment</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('names', 'Title', array('class'=>'control-label')) !!}
                        {!! Form::text('title', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter title')) !!}
                        <input type="hidden" name="dealID" value="{!! $deal->dealID !!}" required>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('Time', 'Priority', array('class'=>'control-label')) !!}
                        {{ Form::select('priority',[''=>'Choose Priority','High'=>'High','Normal'=>'Normal','Low' => 'Low'], null, ['class' => 'form-control', 'required' => '']) }}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Status', 'Status', array('class'=>'control-label')) !!}
                        {{ Form::select('status',[''=>'Choose status','completed'=>'Completed','rescheduled'=>'Rescheduled','cancelled' => 'Cancelled','No Show' => 'No Show','Still to meet' => 'Still to meet'], null, ['class' => 'form-control', 'required' => '']) }}
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('names', 'Owner', array('class'=>'control-label')) !!}
                        {!! Form::select('owner', $employees, null, array('class' => 'form-control', 'required' => '')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('names', 'Start Date', array('class'=>'control-label')) !!}
                        {!! Form::text('start_date', null, array('class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'Choose date')) !!}
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('Start Time', 'Start Time', array('class'=>'control-label')) !!}
                        {!! Form::time('start_time', null, array('class' => 'form-control', 'required' => '')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('names', 'End Date', array('class'=>'control-label')) !!}
                        {!! Form::text('end_date', null, array('class' => 'form-control datepicker','placeholder' => 'Choose date')) !!}
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('End Time', 'End Time', array('class'=>'control-label')) !!}
                        {!! Form::time('end_time', null, array('class' => 'form-control')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <label class="i-checks i-checks-sm c-p">
                        <input type="checkbox" name="send_invitation" value="yes"> Send Email Invitation
                     </label>
                  </div>
               </div>
               <div class="form-group">
                  {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                  {{ Form::textarea('description', null, ['class' => 'form-control ckeditor']) }}
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Appointment</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
            </div>
         </div>
      </form>
   </div>
</div>
