<?php $__env->startSection('title','All Orders'); ?>



<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">Items</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.product.index'); ?>">e-Commerce</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.ecommerce.orders'); ?>">Orders</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">e-Commerce</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <thead>
                           <tr>
                              <th width="1%">#</th>
                              <th>OrderID</th>
                              <th>Cusomer</th>
                              <th>Total</th>
                              <th>Payment Type</th>
                              <th>Delivery Status</th>
                              <th>Payment Status</th>
                              <th>Order date</th>
                              <th width="10%">Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td><?php echo $count++; ?></td>
                                 <td><?php echo $order->serialNo; ?></td>
                                 <td><?php echo $order->customer_name; ?></td>
                                 <td><?php echo $order->code; ?> <?php echo number_format($order->total); ?></td>
                                 <td><?php echo $order->gateway_name; ?></td>
                                 <td><span class="badge <?php echo Limitless::status($order->delivery_status)->name; ?>"><?php echo Limitless::status($order->delivery_status)->name; ?></span></td>
                                 <td><span class="badge <?php echo Limitless::status($order->payment_status)->name; ?>"><?php echo Limitless::status($order->payment_status)->name; ?></span></td>
                                 <td><?php echo date('jS F, Y', strtotime($order->order_date)); ?></td>
                                 <td><a href="<?php echo route('finance.ecommerce.orders.view',$order->orderID); ?>" class="btn btn-pink btn-sm"><i class="fas fa-eye"></i> view order</a></td>
                              </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/products/orders/index.blade.php ENDPATH**/ ?>