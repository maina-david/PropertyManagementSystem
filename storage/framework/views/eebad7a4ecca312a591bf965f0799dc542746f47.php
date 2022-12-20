<?php $__env->startSection('title','All employees'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         
         <?php if (app('laratrust')->isAbleTo('create-employee')) : ?>
            <a href="<?php echo route('hrm.employee.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add employee</a>
         <?php endif; // app('laratrust')->permission ?>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All employee </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5%"></th>
                     <th class="text-nowrap">Name</th>
                     <th class="text-nowrap">Employee ID</th>
                     <th class="text-nowrap">Email</th>
                     <th class="text-nowrap">Leave Days</th>
                     <th class="text-nowrap"width="7%">Employment status</th>
                     <th class="text-nowrap" width="12%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr role="row" class="odd"> 
                        <td><?php echo $count++; ?></td>
                        <td>
                           <?php if($employee->image != ""): ?>
                              <img class="rounded-circle" width="32" height="32" alt="<?php echo $employee->names; ?>" src="<?php echo asset('businesses/'.$employee->businessCode.'/hr/employee/images/'.$employee->image); ?>">
                           <?php else: ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo $employee->names; ?>&rounded=true&size=32" alt="">
                           <?php endif; ?>
                        </td>
                        <td><?php echo $employee->names; ?></td>
                        <td><?php echo $employee->companyID; ?></td>
                        <td><?php echo $employee->company_email; ?></td>
                        <td><?php echo $employee->leave_days; ?></td>
                        <td><span class="badge <?php echo $employee->statusName; ?>"><?php echo $employee->statusName; ?></span></td>
                        <td>
                           <?php if (app('laratrust')->isAbleTo('update-employee')) : ?>
                              <a href="<?php echo e(route('hrm.employee.edit',$employee->employeeID)); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                           <?php endif; // app('laratrust')->permission ?>
                           <?php if (app('laratrust')->isAbleTo('read-employee')) : ?>
                              <a href="<?php echo route('hrm.employee.show',$employee->employeeID); ?>" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                           <?php endif; // app('laratrust')->permission ?>
                           <?php if (app('laratrust')->isAbleTo('delete-employee')) : ?>
                              <a href="#" class="delete btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                           <?php endif; // app('laratrust')->permission ?>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/employee/index.blade.php ENDPATH**/ ?>