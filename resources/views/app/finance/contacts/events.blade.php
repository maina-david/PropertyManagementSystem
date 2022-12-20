<a href="#create-event" class="btn btn-pink mt-3 mb-3" data-toggle="modal"><i class="fal fa-calendar-plus"></i> Add Meeting</a>
<div class="row mt-1">
   @foreach ($events as $event) 
      <div class="col-md-4">
         <!-- begin widget-list -->
         <div class="widget-list widget-list-rounded mb-2">
            <!-- begin widget-list-item -->
            <div class="widget-list-item">
               <div class="widget-list-content">
                  <h4 class="widget-list-title font-weight-bold">{!! $event->event_name !!}</h4>
                  <p class="widget-list-desc mt-1">
                     <b>Start Date :</b> {!! date("M jS, Y", strtotime($event->start_date)) !!}<br>
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
                     <li><a href="{!! route('crm.leads.events.delete',$event->id) !!}" class="delete">Delete</a></li>
                  </ul>
               </div>
            </div>
            <!-- end widget-list-item -->
         </div>
         <!-- end widget-list -->
      </div>
      <div class="modal fade" id="edit-event-{!! $event->id !!}" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-lg">
            {!! Form::model($event, ['route' => ['crm.customer.events.update', $event->id], 'method'=>'post', 'autocomplete'=>'off']) !!}
               <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title"> Edit Meeting</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  @csrf
                  <div class="row">
                     <div class="col-sm-6">
      						<div class="form-group form-group-default required">
      							{!! Form::label('names', 'Event Name', array('class'=>'control-label text-danger')) !!}
      							{!! Form::text('event_name', null, array('class' => 'form-control', 'required' => '')) !!}
                           <input type="hidden" name="customerID" value="{!! $customerID !!}" required>
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
      						<div class="form-group form-group-default">
      							{!! Form::label('Status', 'Status', array('class'=>'control-label')) !!}
      							{{ Form::select('status',[''=>'Choose status','completed'=>'Completed','rescheduled'=>'Rescheduled','cancelled' => 'Cancelled','No Show' => 'No Show','Still to meet' => 'Still to meet'], null, ['class' => 'form-control']) }}
      						</div>
      					</div>
                     <div class="col-sm-6">
      						<div class="form-group form-group-default">
      							{!! Form::label('names', 'Owner', array('class'=>'control-label')) !!}
      							{!! Form::select('owner', $employees, null, array('class' => 'form-control')) !!}
      						</div>
      					</div>
      				</div>
                  <div class="row">
                     <div class="col-sm-6">
      						<div class="form-group form-group-default required">
      							{!! Form::label('names', 'Start Date', array('class'=>'control-label text-danger')) !!}
      							{!! Form::text('start_date', null, array('class' => 'form-control datepicker', 'required' => '')) !!}
      						</div>
      					</div>
      					<div class="col-sm-6">
      						<div class="form-group form-group-default">
      							{!! Form::label('Start Time', 'Start Time', array('class'=>'control-label text-danger')) !!}
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
                  {{-- <div class="row">
                     <div class="col-sm-6">
                        <label class="i-checks i-checks-sm c-p">
                           <input type="checkbox" name="send_invitation" value="yes"> Send Email Invitation
                        </label>
      					</div>
      				</div> --}}
                  <div class="form-group">
                     {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                     {{ Form::textarea('description', null, ['class' => 'form-control ckeditor']) }}
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Meeting</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                  </center>
               </div>
            </div>
            {!! Form::close() !!}
         </div>
      </div>
   @endforeach
   <div class="col-md-12 mt-2">
      @if($events->lastPage() > 1)
         <nav aria-label="...">
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="{{ $events->url(1) }}">Previous</a>
               </li>
               @for ($i = 1; $i <= $events->lastPage(); $i++)
                  <li class="page-item {{ ($events->currentPage() == $i) ? 'active' : '' }}">
                     <a class="page-link" href="{{ $events->url($i) }}">
                           {{ $i }}
                        <span class="sr-only">(current)</span>
                     </a>
                  </li>
               @endfor
               <li class="page-item">
                  <a class="page-link" href="{{ $events->url($events->currentPage()+1) }}">Next</a>
               </li>
            </ul>
         </nav>
      @endif
   </div>
</div>
{{-- create events --}}
<div class="modal fade" id="create-event" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg">
      {!! Form::open(array('route' => 'crm.customer.events.store','method' =>'post','autocomplete'=>'off')) !!}
         <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"> Add Meeting</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            @csrf
            <div class="row">
               <div class="col-sm-6">
						<div class="form-group form-group-default required">
							{!! Form::label('names', 'Event Name', array('class'=>'control-label text-danger')) !!}
							{!! Form::text('event_name', null, array('class' => 'form-control', 'placeholder' => 'Enter event', 'required' => '')) !!}
                     <input type="hidden" name="customerID" value="{!! $customerID !!}" required>
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
						<div class="form-group form-group-default">
							{!! Form::label('Status', 'Status', array('class'=>'control-label')) !!}
							{{ Form::select('status',[''=>'Choose status','completed'=>'Completed','rescheduled'=>'Rescheduled','cancelled' => 'Cancelled','No Show' => 'No Show','Still to meet' => 'Still to meet'], null, ['class' => 'form-control']) }}
						</div>
					</div>
               <div class="col-sm-6">
						<div class="form-group form-group-default">
							{!! Form::label('names', 'Owner', array('class'=>'control-label')) !!}
							{!! Form::select('owner', $employees, null, array('class' => 'form-control')) !!}
						</div>
					</div>
				</div>
            <div class="row">
               <div class="col-sm-6">
						<div class="form-group form-group-default required">
							{!! Form::label('names', 'Start Date', array('class'=>'control-label text-danger')) !!}
							{!! Form::text('start_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'YYYY-MM-DD' , 'required' => '')) !!}
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group form-group-default required">
							{!! Form::label('Start Time', 'Start Time', array('class'=>'control-label text-danger')) !!}
							{!! Form::time('start_time', null, array('class' => 'form-control', 'required' => '')) !!}
						</div>
					</div>
				</div>
            <div class="row">
               <div class="col-sm-6">
						<div class="form-group form-group-default">
							{!! Form::label('names', 'End Date', array('class'=>'control-label')) !!}
							{!! Form::text('end_date', null, array('class' => 'form-control datepicker', 'placeholder' => 'YYYY-MM-DD')) !!}
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group form-group-default">
							{!! Form::label('End Time', 'End Time', array('class'=>'control-label')) !!}
							{!! Form::time('end_time', null, array('class' => 'form-control')) !!}
						</div>
					</div>
				</div>
            {{-- <div class="row">
               <div class="col-sm-6">
                  <label class="i-checks i-checks-sm c-p">
                     <input type="checkbox" name="send_invitation" value="yes"> Send Email Invitation
                  </label>
					</div>
				</div> --}}
            <div class="form-group">
               {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
               {{ Form::textarea('description', null, ['class' => 'form-control ckeditor']) }}
            </div>
         </div>
         <div class="modal-footer">
            <center>
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Meeting</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
            </center>
         </div>
      </div>
      {!! Form::close() !!}
   </div>
</div>
