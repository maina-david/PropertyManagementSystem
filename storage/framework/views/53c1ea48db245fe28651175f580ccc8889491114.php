<?php $__env->startSection('title','CRM | Reports | Industry'); ?>
<?php $__env->startSection('stylesheet'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- begin #content -->
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('crm.dashboard'); ?>">CRM </a></li>
         <li class="breadcrumb-item">Reports</li>
         <li class="breadcrumb-item active">Leads by industry</li>
      </ol>
 
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-industry-alt"></i> Leads by industry | <?php echo $industryRequest; ?> | <?php echo date('F j, Y', strtotime($start)); ?> to <?php echo date('F j, Y', strtotime($end)); ?></h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-8">
            <form action="<?php echo route('crm.reports.leads.industry.filter'); ?>" method="GET" class="row" autocomplete="off">
               <div class="col-md-3">
                  <div class="form-group">
                     <?php echo Form::select('industry',$industies,null,['class'=>'form-control multiselect']); ?>

                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <?php echo Form::text('start',null,['class'=>'form-control datepicker','placeholder'=>'Start date','required' => '']); ?>

                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <?php echo Form::text('end',null,['class'=>'form-control datepicker','placeholder'=>'End date','required' => '']); ?>

                  </div>
               </div>               
               <div class="col-md-3">
                  <div class="form-group">
                     <button class="btn btn-primary" type="submit">Apply Filter</button>
                  </div>
               </div>      
            </form>
         </div>
         <div class="col-md-4">
            <a href="<?php echo route('crm.reports.leads.industry.export',[$industryValue,$start,$end]); ?>" class="float-right btn btn-pink"><i class="fal fa-file-excel"></i> Export to csv</a>
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Email</th>  
                        <th>Owner</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Street</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>  
                        <th>Date added</th>                                     
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $lead->customer_name; ?></td>
                              <td><?php echo $lead->primary_phone_number; ?></td>
                              <td><?php echo $lead->email; ?></td>
                              <td>
                                 <?php if($lead->assignedID != 0): ?>
                                    <?php echo Hr::employee($lead->assignedID)->names; ?>

                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php if($lead->sourceID != 0): ?>
                                    <?php if(Crm::check_sources($lead->sourceID) != 0): ?>
                                       <?php echo Crm::source($lead->sourceID)->name; ?>

                                    <?php endif; ?>                                    
                                 <?php endif; ?>
                              </td>                              
                              <td>
                                 <?php if($lead->statusID != 0): ?>
                                    <?php if(Crm::check_lead_status($lead->statusID) != 0): ?>
                                       <?php echo Crm::lead_status($lead->statusID)->name; ?>

                                    <?php endif; ?>                                    
                                 <?php endif; ?>
                              </td>
                              <td><?php echo $lead->bill_street; ?></td>
                              <td><?php echo $lead->bill_city; ?></td>
                              <td><?php echo $lead->bill_state; ?></td>
                              <td>
                                 <?php if($lead->bill_country != ""): ?>
                                    <?php echo Wingu::country($lead->bill_country)->name; ?>

                                 <?php endif; ?>
                              </td>
                              <td><?php echo date('F j, Y', strtotime($lead->date)); ?></td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/reports/leads/industry.blade.php ENDPATH**/ ?>