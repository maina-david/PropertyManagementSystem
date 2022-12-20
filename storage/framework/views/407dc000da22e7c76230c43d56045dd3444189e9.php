<?php $__env->startSection('title','Income Summary | Report'); ?>

<?php $__env->startSection('stylesheet'); ?>
   <style>
      td.table-bg{
         background-color: #e0e7eb;
         font-weight: 900;
         padding-top: 8px;
         padding-bottom: 0px;
      }
   </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.report'); ?>">Report</a></li>
         <li class="breadcrumb-item active">Income Summary</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-sack-dollar"></i> Income Summary</h1> 
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <div class="row">
               <div class="col-md-12">
                  <a href="#" data-toggle="modal" data-target="#filter" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
                     <i class="fal fa-search"></i> Filter
                  </a>
                  <a href="<?php echo route('finance.report.incomesummary.extract',[$to,$from]); ?>" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
                     <i class="fal fa-file-pdf t-plus-1 fa-fw fa-lg"></i> Export as PDF
                  </a>
                  <a href="<?php echo route('finance.report.incomesummary.extract',[$to,$from]); ?>" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
                     <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
                  </a>                  
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <div class="rep-container"> 
                           <div class="page-header text-center">
                              <h3><?php echo $business->name; ?></h3> 
                              <h4>Income Summary</h4> 
                              <h5><span class="text-primary">From </span><?php echo date('F j,Y', strtotime($from) ); ?> <span>To</span> <?php echo date('F j,Y', strtotime($to) ); ?> </h5> 
                           </div>  
                           <div class="reports-table-wrapper fill-container table-container"> 
                              <table class="table zi-table financial-comparison table-no-border">
                                 <thead>
                                    <tr class="rep-fin-th"> 
                                    <th class="text-left"><h3>Income</h3></th> 
                                    <th class="text-right"><h3>Total</h3></th>  
                                    </tr>
                                 </thead> 
                                 <tbody> 
                                    <?php $__currentLoopData = $incomeCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if(Finance::check_invoice_in_category_by_period($category->id,$from,$to) != 0): ?>
                                          <?php $__currentLoopData = Finance::invoices_per_income_category($category->id,$from,$to); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <tr class=" balance-tr">
                                                <td><?php echo $category->name; ?></td>  
                                                <td class="text-right"><?php echo $business->symbol; ?><?php echo number_format(Finance::invoices_per_income_category_sum($category->id,$from,$to),2); ?></td>  
                                             </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                       <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $defaultCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $default): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if(Finance::check_invoice_in_category_by_period($default->id,$from,$to) != 0): ?>
                                          <?php $__currentLoopData = Finance::invoices_per_income_category($default->id,$from,$to); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <tr class=" balance-tr">
                                                <td><?php echo $default->name; ?></td>  
                                                <td class="text-right"><?php echo $business->symbol; ?><?php echo number_format(Finance::invoices_per_income_category_sum($default->id,$from,$to),2); ?></td>  
                                             </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                       <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php if($unCategorisedInvoicesCount != 0): ?>
                                       <tr class=" balance-tr">
                                          <td>Others</td>  
                                          <td class="text-right"><?php echo $business->symbol; ?><?php echo number_format($unCategorisedInvoicesSum + $unCategorisedInvoicesSum2,2); ?></td>  
                                       </tr>
                                    <?php endif; ?>
                                    <tr>
                                       <td><b>Total Income</b></td>   
                                       <td class="text-right"><b><?php echo $business->symbol; ?><?php echo number_format($income,2); ?></b></td>  
                                    </tr>                                     
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-2"></div>
      </div>
   </div>
    <!-- Modal -->
    <form action="<?php echo route('finance.report.incomesummary'); ?>" method="GET" autocomplete="off">
      <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filter" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Filter by Date</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group form-group-default">
                     <label for="">From</label>
                     <?php echo Form::date('from',null,['class'=>'form-control','required' => '']); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="">To</label>
                     <?php echo Form::date('to',null,['class'=>'form-control','required' => '']); ?>

                  </div>
               </div>
               <div class="modal-footer">
                  <button class="btn btn-success badge-light submit" type="submit">Filter date</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
               </div>
            </div>
         </div>
      </div>
   </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/reports/overview/incomesummary.blade.php ENDPATH**/ ?>