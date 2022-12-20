<?php $__env->startSection('title','CRM | Reports'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      button {
         font-size: 14px;
         border: none;
         background-color: #fff;
         margin-left: -5px;
         color: #007bff;
         font-weight: 900;
      }
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Customer Relationship Management </a></li>
         <li class="breadcrumb-item active">Reports</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-chart-pie"></i> Reports</h1>
      <?php
         $endDate = \Carbon\Carbon::now()->endOfMonth()->toDateString();
         $startDate = \Carbon\Carbon::now()->startOfMonth()->toDateString();
      ?>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="card">
               <div class="card-header">Lead Reports</div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-4">
                        <form action="<?php echo route('crm.reports.leads.status.filter'); ?>" method="GET">
                           <input type="hidden" name="end" value="<?php echo $endDate; ?>">
                           <input type="hidden" name="start" value="<?php echo $startDate; ?>">
                           <input type="hidden" name="status" value="all">
                           <button type="submit">Leads by Status</button>
                        </form>                         
                     </div>
                     <div class="col-md-4">
                        <form action="<?php echo route('crm.reports.leads.source.filter'); ?>" method="GET">
                           <input type="hidden" name="end" value="<?php echo $endDate; ?>">
                           <input type="hidden" name="start" value="<?php echo $startDate; ?>">
                           <input type="hidden" name="source" value="all">
                           <button type="submit">Leads by Source</button>
                        </form> 
                     </div>
                     <div class="col-md-4">
                        <form action="<?php echo route('crm.reports.leads.industry.filter'); ?>" method="GET">
                           <input type="hidden" name="end" value="<?php echo $endDate; ?>">
                           <input type="hidden" name="start" value="<?php echo $startDate; ?>">
                           <input type="hidden" name="industry" value="all">
                           <button type="submit">Leads by Industry</button>
                        </form> 
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/reports/dashboard.blade.php ENDPATH**/ ?>