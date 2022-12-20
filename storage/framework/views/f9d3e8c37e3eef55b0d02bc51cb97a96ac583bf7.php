<div class="col-md-3">
   <div class="list-group">
      <a href="<?php echo route('property.income.category'); ?>" class="list-group-item <?php echo e(Nav::isResource('income')); ?>">
         <i class="fal fa-usd-circle"></i> Income Categories
      </a>
      <a href="<?php echo route('property.expense.category.index'); ?>" class="list-group-item <?php echo e(Nav::isResource('expense')); ?>">
         <i class="fal fa-credit-card"></i> Expense Categories
      </a>
      <a href="<?php echo route('property.taxes'); ?>" class="list-group-item <?php echo e(Nav::isResource('taxes')); ?>">
         <i class="fal fa-balance-scale-left"></i> Tax Rates
      </a>
      <a href="<?php echo route('property.payment.method'); ?>" class="list-group-item <?php echo e(Nav::isResource('method')); ?>">
         <i class="fab fa-amazon-pay"></i> Payment Modes
      </a>
      <a href="<?php echo route('property.utilities'); ?>" class="list-group-item <?php echo e(Nav::isResource('utilities')); ?>">
         <i class="fal fa-outlet"></i> utilities
      </a>
   </div>
</div>
<?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/settings/_settings_nav.blade.php ENDPATH**/ ?>