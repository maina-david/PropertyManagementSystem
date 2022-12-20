<div class="row">
   <div class="col-md-12">
      <table class="table table-bordered">
         @foreach ($events as $event)
            <tr>
               <td>
                  <small class="text-primary">{!! $event->name !!} Date</small>
                  <p><b>{!! date('M jS, Y', strtotime($event->action_date)) !!}</b></p>
               </td>
               <td>
                  <h3>{!! $event->name !!}</h3>
               </td>
               <td>
                  <small class="text-primary">Assigned to</small>
                  <p>
                     @if($event->allocated_to != "")
                        <b>{!! Hr::employee($event->allocated_to)->names !!}</b>
                     @endif
                  </p>
               </td>
               <td>
                  <small class="text-primary">Due date</small>
                  <p>
                     @if($event->due_action_date == "")
                        <b>No due date</b>
                     @else 
                        <b>{!! date('M jS, Y', strtotime($event->due_action_date)) !!}</b>
                     @endif
                  </p>
               </td>
               <td width="20%">
                  <small class="text-primary">Note</small>
                  {!! $event->note !!}
               </td>
               <td width="12%">
                  @if($event->status == 38)                  
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".checkout{!! $event->eventID !!}">Edit</a>
                  @endif
                  @if($event->status == 39)
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".lease{!! $event->eventID !!}">Edit</a>
                  @endif
                  @if($event->status == 43)
                     <a href="javascript;" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".checkin{!! $event->eventID !!}">Edit</a>
                  @endif
                  <a href="{!! route('assets.event.delete',$event->eventID) !!}" class="btn btn-sm btn-danger delete">Delete</a>
               </td>
            </tr>

            {{-- check out --}}
            <div class="modal fade checkout{!! $event->eventID !!}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     {!! Form::model($event, ['route' => ['assets.event.checkout.update',$event->eventID], 'method'=>'post','id'=>'checkoutForm', 'autocomplete' => 'off']) !!}
                        @csrf
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Update Check out</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Check-out Date</label>
                                    {!! Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']) !!}
                                    <input type="hidden" name="status" value="38">
                                    <input type="hidden" name="assetID" value="{!! $details->id !!}">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Due Date</label>
                                    {!! Form::text('due_action_date',null,['class' => 'form-control datepicker', 'placeholder' => 'choose date']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Check-out to</label>
                                    {!! Form::select('check_out_to',['' => 'Choose','Person' => 'Person','Branch' => 'Branch','Location' => 'Site / Location'],null,['class' => 'form-control', 'required' => '', 'id'=>'checkoutto']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Branch</label>
                                    {!! Form::select('branch',$branches,null,['class' => 'form-control']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Person</label>
                                    {!! Form::select('allocated_to',$employees,null,['class' => 'form-control']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Site / Location </label>
                                    {!! Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Department </label>
                                    {!! Form::select('department',$departments,null,['class' => 'form-control']) !!}
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                                 </div>
                              </div>
                           </div>       
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitCheckoutForm">Update information</button>
                              <img src="{!! asset('/assets/img/btn-loader.gif') !!}" class="checkout-load none" width="15%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>

            {{-- Lease --}}
            <div class="modal fade lease{!! $event->eventID !!}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     {!! Form::model($event, ['route' => ['assets.event.lease.update',$event->eventID], 'method'=>'post','id'=>'leaseForm', 'autocomplete' => 'off']) !!}
                        @csrf
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Lease</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Lease Begins</label>
                                    {!! Form::date('action_date',null,['class' => 'form-control', 'required' => '']) !!}
                                    <input type="hidden" name="status" value="39">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Lease Expires</label>
                                    {!! Form::date('due_action_date',null,['class' => 'form-control', 'required' => '']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Leasing Customer </label>
                                    {!! Form::select('allocated_to',$customers,null,['class' => 'form-control', 'required' => '']) !!}
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    <label for="">Send Email</label>
                                    {!! Form::select('send_email',['No' => 'No','Yes' => 'Yes'],null,['class' => 'form-control','id'=>'lease_email']) !!}
                                 </div>
                              </div>                  
                              <div class="col-md-6" id="leaseEmail" style="display: none">
                                 <div class="form-group form-group-default required">
                                    <label for="">Email</label>
                                    {!! Form::email('email',null,['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                                 </div>
                              </div>
                           </div>       
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitLeaseForm">Update Lease</button>
                              <img src="{!! url('/') !!}/public/backend/img/btn-loader.gif" class="lease-load none" width="15%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>

            {{-- checkin --}}
            <div class="modal fade checkin{!! $event->eventID !!}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     {!! Form::model($event, ['route' => ['assets.event.checkin.update',$event->eventID], 'method'=>'post','id'=>'leaseForm', 'autocomplete' => 'off']) !!}
                        @csrf
                        <div class="modal-header">
                           <h3 class="modal-title" id="exampleModalLabel">Check in</h3>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group form-group-default required">
                                    <label for="">Return Date </label>
                                    {!! Form::text('action_date',null,['class' => 'form-control datepicker', 'required' => '', 'placeholder' => 'choose date']) !!}
                                    <input type="hidden" name="status" value="43">
                                    <input type="hidden" name="assetID" value="{!! $details->id !!}">
                                 </div>
                              </div>                 
                              <div class="col-md-6" id="checkoutLocation">
                                 <div class="form-group form-group-default required">
                                    <label for="">Site / Location </label>
                                    {!! Form::text('site_location',null,['class' => 'form-control', 'placeholder' => 'Enter location']) !!}
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label for="">Note </label>
                                    {!! Form::textarea('note',null,['class' => 'form-control ckeditor']) !!}
                                 </div>
                              </div>
                           </div>       
                        </div>
                        <div class="modal-footer">
                           <center>
                              <button type="submit" class="btn btn-pink submitCheckinForm">update Information</button>
                              <img src="{!! url('/') !!}/public/backend/img/btn-loader.gif" class="checkin-load none" width="15%">
                           </center>
                        </div>
                     {!! Form::close() !!}
                  </div>
               </div>
            </div>
         @endforeach
      </table>
   </div>
</div>