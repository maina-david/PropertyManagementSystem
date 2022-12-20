<?php $__env->startSection('title','Run payroll'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Human resource</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.dashboard'); ?>">Payroll</a></li>
         <li class="breadcrumb-item active">Run payroll</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> Run payroll</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-8">
                  <div class="card">
                     <div class="card-header">
                        Run payroll for
                     </div>
                     <div class="card-body">
                        <form action="<?php echo route('hrm.payroll.process.post'); ?>" method="post" autocomplete="off">
                           <?php echo csrf_field(); ?>
                           <div class="form-group form-group-default required">
                              <label for="" class="text-danger">Branch</label>
                              <select name="branch" class="form-control multiselect" required>
                                 <option name="" id="">Choose</option>
                                 <option name="All" id="">All</option>
                                 <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo $branch->id; ?>"><?php echo $branch->branch_name; ?></option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                           </div>
                           
                           <div class="form-group form-group-default required">
                              <label class="text-danger">Payroll type</label>
                              <?php echo Form::select('payroll_type',['' => 'Choose basis','Monthly' => 'Monthly','Bi-weekly' => 'Bi-weekly','Daily' => 'Daily'], null, array('class' => 'form-control multiselect','required' =>'')); ?>

                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Payroll For</label>
                                    <input type="date" class="form-control" name="payroll_date" required>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group mt-2">
                              <center>
                                 <button class="btn btn-pink submit" type="submit"><i class="fas fa-sync-alt"></i> Run payroll</button>
                                 <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                              </center>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3"></div>
      </div>
      <!-- end panel -->
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/payroll/payroll/create.blade.php ENDPATH**/ ?>