<?php $__env->startSection('title'); ?><?php echo $page->title; ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('description'); ?><?php echo $page->meta_description; ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('keywords'); ?><?php echo $page->meta_tags; ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?><?php echo route('home.page'); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      td+td{
         text-align: center;
      }
   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div class="section-container head-section bg-white">
      <!-- BEGIN container -->
      <div class="container text-center mb-5">
         <center><h2><i class="fal fa-usd-circle fa-5x"></i></h2></center>
         <h2 class="mt-5 head-title">Simple Pricing.</h2>
      </div>
      <!-- END container -->
   </div>
   <div class="section-container">
      <div class="container">
         <ul class="pricing-table pricing-col-4">
            <?php $__currentLoopData = Limitless::get_all_plan(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <li <?php if($plan->id == 4): ?> class="highlight" <?php endif; ?>>
                  <div class="pricing-container">
                     <h3><?php echo $plan->title; ?></h3>
                     <div class="price">
                        <div class="price-figure">
                           <span class="price-number">$<?php echo number_format($plan->usd); ?></span>
                           <span class="price-tenure">per month</span>
                        </div>
                     </div>
                     <ul class="features">
                        <li><b><?php echo $plan->users; ?></b> Users</li>
                        <?php if($plan->id == 1 || $plan->id == 3): ?>
                           <li>Up to <b><?php echo $plan->projects; ?></b> Projects</li>
                           <li>Up to <b><?php echo $plan->invoices; ?></b> Invoices</li>
                        <?php else: ?> 
                           <li>Unlimited Projects</li>
                           <li>Unlimited Invoices</li>
                        <?php endif; ?>
                        <li>Custom Roles <b><?php echo $plan->roles; ?></b></li>
                     </ul>
                     <div class="footer">
                        <button type="button" class="btn btn-inverse btn-pink btn-block btn-primary" data-toggle="modal" data-target="#plan<?php echo $plan->id; ?>">
                           Subscribe
                        </button>                     
                     </div>
                  </div>
               </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </ul>
      </div>
   </div>
   <div class="section-container bg-white">
      <div class="container">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th class="" style="padding-left: 10px !important;text-align: center;"></th>
                  <th class="bg-grey">Growth</th>
                  <th class="bg-grey">Starter</th>
                  <th class="bg-grey">Professional</th>
                  <th class="bg-grey">Enterprise</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>Users</td>
                  <td><b>Up to 2</b></td>
                  <td><b>Up to 3</b></td>
                  <td><b>Up to 5</b></td>
                  <td><b>Up to 8</b></td>
               </tr>               
               <tr>
                  <td>Contacts</td>
                  <td><b>Up to 100</b></td>
                  <td><b>Up to 200</b></td>
                  <td><b>Up to 300</b></td>
                  <td><b>Up to 400</b></td>
               </tr>
               <tr>
                  <td>Custom Roles </td>
                  <td><b>Up to 2</b></td>
                  <td><b>Up to 4</b></td>
                  <td><b>Up to 8</b></td>
                  <td><b>Up to 16</b></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Finance</span></th>
               </tr>
               <tr>
                  <td>Invoices</td>
                  <td><b>Up to 30</b></td>
                  <td><b>Up to 60</b></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Inventory Management</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>   
               <tr>
                  <td>Products</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Human resource management </span></th>
               </tr>
               <tr>
                  <td>Employees </td>
                  <td><b>Up to 7</b></td>
                  <td><b>Up to 15</b></td>
                  <td><b>Up to 25</b></td>
                  <td><b>Up to 50</b></td>
               </tr>
               <tr>
                  <td>Organizations</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr> 
               <tr>
                  <td>Leave Management</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Payroll</td>
                  <td><b></b></td>
                  <td><b>Coming Soon!</b></td>
                  <td><b>Coming Soon!</b></td>
                  <td><b>Coming Soon!</b></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Customer Relationship Management</span></th>
               </tr>
               <tr>
                  <td>Contact Management </td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Project Management</span></th>
               </tr>
               <tr>
                  <td>Projects</td>
                  <td><b>Up to 20</b></td>
                  <td><b>Up to 30</b></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Tasks</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Task Groups</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Lists & Tags</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Notes</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Collaboration </td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Subscription Management</span></th>
               </tr>
               <tr>
                  <td>Products</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Asset  Management</span></th>
               </tr>
               <tr>
                  <td>Inventory Management</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               
            </tbody>
         </table>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/wingu/hold/price.blade.php ENDPATH**/ ?>