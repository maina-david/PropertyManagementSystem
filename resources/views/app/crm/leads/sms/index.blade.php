<div class="row mt-3">
   <div class="col-md-8">
      <!-- begin widget-chat -->
      <div class="widget-chat widget-chat-rounded">
         <!-- begin widget-chat-header -->
         <div class="widget-chat-header">
            <div class="widget-chat-header-icon">
               @if($lead->image == "")
                  <img src="https://ui-avatars.com/api/?name={!!  $lead->customer_name !!}&rounded=true&size=32" alt="">
               @else
                  <img width="40" height="40" alt="" class="img-circle" src="{!! asset('businesses/'.$lead->primary_email.'/clients/'.$lead->customer_code.'/images/'.$lead->image) !!}">
               @endif
            </div>
            <div class="widget-chat-header-content">
               <h4 class="widget-chat-header-title">{!! $lead->customer_name !!}</h4>
               <p class="widget-chat-header-desc">{!! $lead->primary_phone_number !!}</p>
            </div>
         </div>
         <!-- end widget-chat-header -->
         
         <!-- begin widget-chat-body -->
         <div class="widget-chat-body" data-scrollbar="true" data-height="535px">
            {{-- <div class="text-center text-muted m-10 f-w-600">Today</div> --}}
            {{-- <div class="widget-chat-item with-media left">
               <div class="widget-chat-media">
                  <img alt="" src="../assets/img/user/user-1.jpg">
               </div>
               <div class="widget-chat-info">
                  <div class="widget-chat-info-container">
                     <div class="widget-chat-name text-indigo">Hudson Mendes</div>
                     <div class="widget-chat-message">Should we plan for a company trip this year?</div>
                     <div class="widget-chat-time">6:00PM</div>
                  </div>
               </div>
            </div> --}}
               
            @foreach ($smses as $sms)
               <div class="widget-chat-item right">
                  <div class="widget-chat-info">
                     <div class="widget-chat-info-container">
                        <div class="widget-chat-message">{!! $sms->message !!}</div><br>
                        <div class="widget-chat-time">{!! date("F jS, Y @ h:i:sa", strtotime($sms->created_at)) !!}</div>
                     </div>
                  </div>
               </div>
            @endforeach            
         </div>
         <!-- end widget-chat-body -->
         
         <!-- begin widget-input -->
         <div class="widget-input widget-input-rounded">
            <form action="{!! route('crm.leads.sms.send') !!}" method="POST" class="row">
               @csrf
               <div class="col-md-12">
                  <div class="form-group">
                     <textarea name="message" id="" cols="10" rows="5" class="form-control" placeholder="Type message.........." maxlength="255" required></textarea>                     
                  </div>
                  <div class="form-group">
                     <label for="">
                        Phone number 
                        <span data-toggle="tooltip" data-placement="top" title="If you need to change the phone number you can change it on the lead edit section. Make sure the number starts with the country code">
                           <i class="fas fa-info-circle"></i>
                        </span>
                     </label>
                     <input type="text" name="to" class="form-control" value="{!! $lead->primary_phone_number !!}" readonly>
                     <input type="hidden" name="customerID" value="{!! $customerID !!}" readonly>
                  </div>
                  <div class="form-group mb-3">
                     <button class="btn btn-primary pull-right"><i class="fal fa-paper-plane"></i> Send sms </button>
                  </div>
               </div>               
            </form>
         </div>
         <!-- end widget-input -->
      </div>
      <!-- end widget-chat -->
   </div>
</div>