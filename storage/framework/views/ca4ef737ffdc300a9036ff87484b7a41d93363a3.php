<?php $__env->startSection('title','Manage Accounts'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb --> 
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.account'); ?>">Bank & Cash</a></li>
         <li class="breadcrumb-item active">Manage Accounts</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-piggy-bank"></i> Manage Accounts</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Accounts</h4>
            </div>
            <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                  <thead>
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Account</th>
                     <th>Description</th>
                     <th width="13%">Balance</th>
                     <th width="15%">Action</th>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           <td><?php echo $count++; ?></td>
                           <td><?php echo $account->title; ?></td>
                           <td><?php echo $account->account_number; ?></td>
                           <td><?php echo $account->description; ?></td>
                           <td><?php echo $account->code; ?> <?php echo number_format($account->initial_balance); ?></td>
                           <td>
                              <?php if (app('laratrust')->isAbleTo('update-bankaccount')) : ?>
                                 <a href="<?php echo route('finance.account.edit',$account->accountID); ?>" class="btn btn-pink"><i class="fas fa-edit"></i> Edit</a>
                              <?php endif; // app('laratrust')->permission ?>
                              <?php if (app('laratrust')->isAbleTo('delete-bankaccount')) : ?>
                                 <a href="<?php echo route('finance.account.delete',$account->accountID); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/accounts/index.blade.php ENDPATH**/ ?>