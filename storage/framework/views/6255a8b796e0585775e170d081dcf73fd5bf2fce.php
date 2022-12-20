 

<?php $__env->startSection('title','Leads List'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="float-right">
         <a href="<?php echo route('crm.leads.create'); ?>" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add Lead</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-phone-volume"></i> All Leads</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Leads List</h4>
         </div>
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th>Lead Name</th>
                     <th>Email</th>
                     <th>Phone</th>
                     <th>Assigned</th>
                     <th>Status</th>
                     <th>Date Added</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <th width="1%">#</th>
                  <th>Lead Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Assigned</th>
                  <th>Status</th>
                  <th>Date Added</th>
                  <th width="10%">Action</th>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                           <?php if($lead->title != ""): ?>
                              <b><?php echo $lead->title; ?></b><br>
                           <?php endif; ?>
                           <?php echo $lead->customer_name; ?>

                        </td>
                        <td><?php echo $lead->email; ?></td>
                        <td><?php echo $lead->primary_phone_number; ?></td>
                        <td>
                           <?php if(Wingu::check_user($lead->assignedID) == 1): ?>
                              <?php echo Wingu::user($lead->assignedID)->name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if(Crm::check_lead_status($lead->statusID) > 0): ?>
                              <span class="badge badge-pink"><?php echo Crm::lead_status($lead->statusID)->name; ?></span>
                           <?php endif; ?>
                        </td>
                        <td>
                           <?php echo date("F d, Y", strtotime($lead->created_at)); ?>

                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo e(route('crm.leads.show', $lead->leadID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 <li><a href="<?php echo route('crm.leads.edit',$lead->leadID); ?>"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 <li><a href="<?php echo route('crm.leads.delete', $lead->leadID); ?>" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/leads/index.blade.php ENDPATH**/ ?>