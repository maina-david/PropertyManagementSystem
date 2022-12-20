<div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div class="panel">
            <div class="panel-heading">Mpesa API</div>
            <div class="panel-body">
               <?php echo Form::model($mpesaApi, ['route' => ['property.mpesaapi.integration.update',[$property->id,$mpesaApi->integrationID]], 'method'=>'post','autocomplete' => 'off']); ?>

                  <?php echo csrf_field(); ?>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Business Name</label>
                           <?php echo Form::text('business_name',null,['class' => 'form-control','placeholder' => 'Enter Business Name','required' => '']); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Consumer key</label>
                           <?php echo Form::text('customer_key',null,['class' => 'form-control','placeholder' => 'Enter customer key','required' => '']); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Customer secret</label>
                           <?php echo Form::text('customer_secret',null,['class' => 'form-control','required' => '','placeholder' => 'Enter customer secret']); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Iframelink</label>
                           <?php echo Form::text('iframelink',null,['class' => 'form-control','required' => '', 'placeholder' => 'Enter customer iframelink']); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="name" class="text-danger">Callback url</label>
                           <?php echo Form::textarea('callback_url',null,['class' => 'form-control','required' => '', 'size' => '5x5', 'placeholder' => 'Enter customer callback url']); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="">Choose status</label>
                           <?php echo Form::select('status',['15' => 'Active', '23' => 'Closed'], null,['class' => 'form-control'] ); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Mpesa API</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                        </div>
                     </div>
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>      
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/integration/payments/mpesaapi.blade.php ENDPATH**/ ?>