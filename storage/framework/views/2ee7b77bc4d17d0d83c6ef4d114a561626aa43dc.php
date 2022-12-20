<?php $__env->startSection('title','Deals'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="float-right">
         <a href="<?php echo route('crm.deals.create'); ?>" class="btn btn-pink"><i class="fas fa-bullseye"></i> Add Deal</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-bullseye"></i> Deals</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Deals List</h4>
         </div>
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Value</th>
                     <th>Pipeline</th>
                     <th>Stage</th>
                     <th>Sale Owner</th>
                     <th>Closing</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <th width="1%">#</th>
                  <th>Title</th>
                  <th>Value</th>
                  <th>Pipeline</th>
                  <th>Stage</th>
                  <th>Sale Owner</th>
                  <th>Closing</th>
                  <th>Status</th>
                  <th width="10%">Action</th>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $deal->title; ?></td>
                        <td><?php echo $deal->code; ?> <?php echo number_format($deal->value); ?></td>
                        <td>
                           <span class="badge badge-warning">
                              <?php if(Crm::check_pipeline($deal->pipeline) != 0): ?>  
                                 <?php echo Crm::pipeline($deal->pipeline)->title; ?>

                              <?php endif; ?>
                           </span>
                        </td>
                        <td>
                           <span class="badge badge-primary">
                              <?php if(Crm::check_pipeline_stage($deal->stage) != 0): ?>  
                                 <?php echo Crm::pipeline_stage($deal->stage)->title; ?>

                              <?php endif; ?>
                           </span>
                        </td>
                        <td>
                           <?php if(Hr::check_employee($deal->owner) != 0): ?>
                              <?php echo Hr::employee($deal->owner)->names; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($deal->close_date != ""): ?>
                              <?php echo date('F jS Y', strtotime($deal->close_date)); ?>

                           <?php endif; ?>
                        </td>
                        <td><?php echo $deal->status; ?></td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo route('crm.deals.show',$deal->dealID); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="<?php echo route('crm.deals.edit',$deal->dealID); ?>"><i class="fad fa-edit"></i> Edit</a></li>
                                 <li><a href="<?php echo route('crm.deals.delete',$deal->dealID); ?>" class="delete"><i class="fad fa-trash"></i> Delete</a></li>                                 
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/deals/deal/index.blade.php ENDPATH**/ ?>