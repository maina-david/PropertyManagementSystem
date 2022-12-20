<?php $__env->startSection('title','Marketing | Listing'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Marketing</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Inquiries</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullhorn"></i> Marketing - Inquiries </h1>
   	<div class="card card-default">
	      <div class="card-body">
	        <table id="data-table-default" class="table table-striped table-bordered table-hover">
	            <thead>
	               <tr>
	                  <th width="1%">#</th>
	                  <th>Name</th>
	                  <th>Email</th>
	                  <th>Phone Number</th>
	                  <th>Listing</th>
	                  <th>Date</th>
	                  <th width="13%">Action</th>
	               </tr>
	            </thead>
	            <tbody>
	               <?php $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                  <tr>
	                     <td><?php echo $count++; ?></td>
	                     <td><?php echo $inquiry->names; ?></td>
	                     <td><?php echo $inquiry->mail_from; ?></td>
	                     <td><?php echo $inquiry->phone_number; ?></td>
	                     <td>
	                        <?php if($inquiry->listingID != ""): ?>
	                           <?php echo Property::listing($inquiry->listingID)->title; ?>

	                        <?php endif; ?>
	                     </td>
	                     <td><?php echo date('M jS, Y', strtotime($inquiry->created_at)); ?></td>
	                     <td>
	                        <a href="" class="btn btn-success" data-toggle="modal" data-target="#inquirty<?php echo $inquiry->id; ?>">View Inquiry</a>
	                     </td>
	                  </tr>
	                  <!-- Modal -->
	                  <div class="modal fade" id="inquirty<?php echo $inquiry->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	                     <div class="modal-dialog" role="document">
	                     <div class="modal-content">
	                        <div class="modal-header">
	                           <h5 class="modal-title" id="exampleModalLabel">Inquiry Message</h5>
	                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                           <span aria-hidden="true">&times;</span>
	                           </button>
	                        </div>
	                        <div class="modal-body">
	                           <?php echo $inquiry->message; ?>

	                        </div>
	                        <div class="modal-footer">
	                           <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	                        </div>
	                     </div>
	                     </div>
	                  </div>
	               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	            </tbody>
	         </table>
	      </div>
	   </div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/marketing/inquiry/index.blade.php ENDPATH**/ ?>