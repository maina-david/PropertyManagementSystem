<div class="row">
   <div class="col-md-12 mb-3">
      <a href="javascript;" data-toggle="modal" data-target="#call-log" class="btn btn-pink btn-sm float-right"><i class="fal fa-sticky-note"></i> Add Note</a>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <ul class="media-list media-list-with-divider">
               @foreach ($notes as $note)
                  <li class="media media-sm">
                     <a class="media-left" href="javascript:;">
                        @if(Wingu::user($note->created_by)->employeeID != ""))
                           @if(Hr::check_employee(ingu::user($note->created_by)->employeeID) == 1)
                              @if(Hr::employee(Wingu::user($note->created_by)->employeeID)->image != "")
                                 <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/hr/employee/images/'.Hr::employee(Wingu::user($note->created_by)->employeeID)->image) !!}" alt="" class="media-object rounded-corner">
                              @endif
                           @endif
                        @else
                           @if(Wingu::check_user($note->created_by) == 1)
                              <img src="https://ui-avatars.com/api/?name={!! Wingu::user($note->created_by)->name  !!}&rounded=true&size=32" alt="">
                           @else 
                              <img src="https://ui-avatars.com/api/?name=No User&rounded=true&size=32" alt="">
                           @endif
                        @endif 
                     </a>
                     <div class="media-body">
                        <h5 class="media-heading">{!! $note->subject !!}</h5>
                        {!! $note->note !!}
                        <p class="mt-2">
                           Note • <b>by</b> <a href="#">@if(Wingu::check_user($note->created_by) == 1){!! Wingu::user($note->created_by)->name  !!}@else Unknown User @endif</a> • <b>at</b> <a href="#">{!! date('F d, Y', strtotime($note->created_at)) !!} @ {!! date('g:i a', strtotime($note->created_at)) !!}</a>
                           <a href="{!! route('crm.deals.notes.delete', $note->id) !!}" class="btn btn-sm btn-danger float-right delete"><i class="fas fa-trash"></i></a>
                           <a href="#" data-toggle="modal" data-target="#call-log-{!! $note->id !!}" class="btn btn-sm btn-default float-right mr-2"><i class="fas fa-edit"></i></a>
                        </p>
                     </div>
                  </li>
                  <hr>
                  <div class="modal fade" id="call-log-{!! $note->id !!}">
                     <div class="modal-dialog modal-lg">
                        {!! Form::model($note, ['route' => ['crm.deals.notes.update', $note->id], 'method'=>'post']) !!}
                           @csrf
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h4 class="modal-title"> Update note</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group form-group-default required">
                                          {!! Form::label('Subject', 'Subject', array('class'=>'control-label')) !!}
                                          {!! Form::text('subject', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter call subject')) !!}
                                          <input type="hidden" name="dealID" value="{!! $deal->dealID !!}" required>
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
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit</button>
                                 <img src="{!! asset('/assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                              </div>
                           </div>
                        {!! Form::close() !!}
                     </div>
                  </div>
               @endforeach
            </ul>
         </div>
      </div>
   </div>
</div>
{{-- normal note --}}
<div class="modal fade" id="call-log">
   <div class="modal-dialog modal-lg">
      <form action="{!! route('crm.deals.notes.store',$deal->dealID) !!}" method="post">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> New Note</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Subject', 'Subject', array('class'=>'control-label')) !!}
                        {!! Form::text('subject', null, array('class' => 'form-control', 'required' => '','placeholder' => 'Enter call subject')) !!}
                        <input type="hidden" name="dealID" value="{!! $deal->dealID !!}" required>
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
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add note</button>
               <img src="{!! asset('/assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
            </div>
         </div>
      </form>
   </div>
</div>