<?php $__env->startSection('title','All Quotes'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="pull-right">
         <?php if (app('laratrust')->isAbleTo('create-quotes')) : ?>
            <?php if(Finance::count_quote() != Wingu::plan()->quotes && Finance::count_quote() < Wingu::plan()->quotes): ?>
               <a href="<?php echo route('finance.quotes.create'); ?>" class="btn btn-pink"><i class="fal fa-plus-circle"></i> New Quote</a>
            <?php endif; ?>
         <?php endif; // app('laratrust')->permission ?>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-alt"></i> All Quotes</h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Title</th>
                     <th>Customer</th>
                     <th>Reference #</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th>Number</th>
                     <th>Title</th>
                     <th>Customer</th>
                     <th>Reference #</th>
                     <th>Amount</th>
                     <th>Status</th>
                     <th>Date</th>
                     <th width="10%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crt => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr role="row" class="odd">
                        <td><?php echo e($crt+1); ?></td>
                        <td>
                            <b><?php echo $v->prefix; ?><?php echo $v->quote_number; ?></b>
                        </td>
                        <td>
                            <?php echo $v->subject; ?>

                        </td>
                        <td>
                           <?php echo $v->customer_name; ?>

                        </td>
                        <td class="text-uppercase font-weight-bold">
                           <?php echo $v->reff; ?>

                        </td>
                        <td>
                           <?php if($v->total != ""): ?> 
                              <b><?php echo $v->symbol; ?><?php echo number_format($v->total,2); ?></b>
                           <?php endif; ?>
                        </td>
                        <td><span class="badge <?php echo $v->name; ?>"><?php echo ucfirst($v->name); ?></span></td>
                        <td>
                            <?php echo date('M j, Y',strtotime($v->quote_date)); ?>

                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo e(route('finance.quotes.show', $v->quotesID)); ?>"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <?php if($v->qstatus != 13): ?>
                                 <li><a href="<?php echo route('finance.quotes.edit', $v->quotesID); ?>"><i class="fas fa-edit"></i> Edit</a></li>
                                 <?php endif; ?>
                                 <li><a href="<?php echo route('finance.quotes.delete', $v->quotesID); ?>" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/quotes/index.blade.php ENDPATH**/ ?>