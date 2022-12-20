<div class="col-md-12">
   <div class="row mt-3 mb-2">
      <div class="col-md-12">
         <a href="#" class="btn btn-success" data-toggle="modal" data-target="#add-note"> Add Note</a>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         @foreach ($notes as $note)
            <div class="panel">
               <div class="panel-heading">{!! $note->subject !!}</div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-1">
                        @if(Hr::employee(User::info($note->created_by)->employeeID)->image != "")
                           <img src="{!! url('/') !!}/storage/files/business/{!! Wingu::business(Auth::user()->businessID)->primary_email !!}/hr/employee/images/{!!
                              Hr::employee(User::info($note->created_by)->employeeID)->image !!}" alt="" class="media-object rounded-corner">
                        @else
                           <img src="https://ui-avatars.com/api/?name={!! Hr::employee(User::info($note->created_by)->employeeID)->names !!}&rounded=true&size=50" alt="{!! Hr::employee(User::info($note->created_by)->employeeID)->names !!}">
                        @endif
                     </div>
                     <div class="col-md-11">
                        {!! $note->note !!} 
                     </div>
                  </div>
               </div>
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-md-8">
                        @if($note->created_by != "")<b>Added by</b> <a href="#">{!! Hr::employee(User::info($note->created_by)->employeeID)->names !!}</a>@endif • <b>at</b> <a href="#">{!! date('F d, Y', strtotime($note->created_at)) !!} @ {!! date('g:i a', strtotime($note->created_at)) !!}</a>     
                     </div>
                     <div class="col-md-4">
                        <a href="{!! route('tenants.notes.delete', $note->id) !!}" class="btn btn-sm btn-danger float-right delete"><i class="fas fa-trash"></i> Delete</a>
                        <a href="#" data-toggle="modal" data-target="#edit-note-{!! $note->id !!}" class="btn btn-sm float-right mr-2 btn-primary"><i class="fas fa-edit"></i> Edit</i></a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal fade" id="edit-note-{!! $note->id !!}">
               <div class="modal-dialog modal-lg">
                  {!! Form::model($note, ['route' => ['tenants.notes.update',$note->id], 'method'=>'post']) !!}
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
                                    <input type="hidden" name="tenantID" value="{!! $tenantID !!}" required>
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
                              <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update note </button>
                              <img src="{!! url('/') !!}/public/app/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
                           </center>
                        </div>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         @endforeach
      </div>
   </div>
   <div class="row mt-2">
      <div class="col-md-12">
         @if($notes->lastPage() > 1)
            <nav aria-label="...">
               <ul class="pagination">
                  <li class="page-item">
                     <a class="page-link" href="{{ $notes->url(1) }}">Previous</a>
                  </li>
                  @for ($i = 1; $i <= $notes->lastPage(); $i++)
                     <li class="page-item {{ ($notes->currentPage() == $i) ? 'active' : '' }}">
                        <a class="page-link" href="{{ $notes->url($i) }}">
                           {{ $i }}
                           <span class="sr-only">(current)</span>
                        </a>
                     </li>
                  @endfor
                  <li class="page-item">
                     <a class="page-link" href="{{ $notes->url($notes->currentPage()+1) }}">Next</a>
                  </li>
               </ul>
            </nav>
         @endif
      </div>
   </div>
</div>
{{-- normal note --}}
<div class="modal fade" id="add-note">
  <div class="modal-dialog modal-lg">
     <form action="{!! route('tenants.notes.store') !!}" method="post">
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
                       {!! Form::text('subject', null, array('class' => 'form-control text-danger', 'placeholder' => 'Enter subject', 'required' => '')) !!}
                       <input type="hidden" name="tenantID" value="{!! $tenantID !!}" required>
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
                 <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Submit</button>
                 <img src="{!! url('/') !!}/public/app/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
              </center>
           </div>
        </div>
     </form>
  </div>
</div>