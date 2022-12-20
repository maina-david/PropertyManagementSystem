<?php echo Form::model($settings, ['route' => ['hrm.payroll.settings.payday.update'], 'method'=>'post','enctype'=>'multipart/form-data']); ?>

   <div class="row">
      <div class="col-md-6">
         <div class="form-group form-group-default required">
            <?php echo Form::label('names', 'Pay period', array('class'=>'control-label')); ?>

            <?php echo Form::text('pay_period', 'Monthly', array('class' => 'form-control', 'value' => 'Monthly', 'required' => '','disabled' => '')); ?>

         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group form-group-default required">
            <?php echo Form::label('names', 'Monthly payday', array('class'=>'control-label')); ?>

            <select name="monthly_payday" class="form-control multiselect" required>
               <?php if($settings->monthly_payday != ""): ?>
                  <option value="<?php echo $settings->monthly_payday; ?>"><?php echo $settings->monthly_payday; ?></option>
               <?php endif; ?>
               <option value="">Select your monthly payday</option>
               <option value="1">1st</option>
               <option value="2">2nd</option>
               <option value="3">3rd</option>
               <option value="4">4th</option>
               <option value="5">5th</option>
               <option value="6">6th</option>
               <option value="7">7th</option>
               <option value="8">8th</option>
               <option value="9">9th</option>
               <option value="10">10th</option>
               <option value="11">11th</option>
               <option value="12">12th</option>
               <option value="13">13th</option>
               <option value="14">14th</option>
               <option value="15">15th</option>
               <option value="16">16th</option>
               <option value="17">17th</option>
               <option value="18">18th</option>
               <option value="19">19th</option>
               <option value="20">20th</option>
               <option value="21">21st</option>
               <option value="22">22nd</option>
               <option value="23">23rd</option>
               <option value="24">24th</option>
               <option value="25">25th</option>
               <option value="26">26th</option>
               <option value="27">27th</option>
               <option value="28">28th</option>
               <option value="29">29th</option>
               <option value="30">30th</option>
               <option value="31">31st</option>
            </select>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group form-group-default">
            <?php echo Form::label('Enable mid-month pay', 'Enable mid-month pay', array('class'=>'control-label')); ?>

            <?php echo Form::select('enable_mid_month_pay', ['' => 'Choose','Yes' => 'Yes', 'No' => 'No'],null, array('class' => 'form-control multiselect', 'id'=> 'mid-month-pay')); ?>

         </div>
      </div>
   </div>
   <?php if($settings->enable_mid_month_pay == 'Yes'): ?>
      <div class="row">
         <div class="col-md-12 mb-3">
            <hr>
            <h5>Mid month details</h5>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <div class="form-group form-group-default required">
               <?php echo Form::label('names', 'Mid-month payday', array('class'=>'control-label')); ?>

               <select name="mid_month_payday" class="form-control multiselect">
                  <?php if($settings->mid_month_payday != ""): ?>
                     <option value="<?php echo $settings->mid_month_payday; ?>"><?php echo $settings->mid_month_payday; ?></option>
                  <?php else: ?> 
                     <option value="">Select your monthly payday</option>
                  <?php endif; ?>
                  <option value="1">1st</option>
                  <option value="2">2nd</option>
                  <option value="3">3rd</option>
                  <option value="4">4th</option>
                  <option value="5">5th</option>
                  <option value="6">6th</option>
                  <option value="7">7th</option>
                  <option value="8">8th</option>
                  <option value="9">9th</option>
                  <option value="10">10th</option>
                  <option value="11">11th</option>
                  <option value="12">12th</option>
                  <option value="13">13th</option>
                  <option value="14">14th</option>
                  <option value="15">15th</option>
                  <option value="16">16th</option>
                  <option value="17">17th</option>
                  <option value="18">18th</option>
                  <option value="19">19th</option>
                  <option value="20">20th</option>
                  <option value="21">21st</option>
                  <option value="22">22nd</option>
                  <option value="23">23rd</option>
                  <option value="24">24th</option>
                  <option value="25">25th</option>
                  <option value="26">26th</option>
                  <option value="27">27th</option>
                  <option value="28">28th</option>
                  <option value="29">29th</option>
                  <option value="30">30th</option>
                  <option value="31">31st</option>
               </select>
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default required">
               <?php echo Form::label('names', 'Mid-month rate type', array('class'=>'control-label')); ?>

               <?php echo Form::select('mid_month_rate_type',['' => 'Select mid month rate type', 'percentage' => 'percentage','amount' => 'amount'], null, ['class' => 'form-control multiselect', 'id' => 'month-rate']); ?>

            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default required">
               <?php echo Form::label('names', 'Mid-month rate', array('class'=>'control-label')); ?>

               <div id="percentage">
                  <input type="text" name="mid_month_rate_percentage" value="<?php echo $settings->mid_month_rate; ?>" class="form-control" placeholder="Enter percentage value">
               </div>
               <div id="amount" style="display: none" id="amount">
                  <input type="text" name="mid_month_rate_amount" value="<?php echo $settings->mid_month_rate; ?>" class="form-control" placeholder="Enter amount value">
               </div>
            </div> 
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default required">
               <?php echo Form::label('Compute statutory', 'Compute statutory', array('class'=>'control-label')); ?>

               <?php echo Form::select('compute_statutory', ['' => 'Choose','Yes' => 'Yes', 'No' => 'No'],null, array('class' => 'form-control multiselect')); ?>

            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default required">
               <?php echo Form::label('Assignee', 'Assignee', array('class'=>'control-label')); ?>

               <?php echo Form::select('assignee', ['' => 'Choose','All employees' => 'All', 'Specified' => 'Specified'],null, array('class' => 'form-control multiselect')); ?>

            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group form-group-default required">
               <?php echo Form::label('Choose Employee', 'Choose Employee', array('class'=>'control-label')); ?>

               <?php echo Form::select('employee[]', $joinemployee, null, array('class' => 'form-control multiple-select2', 'multiple' => 'multiple')); ?>

            </div>
         </div>
      </div>
   <?php endif; ?>
   <div class="row mt-3">
      <div class="col-md-12">
         <center>
            <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update details</button>
            <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
         </center>
      </div>
   </div>
<?php echo Form::close(); ?>

<?php $__env->startSection('scripts'); ?>
   <script>
      $(document).ready(function() {
         $('#month-rate').on('change', function() {
            if (this.value == 'amount') {
               $('#amount').show();
               $('#percentage').hide();
            } 
         });
      });

      $(".multiple-select2").select2();
		$(".multiple-select2").select2().val(<?php echo json_encode($jointAssigned); ?>).trigger('change');
   </script>
<?php $__env->stopSection(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/settings/payday.blade.php ENDPATH**/ ?>