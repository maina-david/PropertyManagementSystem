<?php $__env->startSection('title'); ?> Expenses | Create | <?php echo $property->title; ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 


<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
      <li class="breadcrumb-item"><a href="<?php echo route('property.expense',$property->id); ?>">Expense</a></li>
      <li class="breadcrumb-item active"><a href="<?php echo route('property.expense',$property->id); ?>">All</a></li> 
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Expense</h1>
   <div class="row">

   
      <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12 mt-3">
         <a href="<?php echo route('property.expense.create',$property->id); ?>" class="btn btn-primary"><i class="fal fa-plus-circle"></i> Add Expense</a>
      </div>
      <div class="col-md-12 mt-3">   
         <div class="panel">
            <div class="panel-heading"><b>Expense</b></div>
            <div class="panel-body">
               <table id="example5" class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="10%">Date</th>
                        <th>Expense Category</th>
                        <th>Reference#</th>
                        <th>Expense Title</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th width="8%">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <tr >
                           <td><?php echo $count++; ?></td>
                           <td><?php echo date('M j, Y',strtotime($exp->date)); ?></td>
                           <td><?php echo $exp->category_name; ?></td>
                           <td><b><?php echo $exp->refrence_number; ?></b></td>
                           <td><?php echo $exp->expense_name; ?></td>
                           <td>
                              <span class="badge <?php echo $exp->statusName; ?>">
                                 <?php echo $exp->statusName; ?>

                              </span>
                           </td>
                           <td><b><?php echo $exp->code; ?> <?php echo number_format($exp->amount); ?></b></td>
                           <td>
                              <?php if (app('laratrust')->isAbleTo('update-expense')) : ?>
                                 <a href="<?php echo e(route('property.expense.edit',[$property->id,$exp->eid])); ?>" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                              <?php endif; // app('laratrust')->permission ?>
                              <?php if (app('laratrust')->isAbleTo('update-expense')) : ?>
                                 <a href="<?php echo route('property.expense.delete',[$property->id,$exp->eid]); ?>" class="delete btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                              <?php endif; // app('laratrust')->permission ?>
                           </td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/expense/index.blade.php ENDPATH**/ ?>