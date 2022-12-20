<?php $__env->startSection('title'); ?> Expenses | Add | <?php echo $property->title; ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)">Expense</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Add Expense </h1>
   <div class="row">
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12 mt-3">   
         <form action="<?php echo route('property.expense.store',$property->id); ?>" enctype="multipart/form-data" method="POST" autocomplete="off">
            <?php echo csrf_field(); ?>
            <div class="row">
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Expenses Details</h4>
                     </div>
                     <div class="panel-body">
                        <div class="form-group form-group-default">
                           <label for="" class="text-danger">Category</label><a href="" class="float-right text-primary" data-toggle="modal" data-target="#expenceCategory">Add category</a>
                           <select name="expense_category" id="selectCategory" class="form-control select2" required></select>
                        </div>
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Date', 'Date', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::date('date', null, array('class' => 'form-control','required' =>'')); ?>

                        </div>
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Title', 'Title', array('class'=>'control-label text-danger')); ?>

                           <?php echo Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'')); ?>

                        </div>
                        <div class="row">
                           <div class="col-sm-6">
                              <div class="form-group form-group-default" aria-required="true">
                                 <?php echo Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')); ?>

                                 <?php echo Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'')); ?>

                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group form-group-default">
                                 <label for="">Chosse Tax Rate </label><a href="javascript()" class="float-right text-primary" data-toggle="modal" data-target="#taxRate">Add Tax Rate</a>
                                 <select name="tax_rate" id="selectTax" class="form-control select2"></select>
                              </div>
                           </div>
                        </div>
                        <div class="form-group form-group-default">
                           <label for="" class="">Supplier <a href="" class="pull-right" data-toggle="modal" data-target="#addSupplier">Add Supplier</a></label>
                           <select name="supplier" id="selectSupplier" class="form-control select2"></select>
                        </div>
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Reference', 'Reference (i.e Payment Code)', array('class'=>'control-label')); ?>

                           <?php echo Form::text('refrence_number', null, array('class' => 'form-control', 'placeholder' => 'Reference')); ?>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Expence Details</h4>
                     </div>
                     <div class="panel-body">                  
                        <div class="form-group form-group-default">
                           <label for="">Allocate to lease </label>
                           <select name="" class="form-control multiselect">
                              <option value="leaseID">Choose Lease</option>
                              <?php $__currentLoopData = $leases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lease): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $lease->leaseID; ?>"><?php echo $lease->serial; ?> | <?php echo $lease->tenant_name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                        <div class="form-group form-group-default">
                           <label for="">Allocate to Unit</label>
                           <select name="unitID" class="form-control multiselect">
                              <option value="">Choose Unit</option>
                              <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $unit->propID; ?>"><?php echo $unit->serial; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Choose status', 'Choose status', array('class'=>'control-label text-danger')); ?>

                           <?php echo e(Form::select('status', [''=>'Choose status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ])); ?>

                        </div>
                        <div class="form-group form-group-default">
                           <label for="">Method Of Payment</label>
                           <select name="payment_method" class="form-control multiselect">
                              <?php $__currentLoopData = $mainMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $main): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $main->id; ?>"><?php echo $main->name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php $__currentLoopData = $paymentmethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $method->id; ?>"><?php echo $method->name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>                     
                        </div>
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Expence Files', 'Expense Files', array('class'=>'control-label')); ?><br>
                           <input type="file" name="files[]" id="files" multiple>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Description</h4>
                     </div>
                     <div class="panel-body">
                        <div class="form-group">
                           <?php echo Form::textarea('description',null,['class'=>'form-control my-editor', 'rows' => 9, 'placeholder'=>'content']); ?>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 mb-5">
                  <center>
                     <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Add Expense</button>		
                     
                  </center>
               </div>
            </div>
         </form>
      </div>
      <?php echo $__env->make('app.finance.expense.category.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo $__env->make('app.finance.taxes.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
      <?php echo $__env->make('app.finance.payments.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
	<?php echo $__env->make('app.partials._express_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/expense/create.blade.php ENDPATH**/ ?>