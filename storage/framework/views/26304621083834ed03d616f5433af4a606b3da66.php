<div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div class="panel">
            <div class="panel-heading">Mpesa Paybill</div>
            <div class="panel-body">
               <?php echo Form::model($mpesaPaybill, ['route' => ['property.mpesapaybill.integration.update',[$property->id,$mpesaPaybill->integrationID]], 'method'=>'post']); ?>

                  <?php echo csrf_field(); ?>
                  <div class="form-group form-group-default">
                     <label for="name" class="text-danger">Business Name</label>
                     <?php echo Form::text('business_name',null,['class' => 'form-control','placeholder' => 'Enter business name','required' => '']); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="name" class="text-danger">Paybill Number</label>
                     <?php echo Form::text('paybill_number',null,['class' => 'form-control','placeholder' => 'Enter paybill number','required' => '']); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="name" class="text-danger">Account Number</label>
                     <?php echo Form::text('paybill_account',null,['class' => 'form-control','required' => '','placeholder' => 'Account defination']); ?>

                  </div>
                  <div class="form-group required required">
                     <label for="">Choose status</label>
                     <?php echo Form::select('status',['15' => 'Active', '23' => 'Closed'], null,['class' => 'form-control'] ); ?>

                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Paybill</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>      
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/integration/payments/paybill.blade.php ENDPATH**/ ?>