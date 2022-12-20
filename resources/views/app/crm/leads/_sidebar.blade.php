<div class="col-md-3">
   <div class="card">
      <div class="card-body text-center">
         @if($lead->image == "")
            <img alt="{!! $lead->names !!}" src="{!! "https://www.gravatar.com/avatar/". md5(strtolower(trim($lead->email))) . "?s=200&d=wavatar" !!}" class="img-circle" width="80" height="80">
         @else
            <img width="150" height="150" alt="" class="img-circle" src="{!! url('/') !!}/storage/files/business/{!! $lead->primary_email !!}/clients/{!! $lead->customer_code !!}/images/{!! $lead->image !!}">
         @endif
         <h4 class="mb-1 mt-2">{!! $lead->customer_name !!}</h4>
         <p class="text-muted">
            <i class="fas fa-at"></i> {!! $lead->email !!}<br>
            <i class="fas fa-phone"></i>
            {!! $lead->phone_number !!}

         </p>
         <a href="{!! route('crm.customers.edit',$leadID) !!}" class="btn btn-success btn-xs waves-effect mb-2 waves-light"><i class="fas fa-user-edit"></i> Edit</a>
         <a href="{!! route('crm.leads.mail',$lead->id) !!}" class="btn btn-pink btn-xs waves-effect mb-2 waves-light"><i class="fas fa-paper-plane"></i> Send Mail</a>
      </div>
   </div>
   <div class="panel panel-default" data-sortable-id="ui-widget-1">
      <div class="panel-heading ui-sortable-handle">
         <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
         </div>
         <h4 class="panel-title"><i class="fas fa-info-circle"></i> Lead Information </h4>
      </div>
      <div class="panel-body">
         <p>
            @if($lead->company_name != "")
               <b>Full Names :</b> {!! $lead->salutation !!} {!! $lead->lead_name !!} <br>
            @endif
            @if($lead->email != "")
               <b>Contact email :</b> {!! $lead->email !!} <br>
            @endif
            @if($lead->position != "")
               <b>Position :</b> {!! $lead->position !!} <br>
            @endif
            @if($lead->phone_number != "")
               <b>Phone number :</b>
               @if ($lead->phone_code != "")
                  +{!! Wingu::country($lead->phone_code)->phonecode !!}
               @endif
               {!! $lead->phone_number !!}<br>
            @endif
         <p>
      </div>
   </div>
   <div class="panel panel-default" data-sortable-id="ui-widget-1">
      <div class="panel-heading ui-sortable-handle">
         <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
         </div>
         <h4 class="panel-title"><i class="fas fa-building"></i> Business Information </h4>
      </div>
      <div class="panel-body">
         <p>
            @if($lead->company_name != "")
               <b>Company :</b> {!! $lead->company_name !!} <br>
            @endif
            @if($lead->company_name != "")
               <b>Industry :</b> {!! $lead->company_name !!} <br>
            @endif
            @if($lead->website != "")
               <b>Website :</b> {!! $lead->website !!} <br>
            @endif
            @if($lead->country != "")
               <b>Country :</b> {!! Wingu::country($lead->country)->name !!} <br>
            @endif
            @if($lead->city != "")
               <b>Town/City :</b> {!! $lead->city !!} <br>
            @endif
            @if($lead->state != "")
               <b>State :</b> {!! $lead->state !!} <br>
            @endif
            @if($lead->location != "")
               <b>Location :</b> {!! $lead->location !!} <br>
            @endif
            @if($lead->postal_address != "")
               <b>Postal address :</b> {!! $lead->postal_address !!}-{!! $lead->zip_code !!} <br>
            @endif
         <p>
      </div>
   </div>
</div>
