<a href="" class="btn btn-pink mt-3 mb-3" data-toggle="modal" data-target="#call-log"><i class="fal fa-phone-plus"></i> Add Call log</a>
@foreach ($logs as $log)
   <div class="card">
      <div class="card-header">{!! $log->subject !!}</div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-1">
               @if(Wingu::user($log->created_by)->employeeID != ""))
                  @if(Hr::check_employee(ingu::user($log->created_by)->employeeID) == 1)
                     @if(Hr::employee(Wingu::user($log->created_by)->employeeID)->image != "")
                        <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/hr/employee/images/'.Hr::employee(Wingu::user($log->created_by)->employeeID)->image) !!}" alt="" class="media-object rounded-corner">
                     @endif
                  @endif
               @else
                  @if(Wingu::check_user($log->created_by) == 1)
                     <img src="https://ui-avatars.com/api/?name={!! Wingu::user($log->created_by)->name  !!}&rounded=true&size=32" alt="">
                  @else 
                     <img src="https://ui-avatars.com/api/?name=No User&rounded=true&size=32" alt="">
                  @endif
               @endif 
            </div>
            <div class="col-md-11">
               <p>
                  <b>Contact person : </b><span class="text-pink">{!! $log->contact_person !!}</span><br>
                  <b>Phone Number : </b><span class="text-pink">{!! $log->phone_number !!}</span><br>
                  <b>Call Type : </b><span class="text-pink">{!! $log->call_type !!}</span><b> Duration : </b><span class="text-pink">{!! $log->hours !!}</span> hours, <span class="text-pink">{!! $log->minutes !!}</span> minutes, <span class="text-pink">{!! $log->seconds !!}</span> seconds
               </p>
               {!! $log->note !!}
            </div>
         </div>
      </div>
      <div class="card-footer text-muted">
         <div class="row">
            <div class="col-md-8">
               Added <b>by</b> <a href="#">@if(Wingu::check_user($log->created_by) == 1){!! Wingu::user($log->created_by)->name  !!}@else Unknown User @endif</a> • <b>at</b> <a href="#">{!! date('F d, Y', strtotime($log->created_at)) !!} @ {!! date('g:i a', strtotime($log->created_at)) !!}</a>     
            </div>
            <div class="col-md-4">
               <a href="{!! route('crm.customer.calllog.delete', $log->id) !!}" class="btn btn-sm btn-danger float-right delete"><i class="fas fa-trash"></i> Delete</a>
               <a href="#" data-toggle="modal" data-target="#call-log-{!! $log->id !!}" class="btn btn-sm float-right mr-2 btn-primary"><i class="fas fa-edit"></i> Edit</i></a>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="call-log-{!! $log->id !!}">
      <div class="modal-dialog modal-lg">
         {!! Form::model($log, ['route' => ['crm.customer.calllog.update', $log->id], 'method'=>'post']) !!}
            @csrf
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title"> Update Call Log</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Subject', 'Subject', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('subject', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Subject')) !!}
                           <input type="hidden" name="customerID" value="{!! $customerID !!}" required>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Phone number', 'Phone Number', array('class'=>'control-label')) !!}
                           {!! Form::number('phone_number', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter number')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Contact Person', 'Contact Person', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('contact_person', null, array('class' => 'form-control', 'required' => '', 'placeholder'=>'Enter contacted person')) !!}
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group form-group-default">
                           {!! Form::label('Hour', 'Hour', array('class'=>'control-label')) !!}
                           {!! Form::number('hours', null, array('class' => 'form-control', 'min' => '0', 'max' => '24')) !!}
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Minutes', 'Minutes', array('class'=>'control-label text-danger')) !!}
                           {!! Form::number('minutes', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '', 'placeholder' => 'Enter number')) !!}
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Seconds', 'Seconds', array('class'=>'control-label')) !!}
                           {!! Form::number('seconds', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '' , 'placeholder' => 'Enter number')) !!}
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('Call Type', 'Call Type', array('class'=>'control-label text-danger')) !!}
                           {!! Form::select('call_type', ['' => 'Choose call type','Inbound' => 'Inbound','Outbound' => 'Outbound'], null, array('class' => 'form-control', 'required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('status', 'Status', array('class'=>'control-label')) !!}
                           {!! Form::select('statusID', $status, null, array('class' => 'form-control')) !!}
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Note</label>
                          {!! Form::textarea('note', null, array('class' => 'form-control ckeditor', 'required' => '')) !!}
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Call log</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                  </center>
               </div>
            </div>
         {!! Form::close() !!}
      </div>
   </div>
@endforeach
<div class="row mt-2">
   <div class="col-md-12">
      @if($logs->lastPage() > 1)
         <nav aria-label="...">
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="{{ $logs->url(1) }}">Previous</a>
               </li>
               @for ($i = 1; $i <= $logs->lastPage(); $i++)
                  <li class="page-item {{ ($logs->currentPage() == $i) ? 'active' : '' }}">
                     <a class="page-link" href="{{ $logs->url($i) }}">
                           {{ $i }}
                        <span class="sr-only">(current)</span>
                     </a>
                  </li>
               @endfor
               <li class="page-item">
                  <a class="page-link" href="{{ $logs->url($logs->currentPage()+1) }}">Next</a>
               </li>
            </ul>
         </nav>
      @endif
   </div>
</div>
{{-- normal note --}}
<div class="modal fade" id="call-log">
   <div class="modal-dialog modal-lg">
      <form action="{!! route('crm.customer.calllog.store') !!}" method="post">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> New Call Log</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Subject', 'Subject', array('class'=>'control-label text-danger')) !!}
                        {!! Form::text('subject', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Subject')) !!}
                        <input type="hidden" name="customerID" value="{!! $customerID !!}" required>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Phone number', 'Phone Number', array('class'=>'control-label text-danger')) !!}
                        {!! Form::number('phone_number', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter phone number')) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Contact Person', 'Contact Person', array('class'=>'control-label text-danger')) !!}
                        {!! Form::text('contact_person', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter name')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        {!! Form::label('Hour', 'Hour', array('class'=>'control-label')) !!}
                        {!! Form::number('hours', null, array('class' => 'form-control', 'min' => '0', 'max' => '24', 'placeholder' => 'Enter number')) !!}
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Minutes', 'Minutes', array('class'=>'control-label text-danger')) !!}
      						{!! Form::number('minutes', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '', 'placeholder' => 'Enter number')) !!}
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Seconds', 'Seconds', array('class'=>'control-label text-danger')) !!}
      						{!! Form::number('seconds', null, array('class' => 'form-control', 'min' => '0', 'max' => '60', 'required' => '', 'placeholder' => 'Enter number')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Call Type', 'Call Type', array('class'=>'control-label text-danger')) !!}
                        {!! Form::select('call_type', ['' => 'Choose call type','Inbound' => 'Inbound','Outbound' => 'Outbound'], null, array('class' => 'form-control', 'required' => '')) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group form-group-default">
                        {!! Form::label('status', 'Status', array('class'=>'control-label')) !!}
      						{!! Form::select('statusID', $status, null, array('class' => 'form-control')) !!}
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                       <label for="">Note</label>
                       {!! Form::textarea('note', null, array('class' => 'form-control ckeditor', 'required' => '')) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
               </center>
            </div>
         </div>
      </form>
   </div>
</div>
