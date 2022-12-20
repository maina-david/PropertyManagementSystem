<div class="row mt-3">
   <div class="card">
      <div class="card-body">
         <ul class="mail_list list-group list-unstyled">
            @foreach ($mails as $mail)
               <li class="list-group-item">
                  <div class="media">
                     <div class="pull-left"> 
                        <div class="thumb"> 
                           @if($client->image != "")
                              <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$client->customer_code.'/images/'.$client->image) !!}" alt="" style="width:50px;height:50px" class="rounded-circle">
                           @else
                              <img src="https://ui-avatars.com/api/?name={!! $client->customer_name !!}&rounded=true&size=50 alt="">
                           @endif
                        </div>
                     </div>
                     <div class="media-body">
                        <div class="media-heading">
                           <a href="{!! route('crm.customer.details',[$mail->id,$customerID]) !!}" class="m-r-10">{!! $mail->names !!}</a>
                           @if($mail->status == "Sent")
                              <span class="badge bg-green">Sent</span>
                           @else 
                           <span class="badge bg-orange">Draft</span>
                           @endif
                           <small class="float-right text-muted">
                              <time class="hidden-sm-down" datetime="2020">{!! date('F d, Y @ h:i:s A', strtotime($mail->created_at)) !!}</time>
                              <i class="fal fa-paperclip"></i>
                           </small>
                        </div>
                        <p class="msg">{!! $mail->subject !!}<br><span class="text-pink">View Date : {!! date('F jS, Y',strtotime($mail->date_view)) !!}</span> | <span class="text-info">View Count : {!! $mail->view_count !!}</span></p>
                     </div>
                  </div>
               </li>
            @endforeach                        
        </ul>
      </div>
   </div>
</div>
<div class="row mt-2">
   <div class="col-md-12">
      @if($mails->lastPage() > 1)
         <nav aria-label="...">
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="{{ $mails->url(1) }}">Previous</a>
               </li>
               @for ($i = 1; $i <= $mails->lastPage(); $i++)
                  <li class="page-item {{ ($mails->currentPage() == $i) ? 'active' : '' }}">
                     <a class="page-link" href="{{ $mails->url($i) }}">
                           {{ $i }}
                        <span class="sr-only">(current)</span>
                     </a>
                  </li>
               @endfor
               <li class="page-item">
                  <a class="page-link" href="{{ $mails->url($mails->currentPage()+1) }}">Next</a>
               </li>
            </ul>
         </nav>
      @endif
   </div>
</div>