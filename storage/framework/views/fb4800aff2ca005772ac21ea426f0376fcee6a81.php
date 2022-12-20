<?php $__env->startSection('title','Travel | Human Resource'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         
         <a href="<?php echo route('hrm.travel.create'); ?>" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Travel</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-plane"></i> All Travel Requests </h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-responsive">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>TravelID</th>
                     <th>Place</th>
                     <th>Departure</th>
                     <th>Arrival</th>
                     <th>Duration</th>
                     <th>Customer</th>
                     <th>Purpose</th>
                     <th>Billing</th>
                     <th>Status</th>
                     <th width="8%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $travels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $travel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $travel->travel_code; ?></td>
                        <td><?php echo $travel->place_of_visit; ?></td>
                        <td><?php echo date('M jS, Y', strtotime($travel->departure_date)); ?></td>
                        <td><?php echo date('M jS, Y', strtotime($travel->date_of_arrival)); ?></td>
                        <td><?php echo $travel->duration; ?></td>
                        <td><?php echo $travel->customer_name; ?></td>
                        <td><?php echo $travel->purpose_of_visit; ?></td>
                        <td><?php echo $travel->bill_customer; ?></td>
                        <td><span class="badge <?php echo $travel->statusName; ?>"><?php echo $travel->statusName; ?></span></td>
                        <td>
                           <a href="<?php echo route('hrm.travel.edit',$travel->travID); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                           <a href="<?php echo route('hrm.travel.delete',$travel->travID); ?>" class="delete btn btn-danger btn-sm"><i class="fas fa-trash "></i></a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/travel/index.blade.php ENDPATH**/ ?>