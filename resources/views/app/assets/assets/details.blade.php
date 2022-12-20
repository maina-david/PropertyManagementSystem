<div class="row">
   <div class="col-md-4">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr><td>Manufacture</td><td><b>{!! $details->manufacture !!}</b></td></tr>
            <tr><td>Model</td><td><b>{!! $details->asset_model !!}</b></td></tr>
            <tr><td>Order Number</td><td><b>{!! $details->order_number !!}</b></td></tr>
            <tr>
               <td>Supplier</td>
               <td>
                  @if($details->supplier != "")
                     @if(Finance::check_supplier($details->supplier) == 1)
                        <b>{!! Finance::supplier($details->supplier)->supplierName !!}</b>
                     @endif
                  @endif
               </td>
            </tr>
            @if($details->has_inurance_cover == 'Yes')
               <tr>
                  <td>Insurance expiry date</td>
                  <td><b>@if($details->insurance_expiry_date != ""){!! date('M jS, Y', strtotime($details->insurance_expiry_date)) !!}@endif</b></td>
               </tr>
            @endif
            
            <tr><td>Warranty</td><td><b>{!! $details->warranty !!} Month(s)</b></td></tr>   
            <tr><td>Warranty expiration</td><td><b>@if($details->end_of_life != ""){!! date('M jS, Y', strtotime($details->warranty_expiration)) !!}@endif</b></td></tr>   
            
         </tbody>
     </table>
   </div>
   <div class="col-md-4">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr><td>Last audit</td><td><b>@if($details->last_audit != ""){!! date('M jS, Y', strtotime($details->last_audit)) !!} @ {!! date('h:i:s A', strtotime($details->last_audit)) !!} @endif</b></td></tr>   
            <tr><td>End of life</td><td><b>@if($details->end_of_life != ""){!! date('M jS, Y', strtotime($details->end_of_life)) !!}@endif</b></td></tr>                  
            <tr><td>Asset condition</td><td><b>{!! $details->asset_condition !!}</b></td></tr>   
            <tr><td>Is asset maintainable </td><td><b>{!! $details->maintained !!}</b></td></tr>   
            <tr><td>Accessories linked to asset</td><td><b>{!! $details->accessories !!}</b></td></tr>   
            <tr><td>Is asset depreciable</td><td><b>{!! $details->depreciable_assets !!}</b></td></tr>   
         </tbody>
     </table>
   </div>
   <div class="col-md-4">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr><td>Asset color</td><td><b>{!! $details->asset_color !!}</b></td></tr>   
            <tr><td>Is asset requestable</td><td><b>{!! $details->requestable !!}</b></td></tr>   
            <tr>
               <td>Created by</td>
               <td>
                  @if(Wingu::check_user($details->created_by) == 1)
                     <b>{!! Wingu::user($details->created_by)->name !!}</b>
                  @endif
               </td>
            </tr>   
            <tr>
               <td>Created at</td>
               <td>
                  <b>@if($details->created_at != ""){!! date('M jS, Y', strtotime($details->created_at)) !!} @ {!! date('h:i:s A', strtotime($details->created_at)) !!}</b>@endif
               </td>
            </tr>   
         </tbody>
      </table>
   </div>
</div>