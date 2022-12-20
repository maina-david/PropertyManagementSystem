<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Credit Notes <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
         <li class="breadcrumb-item"><a href="j<?php echo route('property.creditnote.index',$property->id); ?>">Credit Notes</a></li>
         <li class="breadcrumb-item active"><a href="<?php echo route('property.creditnote.index',$property->id); ?>">Index</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> <?php echo $property->title; ?> | Credit Notes</h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12 mt-2 mb-2">
            <a href="<?php echo route('property.creditnote.create',$property->id); ?>" class="btn btn-primary"><i class="fal fa-plus-circle"></i> Add Credit Note</a>
         </div>
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Number</th>
                           <th>Tenant</th>
                           <th>Reference #</th>
                           <th>Amount</th>
                           <th>Balance</th>
                           <th>Status</th>
                           <th>Credit date</th>
                           <th width="12%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $creditnotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr role="row" class="odd">
                              <td><?php echo e($crt+1); ?></td>
                              <td>
                                 <b><?php echo $v->creditnote_prefix; ?><?php echo $v->creditnote_number; ?></b>
                              </td>
                              <td>
                                 <?php echo $v->tenant_name; ?>

                              </td>
                              <td class="text-uppercase font-weight-bold">
                                 <?php if($v->title != ""): ?>
                                    <?php echo $v->title; ?><br>
                                 <?php endif; ?>
                                 <?php echo $v->reference_number; ?>

                              </td>
                              <td><?php echo $v->symbol; ?><?php echo number_format($v->total); ?> </td>
                              <td><?php echo $v->symbol; ?><?php echo number_format($v->balance); ?> </td>
                              <td>
                                 <span class="badge <?php echo $v->statusName; ?>">
                                    <?php echo ucfirst($v->statusName); ?>

                                 </span>
                              </td>
                              <td>
                                 <?php echo date('M j, Y',strtotime($v->creditnote_date)); ?>

                              </td>
                              <td>
                                 <a href="<?php echo e(route('property.creditnote.show',[$property->id,$v->creditnoteID])); ?>" class="btn btn-sm btn-warning"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                 <?php if($v->paymentID == ""): ?>
                                    <a href="<?php echo route('property.creditnote.edit',[$property->id,$v->creditnoteID]); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                 <?php endif; ?>
                                 <a href="<?php echo route('finance.creditnote.delete', $v->creditnoteID); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash-alt"></i></a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/creditnote/index.blade.php ENDPATH**/ ?>