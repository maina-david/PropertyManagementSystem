<?php $__env->startSection('title','Aging report'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.report'); ?>">Report</a></li>
         <li class="breadcrumb-item active">Aging report</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Aging report</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
               <a href="#" class="btn btn-pink pull-right"><i class="fas fa-file-pdf"></i> Export in pdf</a>
               
            </div>
         </div>         
      </div>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <h3 class="text-center">A/R Aging Report</h3>
               <h5 class="text-center mt-3 mb-3">As of <?php echo $date; ?> </h5>
               <table class="table table-striped">
                  <thead>
                     <tr>  
                        <th>Customer Name</th>  
                        <th>Current</th>
                        <th>31 - 60 Days</th>
                        <th>61 - 90 Days</th>
                        <th>91 - 120 Days</th>
                        <th>121 - 150 Days</th>
                        <th>151 - 180 Days</th>
                     </tr>
                  </thead> 
                  <tbody> 
                     <?php $__currentLoopData = $ages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           <td><a href="#"><?php echo $age->customer_name; ?></a></td>
                           <td><?php echo $currency->symbol; ?><?php echo number_format($age->age130,2); ?></td>
                           <td><?php echo $currency->symbol; ?><?php echo number_format($age->age3160,2); ?></td>
                           <td><?php echo $currency->symbol; ?><?php echo number_format($age->age6190,2); ?></td>
                           <td><?php echo $currency->symbol; ?><?php echo number_format($age->age91120,2); ?></td>
                           <td><?php echo $currency->symbol; ?><?php echo number_format($age->age121150,2); ?></td>
                           <td><?php echo $currency->symbol; ?><?php echo number_format($age->age151180,2); ?></td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <th>Total</th>
                        <th><?php echo $currency->symbol; ?><?php echo number_format($ages->sum('age130'),2); ?></th>
                        <th><?php echo $currency->symbol; ?><?php echo number_format($ages->sum('age3160'),2); ?></th>
                        <th><?php echo $currency->symbol; ?><?php echo number_format($ages->sum('age6190'),2); ?></th>
                        <th><?php echo $currency->symbol; ?><?php echo number_format($ages->sum('age91120'),2); ?></th>
                        <th><?php echo $currency->symbol; ?><?php echo number_format($ages->sum('age121150'),2); ?></th>
                        <th><?php echo $currency->symbol; ?><?php echo number_format($ages->sum('age151180'),2); ?></th>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <form action="<?php echo route('finance.report.receivables.aging'); ?>" method="GET" autocomplete="off">
      <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filter" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Filter Date</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">                  
                  <div class="form-group form-group-default">
                     <label for="">Choose Date</label>
                     <input type="date" name="date" class="form-control" required>
                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-success" type="submit">Submit date</button>
               </div>
            </div>
         </div>
      </div>
   </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/reports/receivables/aging.blade.php ENDPATH**/ ?>