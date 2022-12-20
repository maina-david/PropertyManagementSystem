<?php $__env->startSection('title','Digital Marketing Accounts'); ?>


<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="#">CRM</a></li>
         <li class="breadcrumb-item"><a href="#">Digital Marketing</a></li>
         <li class="breadcrumb-item active">Accounts</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-share-alt"></i> Account</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">All Account</h4>
            </div>
            <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                  <thead>
                     <th width="1%">#</th>
                     <th>Client Name</th>
                     <th>Description</th>
                     <th>Budget Estimate</th>
                     <th>Status</th>
                     <th>Account Date</th>
                     <th width="21%">Action</th>
                  </thead>
                  <tbody>
                     <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                           <?php echo $account->customer_name; ?>

                        </td>
                        <td><?php echo $account->description; ?></td>
                        <td><?php echo $account->budget; ?></td>
                        <td><span class="btn btn-sm <?php echo $account->name; ?>"><?php echo $account->name; ?></span></td>
                        <td><?php echo date('jS F, Y', strtotime($account->account_date)); ?></td>
                        <td>
                           <a href="<?php echo route('crm.account.edit',$account->accountID); ?>" class="btn btn-pink"><i class="fas fa-edit"></i> Edit</a>
                           <a href="<?php echo route('crm.channel.index',$account->accountID); ?>" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
                           <a href="<?php echo route('crm.marketing.account.delete',$account->accountID); ?>" class="btn btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/social/account/index.blade.php ENDPATH**/ ?>