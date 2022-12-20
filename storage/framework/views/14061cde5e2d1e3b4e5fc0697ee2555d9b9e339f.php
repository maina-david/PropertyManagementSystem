<?php $__env->startSection('title','Customer List'); ?>


<?php $__env->startSection('sidebar'); ?>
  <?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="<?php echo route('crm.customers.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customers</a>
         <?php if (app('laratrust')->isAbleTo('create-contact')) : ?>
            <a href="<?php echo route('finance.contact.import'); ?>" target="_blank" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
         <?php endif; // app('laratrust')->permission ?>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Customer List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phonenumber</th>
                     <th>Category</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>#</th>
                     <th>Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phonenumber</th>
                     <th>Category</th>
                     <th>Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr >
                        <td><?php echo $count++; ?></td>
                        <td>
                           <?php if($contact->image != ""): ?>
                              <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$contact->customer_code.'/images/'.$contact->image); ?>" alt="" style="width:40px;height:40px" class="rounded-circle">
                           <?php else: ?>
                              <img src="https://ui-avatars.com/api/?name=<?php echo $contact->customer_name; ?>&rounded=true&size=40" alt="">
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($contact->contact_type == 'Individual'): ?>
                              <?php echo $contact->salutation; ?> <?php echo $contact->customer_name; ?>

                           <?php else: ?>
                              <?php echo $contact->customer_name; ?>

                           <?php endif; ?>
                        </td>
                        <td><?php echo $contact->email; ?></td>
                        <td><?php echo $contact->primary_phone_number; ?></td>
                        <td>
									<?php $__currentLoopData = Finance::client_category($contact->customerID); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<span class="badge badge-primary"><?php echo $category->name; ?></span>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <?php if (app('laratrust')->isAbleTo('read-crmcustomers')) : ?>
                                    <li><a href="<?php echo e(route('crm.customers.show',$contact->customerID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('update-crmcustomers')) : ?>
                                    <li><a href="<?php echo e(route('crm.customers.edit', $contact->customerID)); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('delete-crmcustomers')) : ?>
                                    <li><a href="<?php echo route('crm.customers.delete', $contact->customerID); ?>" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                                 <?php endif; // app('laratrust')->permission ?>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/customers/index.blade.php ENDPATH**/ ?>