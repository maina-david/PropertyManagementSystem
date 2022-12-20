<div class="row mt-2 mb-2">
   <div class="col-md-12">
      <a href="#" class="btn btn-pink" data-toggle="modal" data-target="#add-note"> Add Note</a>
   </div>
</div>
@foreach ($notes as $note)
   <div class="card">
      <div class="card-header">{!! $note->subject !!}</div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-1">
               @if(Wingu::check_user($note->created_by) == 1)
                  <img src="https://ui-avatars.com/api/?name={!! Wingu::user($note->created_by)->name  !!}&rounded=true&size=32" alt="">
               @else 
                  <img src="https://ui-avatars.com/api/?name=No User&rounded=true&size=32" alt="">
               @endif
            </div>
            <div class="col-md-11">
               {!! $note->note !!}
            </div>
         </div>
      </div>
      <div class="card-footer text-muted">
         <div class="row">
            <div class="col-md-8">
               @if($note->created_by != "")<b>Added by</b> <a href="#">@if(Wingu::check_user($note->created_by) == 1){!! Wingu::user($note->created_by)->name  !!}@else Unknown User @endif</a>@endif • <b>at</b> <a href="#">{!! date('F d, Y', strtotime($note->created_at)) !!} @ {!! date('g:i a', strtotime($note->created_at)) !!}</a>     
            </div>
            <div class="col-md-4">
               <a href="{!! route('crm.leads.notes.delete', $note->id) !!}" class="btn btn-sm btn-danger float-right delete">Delete</a>
               <a href="#" data-toggle="modal" data-target="#edit-note-{!! $note->id !!}" class="btn btn-sm float-right mr-2 btn-primary">Edit</i></a>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="edit-note-{!! $note->id !!}">
      <div class="modal-dialog modal-lg">
         {!! Form::model($note, ['route' => ['crm.leads.notes.update', $note->id], 'method'=>'post']) !!}
            @csrf
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title"> Update Note</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="">Subject</label>
                           {!! Form::text('subject', null, array('class' => 'form-control text-danger', 'required' => '')) !!}
                           <input type="hidden" name="customerID" value="{!! $customerID !!}" required>
                        </div>                       
                        <div class="form-group required">
                          <label for="" class="text-danger">Note</label>
                          {!! Form::textarea('note', null, array('class' => 'form-control ckeditor', 'required' => '')) !!}
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update note </button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                  </center>
               </div>
            </div>
         {!! Form::close() !!}
      </div>
   </div>
@endforeach
{{-- normal note --}}
<div class="modal fade" id="add-note">
   <div class="modal-dialog modal-lg">
      <form action="{!! route('crm.leads.notes.store') !!}" method="post">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> New Note</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default">
                        <label for="">Subject</label>
                        {!! Form::text('subject', null, array('class' => 'form-control text-danger', 'required' => '')) !!}
                        <input type="hidden" name="customerID" value="{!! $customerID !!}" required>
                     </div>
                     <div class="form-group">
                     <label for="" class="text-danger">Note</label>
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