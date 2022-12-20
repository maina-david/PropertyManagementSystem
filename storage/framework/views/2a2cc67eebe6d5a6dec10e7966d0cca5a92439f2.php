<?php $__env->startSection('title'); ?> Property Report | <?php echo $property->title; ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('stylesheet'); ?>
   <style>
      button {
         font-size: 14px;
         border: none;
         background-color: #fff;
         margin-left: -5px;
         color: #007bff;
      }
   </style>  
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Reports</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Property Report </h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php
            $lastDayofMonth = \Carbon\Carbon::now()->endOfMonth()->toDateString();
            $firstdate = \Carbon\Carbon::now()->startOfMonth()->toDateString();
         ?>
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading"><i class="fal fa-chart-pie"></i> Reports</div>
               <div class="panel-body">
                  <div class="row">               
                     <div class="col-md-3">
                        <form action="<?php echo route('property.reports.profitandloss',$property->id); ?>" method="GET">
                           <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                           <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                           <button type="submit">Profit and Loss</button>
                        </form> 
                     </div>
                     <div class="col-md-3">
                        <form action="<?php echo route('property.reports.expensesummary',$property->id); ?>" method="GET">
                           <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                           <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                           <button type="submit">Expense Summary</button>
                        </form> 
                     </div>
                     <div class="col-md-3">
                        <form action="<?php echo route('property.reports.incomesummary',$property->id); ?>" method="GET">
                           <input type="hidden" name="to" value="<?php echo $lastDayofMonth; ?>">
                           <input type="hidden" name="from" value="<?php echo $firstdate; ?>">
                           <button type="submit">Income Summary</button>
                        </form> 
                     </div>
                     
                     
                     
                     
                     
                     
                     
                  </div>
               </div>
            </div>
         </div>
      </div> 
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/reports/dashboard.blade.php ENDPATH**/ ?>