<div class="row mt-3">
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">All Plans</h4>
      </div>
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th> Created On</th>
                  <th> Activated On</th>
                  <th> Subscription#</th>
                  <th> Customer Name</th>
                  <th> Plan Name</th>
                  <th> Status</th>
                  <th> Amount</th>
                  <th> Last Billed On</th>
                  <th> Next Billing On</th>
                  <th width="9%">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                     <td><?php echo $count++; ?></td>
                     <td><?php echo date('d M, Y', strtotime($subscription->created_at)); ?></td>
                     <td>
                        <?php if($subscription->starts_on != ""): ?><?php echo date('d M, Y', strtotime($subscription->starts_on)); ?><?php endif; ?>
                     </td>
                     <td>
                        <b><?php echo $subscription->prefix; ?><?php echo $subscription->subscription_number; ?></b>
                     </td>
                     <td><?php echo $subscription->customer_name; ?></td>
                     <td><?php echo $subscription->product_name; ?></td>
                     <td>
                        <?php if($subscription->status != ""): ?>
                           <span class="badge <?php echo $subscription->statusName; ?>"><?php echo $subscription->statusName; ?></span>
                        <?php endif; ?>
                     </td>
                     <td>
                        <b><?php echo $subscription->code; ?> <?php echo number_format($subscription->amount); ?></b>
                     </td>
                     <td>
                        <?php if($subscription->last_billing): ?>
                           <?php echo date('d M, Y', strtotime($subscription->last_billing)); ?>

                        <?php endif; ?>
                     </td>
                     <td>
                        <?php if($subscription->next_billing): ?>
                           <?php echo date('d M, Y', strtotime($subscription->next_billing)); ?>

                        <?php endif; ?>
                     </td>
                     <td>
                        <?php if (app('laratrust')->isAbleTo('read-subscription')) : ?>
                           <a href="<?php echo route('subscriptions.show',$subscription->subscriptionID); ?>" target="_blank" class="btn btn-sm btn-pink"><i class="fal fa-eye"></i></a>
                        <?php endif; // app('laratrust')->permission ?>
                     </td>
                  </tr>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
         </table>
      </div>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/contacts/subscriptions.blade.php ENDPATH**/ ?>