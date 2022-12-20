<div class="row mt-3">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            Send statement
         </div>
         <div class="card-body">
            <form  method="POST" action="{!! route('crm.customers.statement.send',$customerID) !!}" enctype="multipart/form-data">
               @csrf
               <div class="form-group">
                  <label for="">Subject</label>
                  {!! Form::text('subject',null,['class'=>'form-control','placeholder'=>'Enter subject','required'=>'']) !!}
                  <input type="hidden" name="customerID"value="{!! $customerID  !!}" required>
               </div>
               <div class="form-group">
                  <label for="">Email
                     <span class="pull-right" data-toggle="tooltip" data-placement="top" title="If you need to change the Email you can change it on the customer edit section.">
                        <i class="fas fa-info-circle"></i>
                     </span>
                  </label>
                  <input type="email" name="send_to" class="form-control" value="{!! $client->email !!}" required readonly>
               </div>
               <div class="form-group">
                  <label for="">CC</label>
                  {!! Form::select('email_cc[]',[],null,['class'=>'form-control multiselect']) !!}
               </div>
               <div class="form-group">
                  <label for="">Message</label>
                  <textarea name="message" id="" cols="30" rows="10" class="ckeditor">
                     <p>Dear {!! $client->customer_name !!},&nbsp;<br />
                        <br/>
                        Its been a great experience working with you.<br />
                        Attached with this email is a list of all transactions for the year <strong>@php echo date('Y') @endphp</strong>.<br />
                        If you have any questions, just drop us an email or call us and we will get back to you.<br />
                        <br />
                        Regards,<br />
                        {!! Wingu::business()->name !!}
                     </p>                        
                  </textarea>
               </div>
               <div class="form-group">
                  <p>
                     view attachment <br>
                     <a href="{!! url('/') !!}/storage/files/business/{!! $client->primary_email !!}/finance/statement/{!! $client->reference_number !!}-@php echo date('Y') @endphp.pdf" target="_blank" id="preview"> Preview current Attached Statement</a>
                  </p>
               </div>
               <div class="form-group mb-5">
                  <button type="submit" class="pull-right btn btn-pink submit"><i class="fal fa-paper-plane"></i> Send email</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </div>
            </form>
         </div>
      </div>
   </div>
</div>