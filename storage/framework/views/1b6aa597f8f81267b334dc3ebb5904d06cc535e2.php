<div class="row">
   <div class="col-md-4">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr><td>Manufacture</td><td><b><?php echo $details->manufacture; ?></b></td></tr>
            <tr><td>Model</td><td><b><?php echo $details->asset_model; ?></b></td></tr>
            <tr><td>Order Number</td><td><b><?php echo $details->order_number; ?></b></td></tr>
            <tr>
               <td>Supplier</td>
               <td>
                  <?php if($details->supplier != ""): ?>
                     <?php if(Finance::check_supplier($details->supplier) == 1): ?>
                        <b><?php echo Finance::supplier($details->supplier)->supplierName; ?></b>
                     <?php endif; ?>
                  <?php endif; ?>
               </td>
            </tr>
            <?php if($details->has_inurance_cover == 'Yes'): ?>
               <tr>
                  <td>Insurance expiry date</td>
                  <td><b><?php if($details->insurance_expiry_date != ""): ?><?php echo date('M jS, Y', strtotime($details->insurance_expiry_date)); ?><?php endif; ?></b></td>
               </tr>
            <?php endif; ?>
            
            <tr><td>Warranty</td><td><b><?php echo $details->warranty; ?> Month(s)</b></td></tr>   
            <tr><td>Warranty expiration</td><td><b><?php if($details->end_of_life != ""): ?><?php echo date('M jS, Y', strtotime($details->warranty_expiration)); ?><?php endif; ?></b></td></tr>   
            
         </tbody>
     </table>
   </div>
   <div class="col-md-4">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr><td>Last audit</td><td><b><?php if($details->last_audit != ""): ?><?php echo date('M jS, Y', strtotime($details->last_audit)); ?> @ <?php echo date('h:i:s A', strtotime($details->last_audit)); ?> <?php endif; ?></b></td></tr>   
            <tr><td>End of life</td><td><b><?php if($details->end_of_life != ""): ?><?php echo date('M jS, Y', strtotime($details->end_of_life)); ?><?php endif; ?></b></td></tr>                  
            <tr><td>Asset condition</td><td><b><?php echo $details->asset_condition; ?></b></td></tr>   
            <tr><td>Is asset maintainable </td><td><b><?php echo $details->maintained; ?></b></td></tr>   
            <tr><td>Accessories linked to asset</td><td><b><?php echo $details->accessories; ?></b></td></tr>   
            <tr><td>Is asset depreciable</td><td><b><?php echo $details->depreciable_assets; ?></b></td></tr>   
         </tbody>
     </table>
   </div>
   <div class="col-md-4">
      <table class="table table-bordered table-asset" style="margin-bottom:0 !important;">
         <tbody>
            <tr><td>Asset color</td><td><b><?php echo $details->asset_color; ?></b></td></tr>   
            <tr><td>Is asset requestable</td><td><b><?php echo $details->requestable; ?></b></td></tr>   
            <tr>
               <td>Created by</td>
               <td>
                  <?php if(Wingu::check_user($details->created_by) == 1): ?>
                     <b><?php echo Wingu::user($details->created_by)->name; ?></b>
                  <?php endif; ?>
               </td>
            </tr>   
            <tr>
               <td>Created at</td>
               <td>
                  <b><?php if($details->created_at != ""): ?><?php echo date('M jS, Y', strtotime($details->created_at)); ?> @ <?php echo date('h:i:s A', strtotime($details->created_at)); ?></b><?php endif; ?>
               </td>
            </tr>   
         </tbody>
      </table>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/assets/details.blade.php ENDPATH**/ ?>