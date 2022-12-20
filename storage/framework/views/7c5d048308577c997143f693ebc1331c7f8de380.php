<div class="col-md-3">
   <?php  
      $property = Wingu::get_account_module_details(1);
   ?>
   <div class="list-group">
      <a href="<?php echo route('settings.business.index'); ?>" class="list-group-item <?php echo e(Nav::isResource('business')); ?>">
         <i class="fal fa-globe"></i> Business Profile
      </a>
      <?php if (app('laratrust')->isAbleTo('create-invoices')) : ?>
         <a href="<?php echo route('finance.settings.invoice'); ?>" class="list-group-item <?php echo e(Nav::isResource('invoice')); ?>">
            <i class="fal fa-file-invoice-dollar"></i> Invoice
         </a>
      <?php endif; // app('laratrust')->permission ?>
      <?php if (app('laratrust')->isAbleTo('create-taxes')) : ?>
         <a href="<?php echo route('finance.settings.taxes'); ?>" class="list-group-item <?php echo e(Nav::isResource('taxes')); ?>">
            <i class="fal fa-coins"></i> Tax Rates
         </a>
      <?php endif; // app('laratrust')->permission ?>
      <?php if($property->module_status == 15 && $property->payment_status == 1): ?>
         <?php if (app('laratrust')->isAbleTo('create-incomecategory')) : ?>
            <a href="<?php echo route('finance.income.category'); ?>" class="list-group-item <?php echo e(Nav::isResource('income')); ?>">
               <i class="fal fa-money-bill-alt"></i> Income Categories
            </a>
         <?php endif; // app('laratrust')->permission ?>
         <?php if (app('laratrust')->isAbleTo('create-expensecategory')) : ?>
            <a href="<?php echo route('finance.expense.category.index'); ?>" class="list-group-item <?php echo e(Nav::isResource('expense')); ?>">
               <i class="fal fa-sitemap"></i> Expense Categories
            </a>
         <?php endif; // app('laratrust')->permission ?>
         <?php if(Wingu::check_plan_function(11,Wingu::business()->plan,1) == 1): ?>
            <?php if (app('laratrust')->isAbleTo('create-lpo')) : ?>
               <a href="<?php echo route('finance.settings.lpo'); ?>" class="list-group-item <?php echo e(Nav::isResource('lpo')); ?>">
                  <i class="fal fa-file-contract"></i> Purchase Order 
               </a>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>
         <?php if(Wingu::check_plan_function(9,Wingu::business()->plan,1) == 1): ?>
            <?php if (app('laratrust')->isAbleTo('create-quotes')) : ?>
               <a href="<?php echo route('finance.settings.quote'); ?>" class="list-group-item <?php echo e(Nav::isResource('quote')); ?>">
                  <i class="far fa-file-alt"></i> Quotes
               </a>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>
         <a href="<?php echo route('finance.settings.salesorders'); ?>" class="list-group-item <?php echo e(Nav::isResource('salesorders')); ?>">
            <i class="fal fa-cart-arrow-down"></i> Sales orders
         </a>
        
         <?php if(Wingu::check_plan_function(12,Wingu::business()->plan,1) == 1): ?>
            <?php if (app('laratrust')->isAbleTo('create-creditnote')) : ?>
               <a href="<?php echo route('finance.settings.creditnote'); ?>" class="list-group-item <?php echo e(Nav::isResource('creditnote')); ?>">
                  <i class="fal fa-credit-card"></i> Credit Note
               </a>
            <?php endif; // app('laratrust')->permission ?>
         <?php endif; ?>
         <?php if (app('laratrust')->isAbleTo('create-payments')) : ?>
            <a href="<?php echo route('finance.payment.mode'); ?>" class="list-group-item <?php echo e(Nav::isResource('mode')); ?>">
               <i class="fab fa-amazon-pay"></i> Payment Modes
            </a>
         <?php endif; // app('laratrust')->permission ?>
         
         
      <?php endif; ?>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/partials/_settings_nav.blade.php ENDPATH**/ ?>