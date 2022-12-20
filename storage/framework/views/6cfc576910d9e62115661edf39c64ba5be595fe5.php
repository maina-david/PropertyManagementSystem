<?php $__env->startSection('title','Profit and Loss | Report '); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

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

<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
			<li class="breadcrumb-item"><a href="#">Reports</a></li>
			<li class="breadcrumb-item active"><a href="javascript:void(0)">Profit and Loss</a></li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-building"></i> <?php echo $property->title; ?> | Reports | Profit and Loss</h1>
		<div class="row">
		   <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		   <div class="col-md-12">
		      <div class="row">
		         <div class="col-md-2"></div>
		         <div class="col-md-8">
		            <div class="row">
		               <div class="col-md-12">
		                  <a href="#" data-toggle="modal" data-target="#filter" target="_blank" class="btn btn-sm btn-danger m-b-10 p-l-5">
		                     <i class="fal fa-search"></i> Filter
		                  </a>
		                  <a href="<?php echo route('property.reports.profitandloss.generate',[$property->id,$to,$from]); ?>" target="_blank" class="btn btn-sm btn-danger m-b-10 p-l-5">
		                     <i class="fal fa-file-pdf t-plus-1 fa-fw fa-lg"></i> Export as PDF
		                  </a>
		                  <a href="<?php echo route('property.reports.profitandloss.generate',[$property->id,$to,$from]); ?>" target="_blank" class="btn btn-sm btn-danger m-b-10 p-l-5">
		                     <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
		                  </a>
		               </div>
		            </div>
		            <div class="row">
		               <div class="col-md-12">
		                  <div class="card mt-2">
		                     <div class="card-body">
		                        <div class="rep-container">
		                           <div class="page-header text-center">
		                              <h3><?php echo $business->name; ?></h3>
		                              <h4>Profit and Loss</h4>
		                              <h5><span class="text-primary">From </span><?php echo date('F j,Y', strtotime($from) ); ?> <span>To</span> <?php echo date('F j,Y', strtotime($to) ); ?> </h5>
		                           </div>
		                           <div class="reports-table-wrapper fill-container table-container">
		                              <table class="table zi-table financial-comparison table-no-border">
		                                 <thead>
		                                    <tr class="rep-fin-th">
		                                    <th class="text-left"><h3>Account</h3></th>
		                                    <th class="text-right"><h3>Total</h3></th>
		                                    </tr>
		                                 </thead>
		                                 <tbody>
		                                    <tr>
		                                       <td class="table-bg" colspan="2"><h4><b>Income</b></h4></td>
		                                    </tr>
		                                    <?php $__currentLoopData = $originalIncomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $originalCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                       <?php if(Property::check_invoice_in_category_by_period($property->id,$originalCategory->id,$from,$to) != 0): ?>
		                                          <?php $__currentLoopData = Property::invoices_per_income_category($property->id,$originalCategory->id,$from,$to); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                             <tr class=" balance-tr">
		                                                <td><?php echo $originalCategory->name; ?></td>
		                                                <td class="text-right"><?php echo $business->code; ?><?php echo number_format(Property::invoices_per_income_category_sum($property->id,$originalCategory->id,$from,$to)); ?></td>
		                                             </tr>
		                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                       <?php endif; ?>
		                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                    <?php $__currentLoopData = $incomeCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                       <?php if(Property::check_invoice_in_category_by_period($property->id,$category->id,$from,$to) != 0): ?>
		                                          <?php $__currentLoopData = Property::invoices_per_income_category($property->id,$category->id,$from,$to); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $xx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                             <tr class=" balance-tr">
		                                                <td><?php echo $category->name; ?></td>
		                                                <td class="text-right"><?php echo $business->code; ?><?php echo number_format(Property::invoices_per_income_category_sum($property->id,$category->id,$from,$to)); ?></td>
		                                             </tr>
		                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                       <?php endif; ?>
		                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                    <?php if($unCategorisedInvoicesCount != 0): ?>
		                                       <tr class=" balance-tr">
		                                          <td>Others</td>
		                                          <td class="text-right"><?php echo $business->code; ?><?php echo number_format($unCategorisedInvoicesSum); ?></td>
		                                       </tr>
		                                    <?php endif; ?>
		                                    <tr>
		                                       <td><b>Total Income</b></td>
		                                       <td class="text-right"><b><?php echo $business->code; ?><?php echo number_format($income); ?></b></td>
		                                    </tr>
		                                    <tr>
		                                       <td class="table-bg" colspan="2"><h4><b>Operating Expenses</b></h4></td>
		                                    </tr>
		                                    <?php $__currentLoopData = $expenseCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                       <?php if(Property::check_expense_per_category_by_period($property->id,$expCat->id,$from,$to) != 0): ?>
		                                          <?php $__currentLoopData = Property::expense_per_category($property->id,$expCat->id,$from,$to); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                             <tr class=" balance-tr">
		                                                <td><?php echo $expCat->category_name; ?></td>
		                                                <td class="text-right"><?php echo $business->code; ?><?php echo number_format(Property::expense_per_category_sum($property->id,$expCat->id,$from,$to)); ?></td>
		                                             </tr>
		                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                       <?php endif; ?>
		                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                    <tr>
		                                       <td><b>Total Expenses</b></td>
		                                       <td class="text-right"><b><?php echo $business->code; ?><?php echo number_format($expense); ?></b></td>
		                                    </tr>
		                                    <tr>
		                                       <td class="table-bg"><h4><b>Net Profit</b></h4></td>
		                                       <td class="table-bg text-right"><h4 class="text-pink"><b><?php echo $business->code; ?><?php echo number_format($income - $expense); ?></b></h4></td>
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
		   <form action="<?php echo route('property.reports.profitandloss',$property->id); ?>" method="GET" autocomplete="off">
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
		                     <?php echo Form::date('from',null,['class'=>'form-control','placeholder' => 'choose date']); ?>

		                  </div>
		                  <div class="form-group form-group-default">
		                     <label for="">To</label>
		                     <?php echo Form::date('to',null,['class'=>'form-control','placeholder' => 'choose date']); ?>

		                  </div>
		               </div>
		               <div class="modal-footer">
		                  <button class="btn btn-success badge-light submit" type="submit">Filter date</button>
		                  <img src="<?php echo url('/'); ?>/public/app/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
		               </div>
		            </div>
		         </div>
		      </div>
		   </form>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/reports/profitandloss.blade.php ENDPATH**/ ?>