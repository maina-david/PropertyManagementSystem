<?php $__env->startSection('title'); ?> Payments | <?php echo $property->title; ?>  <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.show',$property->id); ?>"><?php echo $property->title; ?></a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('property.payments',$property->id); ?>">Payments</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">All</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | Payments</h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12">
            <a href="<?php echo route('property.payments.create',$propertyID); ?>" class="btn btn-primary pull-right"><i class="fal fa-plus-circle"></i> Add Payment</a>
         </div>
         <div class="col-md-12 mt-1">   
            <div class="panel">
               <div class="panel-heading"><b>Payments</b></div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr role="row">
                           <th width="1%">#</th>
                           <th width="10%">Date</th>
                           <th width="14%">Reference</th>
                           <th>Tenant</th>
                           <th width="10%">Invoice</th>
                           <th>Paid via</th>
                           <th width="14%">Paid</th>
                           <th width="12%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr role="row" class="odd">
                              <td><?php echo $count++; ?></td>
                              <td>
                                 <?php if($pay->payment_date != ""): ?>
                                    <?php echo date('d M, Y',strtotime($pay->payment_date)); ?>

                                 <?php endif; ?>
                              </td>
                              <td><p class="font-weight-bold"><?php echo $pay->reference_number; ?></p></td>
                              <td>
                                 <?php echo $pay->tenant_name; ?>               
                                 <?php if($property->property_type == 2 or $property->property_type == 4): ?>      
                                    <?php if(Property::check_property_unit($property->id,$pay->unit) == 1): ?>
                                       <br> <span class="text-primary"><b>Unit :</b> <?php echo Property::property_unit($property->id,$pay->unit)->serial; ?></span>
                                    <?php endif; ?>
                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php echo $pay->invoice_prefix; ?><?php echo $pay->invoice_number; ?>

                              </td>
                              <td>
                                 <?php if(Finance::check_payment_method($pay->payment_method) == 1): ?>
                                    <?php echo Finance::payment_method($pay->payment_method)->name; ?>

                                 <?php else: ?> 
                                    Not defined
                                 <?php endif; ?>
                              </td>
                              <td><b><?php echo $business->code; ?> <?php echo number_format($pay->amount); ?></b></td>
                              <td>
                                 <?php if (app('laratrust')->isAbleTo('read-payments')) : ?>
                                    <a href="<?php echo route('property.payments.show',[$property->id,$pay->paymentID]); ?>" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                                 <?php endif; // app('laratrust')->permission ?>
                                 <?php if (app('laratrust')->isAbleTo('update-payments')) : ?>
                                    <a href="<?php echo route('property.payments.edit',[$property->id,$pay->paymentID]); ?>" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                 <?php endif; // app('laratrust')->permission ?>                       
                                 <?php if (app('laratrust')->isAbleTo('delete-payments')) : ?>
                                    <a href="<?php echo route('property.payments.delete',[$property->id,$pay->paymentID]); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                                 <?php endif; // app('laratrust')->permission ?>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/payments/index.blade.php ENDPATH**/ ?>