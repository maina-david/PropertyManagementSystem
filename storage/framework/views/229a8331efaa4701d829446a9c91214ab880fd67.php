<div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div class="panel">
            <div class="panel-heading">Bank 1 information</div>
            <div class="panel-body">
               <?php echo Form::model($bank, ['route' => ['property.bank1.integration.update',[$property->id,$bank->integrationID]], 'method'=>'post']); ?>

                  <?php echo csrf_field(); ?>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <?php echo Form::label('name', 'Bank Name', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('bank_name', null, array('class' => 'form-control', 'placeholder' => 'Enter bank name', 'required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           <?php echo Form::label('branch', 'Branch', array('class'=>'control-label')); ?>

                           <?php echo Form::text('bank_branch', null, array('class' => 'form-control', 'placeholder' => 'Enter branch')); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required ">
                           <?php echo Form::label('Account', 'Account Name', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('bank_account_name', null, array('class' => 'form-control', 'placeholder' => 'Enter account name', 'required' => '')); ?>

                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required ">
                           <?php echo Form::label('account number', 'Account Number', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('bank_account_number', null, array('class' => 'form-control', 'placeholder' => 'Enter account number', 'required' => '')); ?>

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
                           <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Bank Details</button>
                           <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                        </div>
                     </div>
                  </div>
               <?php echo Form::close(); ?>

            </div>
         </div>
      </div>      
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/integration/payments/bank1.blade.php ENDPATH**/ ?>