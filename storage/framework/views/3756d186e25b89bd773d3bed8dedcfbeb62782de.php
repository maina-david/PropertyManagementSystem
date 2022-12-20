<?php $__env->startSection('title'); ?> Expenses | Edit | <?php echo $property->title; ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('breadcrum'); ?>
   <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
         <div class="welcome-text">
            <h4><i class="fal fa-home"></i> <?php echo $property->title; ?> | Expense | Edit </h4>
         </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
            <li class="breadcrumb-item"><a href="<?php echo route('property.show',$property->id); ?>"><?php echo $property->title; ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo route('property.expense',$property->id); ?>">Expense</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo e(route('property.expense.edit',[$property->id,$expense->id])); ?>">Edit</a></li> 
         </ol>
      </div>
   </div>
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
   <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Edit Expense </h1>
   <div class="row">
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12 mt-3">   
         <?php echo Form::model($expense, ['route' => ['property.expense.update',[$property->id,$expense->id]], 'method'=>'post','enctype'=>'multipart/form-data', 'autocomplete' => 'off']); ?>

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
                           <select name="expense_category" id="selectCategory" class="form-control select2" required>
                              <?php if($expense->expense_category != ""): ?>
                                 <option value="<?php echo $expense->expense_category; ?>"><?php echo $expenseCategory->category_name; ?></option>
                              <?php endif; ?>
                           </select>
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
                                 <select name="tax_rate" id="selectTax" class="form-control select2">
                                    <?php if($expense->tax_rate != ""): ?> 
                                       <option value="<?php echo $expense->tax_rate; ?>"><?php echo $tax->name; ?> | <?php echo $tax->rate; ?>%</option>
                                    <?php endif; ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="form-group form-group-default">
                           <label for="" class="">Supplier <a href="" class="pull-right" data-toggle="modal" data-target="#addSupplier">Add Supplier</a></label>
                           <select name="supplier" id="selectSupplier" class="form-control select2">
                              <?php if($expense->supplierID != ""): ?>
                                 <option value="<?php echo $expense->supplierID; ?>"><?php echo $supplier->supplierName; ?></option>
                              <?php endif; ?>
                           </select>
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
                           <select name="leaseID" class="form-control multiselect">
                              <?php if($expense->leaseID != ""): ?>
                                 <option value="<?php echo $expense->leaseID; ?>"><?php echo $leaseInfo->serial; ?> | <?php echo $leaseInfo->tenant_name; ?></option>
                              <?php else: ?> 
                                 <option value="leaseID">Choose Lease</option>
                              <?php endif; ?>
                              <?php $__currentLoopData = $leases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lease): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo $lease->leaseID; ?>"><?php echo $lease->serial; ?> | <?php echo $lease->tenant_name; ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                        </div>
                        <div class="form-group form-group-default">
                           <label for="">Allocate to Unit</label>
                           <?php echo Form::select('unitID',$units,null,['class' => 'form-control multiselect']); ?>

                        </div>
                        <div class="form-group form-group-default">
                           <?php echo Form::label('Choose status', 'Choose status', array('class'=>'control-label text-danger')); ?>

                           <?php echo e(Form::select('statusID', [''=>'Choose status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ])); ?>

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
                        <div class="row mt-4">
                           <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <div class="col-md-2">
                                 <?php if(stripos($file->file_mime, 'image') !== FALSE): ?>
                                    <img src="<?php echo asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/expense/'.$file->file_name); ?>" alt="" style="width:100%;height:80px">
                                 <?php elseif(stripos($file->file_mime, 'pdf') !== FALSE): ?>
                                    <center><i class="fas fa-file-pdf fa-4x" style="width:100%;height:80px"></i></center>
                                 <?php elseif(stripos($file->file_mime, 'octet-stream') !== FALSE): ?>
                                    <center><i class="fas fa-file-alt fa-4x" style="width:100%;height:80px"></i></center>
                                 <?php elseif(stripos($file->file_mime, 'officedocument') !== FALSE): ?>
                                    <center><i class="fas fa-file-word fa-4x" style="width:100%;height:80px"></i></center>
                                 <?php else: ?>
                                    <center><i class="fas fa-file fa-4x" style="width:100%;height:80px"></i></center>
                                 <?php endif; ?>
                                 <center>
                                    <?php if (app('laratrust')->isAbleTo('update-expense')) : ?>
                                       <a href="<?php echo route('property.expense.delete.file',[$property->id,$expense->id,$file->id]); ?>" title="delete" class="badge badge-danger delete"><i class="fas fa-trash"></i></a>
                                    <?php endif; // app('laratrust')->permission ?>
                                    <a href="<?php echo asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/expense/'.$file->file_name); ?>" title="download" class="badge badge-primary mt-1" target="_blank"><i class="fas fa-download"></i></a>
                                    <a href="<?php echo asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/expense/'.$file->file_name); ?>" title="view" class="badge badge-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
                                 </center>
                              </div>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                     <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Update Expense</button>		
                     
                  </center>
               </div>
            </div>
         <?php echo Form::close(); ?>

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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/expense/edit.blade.php ENDPATH**/ ?>