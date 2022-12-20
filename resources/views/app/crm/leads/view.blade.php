<div class="card mt-3">
   <div class="card-header">Lead Information</div>
   <div class="card-body">
      <div class="row">
         <div class="col-md-3">
            @if($lead->image != "")
               <img class="rounded-circle" alt="" class="{!! $lead->names !!}" src="{!! asset('businesses/'.$lead->businessID.'/clients/'.$lead->customer_code.'/images/'.$lead->image) !!}" style="width:178px;height:178px">
            @else
               <img src="https://ui-avatars.com/api/?name={!! $lead->customer_name !!}&rounded=false&size=178" alt="">
            @endif
         </div>
         <div class="col-md-5">
            <table>
               <tr class="mb-3">
                  <td align="right"><b>Lead Owner :</b></td>
                  <td>
                     @if($lead->assignedID != "")
                        @if(Wingu::check_user($lead->assignedID) == 1)
                           <span class="text-pink"> {!! Wingu::user($lead->assignedID)->name !!}</span>
                        @endif
                     @endif
                  </td>                  
               </tr>
               <tr class="mb-2">
                  <td width="40%" align="right"><b>Title :</b></td>
                  <td><span class="text-pink"> {!! $lead->title !!}</span></td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Phone :</b></td>
                  <td><span class="text-pink"> {!! $lead->primary_phone_number !!}</span></td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Lead Source :</b></td>
                  <td>
                     @if(Hr::check_source($lead->sourceID) == 1)
                        <span class="text-pink"> {!! Hr::source($lead->sourceID)->name !!}</span>
                     @endif
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Industry :</b></td>
                  <td>
                     @if($lead->industryID != "")
                        <span class="text-pink"> {!! Wingu::industry($lead->industryID)->name !!}</span>
                     @endif
                  </td>
               </tr> 
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Created By :</b></td>
                  <td>
                     @if(Wingu::check_user($lead->created_by) == 1)
                        <span class="text-pink"> {!! Wingu::user($lead->created_by)->name !!}</span> @ {!! date('Y-m-d h:i:sa', strtotime($lead->created_at)) !!}
                     @endif
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="40%"  align="right"><b>Updated By :</b></td>
                  <td>
                     @if(Wingu::check_user($lead->updated_by) == 1)
                        <span class="text-pink"> {!! Wingu::user($lead->updated_by)->name !!}</span> @ {!! date('Y-m-d h:i:sa', strtotime($lead->updated_at)) !!}
                     @endif
                  </td>
               </tr>
            </table>
         </div>
         <div class="col-md-4">
            <table>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>Email :</b></td>
                  <td>
                     <span class="text-pink"> {!! $lead->emails !!}</span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>Postal address :</b></td>
                  <td>
                     <span class="text-pink"> {!! $lead->bill_postal_address !!}</span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>zip code :</b></td>
                  <td>
                     <span class="text-pink"> {!! $address->bill_zip_code !!}</span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>Country :</b></td>
                  <td>
                     @if($address->bill_country != "")
                        <span class="text-pink"> {!! Wingu::country($address->bill_country)->name !!}</span>
                     @endif
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>City :</b></td>
                  <td>
                     <span class="text-pink"> {!! $address->bill_city !!}</span>
                  </td>
               </tr>
               <tr class="mb-2">
                  <td width="45%"  align="right"><b>State :</b></td>
                  <td>
                     <span class="text-pink"> {!! $address->bill_state !!}</span>
                  </td>
               </tr>
            </table>
         </div>
      </div>   
   </div>
</div>
<div class="card mt-3">
   <div class="card-header">Lead Description</div>
   <div class="card-body">
      {!! $lead->remarks  !!}
   </div>
</div>
<div class="card mt-3">
   <div class="card-header"> Contact persons </div>
   <div class="card-body">
      <table class="table table-bordered">
         <tr>
            <th width="1%">#</th>
            <th>Names</th>
            <th>Email Address</th>
            <th>Phone number</th>
            <th>Designation</th>
         </tr>
         @foreach($persons as $cp)
            <tr>
               <td>{!! $count++ !!}</td>
               <td>
                  {!! $cp->salutation !!} {!! $cp->names !!}
               </td>
               <td>{!! $cp->contact_email !!}</td>
               <td>{!! $cp->phone_number !!}</td>
               <td>{!! $cp->designation !!}</td>
            </tr>
         @endforeach
      </table>
   </div>
</div>
