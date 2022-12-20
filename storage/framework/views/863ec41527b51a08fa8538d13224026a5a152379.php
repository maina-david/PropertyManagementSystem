<?php $__env->startSection('title','Sales by Sales Person report'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.report'); ?>">Report</a></li>
         <li class="breadcrumb-item active">Sales by Sales Person</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Sales by Sales Person</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="col-md-12 mb-3">
         <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
               <a href="<?php echo route('finance.report.sales.salesperson.pdf',[$to,$from]); ?>" class="btn btn-pink pull-right"><i class="fas fa-file-pdf"></i> Export in pdf</a>
               <a href="<?php echo route('finance.report.sales.salesperson.print',[$to,$from]); ?>" class="btn btn-pink pull-right mr-2"><i class="fas fa-print"></i> Print</a>
               <a href="#" data-toggle="modal" data-target="#filter" class="btn btn-pink pull-right mr-2"><i class="fas fa-calendar-day"></i> Filter</a>
            </div>
         </div>         
      </div>
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <h3 class="text-center">Sales by Sales Person</h3>
               <h5 class="text-center">From <?php echo date('F jS, Y', strtotime($from)); ?> To <?php echo date('F jS, Y', strtotime($to)); ?></h5>
               <table class="table table-striped">
                  <thead>
                     <tr>  
                        <th>Name</th>  
                        <th><center>Invoice count</center></th>  
                        <th><center>Total sales</center></th> 
                     </tr>
                  </thead> 
                  <tbody> 
                     <?php $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           <td><a href="#"><?php echo $sale->salesperson; ?></a></td>
                           <td><center><?php echo Finance::count_invoice_salesperson($sale->salespersonID); ?></center></td>
                           <td><center><b><?php echo number_format($sale->total); ?> <?php echo $sale->code; ?></b></center></td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php $__currentLoopData = $others; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                           <td>Other</td>
                           <td><center><?php echo $otherCounts; ?></center></td>
                           <td><center><b><?php echo number_format($other->total); ?> <?php echo $other->code; ?></b></center></td>
                        </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><b>Total</b></td>
                        <td><center><?php echo $totalCount; ?></center></td>
                        <td><center><b><?php echo number_format($total->sum('total')); ?> <?php echo Wingu::currency()->code; ?></b></center></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <form action="<?php echo route('finance.report.sales.salesperson'); ?>" method="GET" autocomplete="off">
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
                     <label for="">From</label>
                     <?php echo Form::text('from',null,['class'=>'form-control datepicker','placeholder' => 'choose date']); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="">To</label>
                     <?php echo Form::text('to',null,['class'=>'form-control datepicker','placeholder' => 'choose date']); ?>

                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button class="btn btn-success" type="submit">Filter date</button>
               </div>
            </div>
         </div>
      </div>
   </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/reports/sales/salesperson.blade.php ENDPATH**/ ?>