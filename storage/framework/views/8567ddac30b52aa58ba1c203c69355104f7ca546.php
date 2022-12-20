<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Utility Billing | Calculate Bills  <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?>  
 
<?php $__env->startSection('content'); ?>
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="<?php echo route('property.index'); ?>">Property</a></li>
      <li class="breadcrumb-item"><a href="#">Accounting</a></li>
      <li class="breadcrumb-item active"><a href="#">Utility Billing</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Utility Billing | Calculate Bills </h1>
   
   <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12">
            <h3>
               Utility Bills<br>  
               From: <?php echo date('jS F, Y', strtotime($from)); ?><br>
               To: <?php echo date('jS F, Y', strtotime($to)); ?>

            </h3>
         </div>
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Tenant</th>
                           <th>Utility</th>
                           <th>Pre </th>
                           <th>Cur </th>
                           <th>Cons </th>
                           <th>price</th>
                           <th>Amount</th>
                           <th width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $utilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($item->unit_price == 0 || $item->unit_price ==  ""): ?>
                              <form action="<?php echo route('property.calculate.utility.consumption',[$propertyID,$item->invoiceProductID]); ?>" method="POST">
                           <?php else: ?>
                              <form action="<?php echo route('property.update.utility.consumption',[$propertyID,$item->invoiceProductID]); ?>" method="POST">
                           <?php endif; ?>
                              <?php echo csrf_field(); ?>
                              <input type="hidden" class="form-control" name="invoiceID" value="<?php echo $item->invoice_id; ?>" required>
                              <tr>
                                 <td><?php echo $count++; ?></td>
                                 <td>
                                    <?php echo $item->tenant_name; ?><br>
                                    <b>Unit#: <?php echo $item->serial; ?></b>
                                 </td>
                                 <td><?php echo $item->utilityName; ?></td>
                                 <td>
                                    <?php if($item->current_units == "" || $item->current_units == 0): ?>
                                       <input type="text" value="<?php echo $item->last_reading; ?>" class="form-control" name="previous_reading" readonly>
                                    <?php else: ?> 
                                       <input type="text" value="<?php echo $item->previous_reading; ?>" class="form-control" name="previous_reading" readonly>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <input type="text"  name="current" step="0.01" min="<?php echo $item->last_reading; ?>" class="form-control" value="<?php echo $item->current_units; ?> ">
                                 </td>
                                 <td> 
                                    <?php 
                                       $consumption = $item->current_units - $item->previous_reading;

                                       if($consumption < 0){
                                          echo 0;
                                       }else{
                                          echo $consumption;
                                       }
                                    ?>
                                 </td>
                                 <td><input type="text" class="form-control" name="price" value="<?php if($item->unit_price == 0 || $item->unit_price ==  "" ): ?> <?php echo $item->price; ?> <?php else: ?> <?php echo $item->unit_price; ?> <?php endif; ?> "></td>
                                 <td>
                                    <?php 
                                       $answer = $item->unit_price * $consumption;                                    
                                    ?>
                                    <?php if($answer > 0): ?>
                                       <?php echo $answer; ?>

                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <?php if($item->unit_price == 0 || $item->unit_price ==  ""): ?>
                                       <button class="btn btn-warning btn-sm"><i class="fas fa-calculator"></i> Calculate</button>
                                    <?php else: ?>
                                       <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</button>
                                    <?php endif; ?>     
                                 </td>
                              </tr>
                           </form>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/accounting/utility/record_reading.blade.php ENDPATH**/ ?>