<?php $__env->startSection('title','Expense Summary | Report'); ?>

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
         <li class="breadcrumb-item active">Expense Summary</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Expense Summary</h1> 
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
                  <a href="<?php echo route('finance.report.expensesummary.extract',[$to,$from]); ?>" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
                     <i class="fal fa-file-pdf t-plus-1 fa-fw fa-lg"></i> Export as PDF
                  </a>
                  <a href="<?php echo route('finance.report.expensesummary.extract',[$to,$from]); ?>" target="_blank" class="btn btn-sm btn-pink m-b-10 p-l-5">
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
                              <h4>Expense Summary</h4> 
                              <h5><span class="text-primary">From </span><?php echo date('F j, Y', strtotime($from) ); ?> <span class="text-primary">To</span> <?php echo date('F j, Y', strtotime($to) ); ?> </h5> 
                           </div>  
                           <div class="reports-table-wrapper fill-container table-container"> 
                              <table class="table zi-table financial-comparison table-no-border">
                                 <thead>
                                    <tr class="rep-fin-th"> 
                                       <th class="text-left"><h4>Expense</h4></th> 
                                       <th class="text-right"><h4>Total</h4></th>  
                                    </tr>
                                 </thead> 
                                 <tbody>  
                                    <?php $__currentLoopData = $expenseCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if(Finance::check_expense_per_category_by_period($expCat->id,$from,$to) != 0): ?>
                                          <?php $__currentLoopData = Finance::expense_per_category($expCat->id,$from,$to); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <tr class=" balance-tr">
                                                <td><?php echo $expCat->category_name; ?></td>  
                                                <td class="text-right"><?php echo $business->code; ?> <?php echo number_format(Finance::expense_per_category_sum($expCat->id,$from,$to)); ?></td>  
                                             </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                       <td><b>Total Expense</b></td>   
                                       <td class="text-right"><b><?php echo $business->code; ?> <?php echo number_format($expense); ?></b></td>  
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
    <form action="<?php echo route('finance.report.expensesummary'); ?>" method="GET" autocomplete="off">
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
                     <?php echo Form::text('from',null,['class'=>'form-control datepicker','placeholder' => 'choose date']); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="">To</label>
                     <?php echo Form::text('to',null,['class'=>'form-control datepicker','placeholder' => 'choose date']); ?>

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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/reports/overview/expensesummery.blade.php ENDPATH**/ ?>