<script>
   $(document).ready(function (){
      //bankaccount 
      $('#bankandcashForm').on('submit', function(e){
         var url = "<?php echo url('/'); ?>";
         e.preventDefault(); 
         $('#saveBankCash').hide();
         $(".saveBankCash-load").show();
         $.ajax({
            type:"POST", 
            url: url+"/finance/express/account/store",
            data:$('#bankandcashForm').serialize(),
            success:function(response){
               console.log(response)
               $('#bankandcash').modal('hide');
               $('#bankandcashForm')[0].reset();
               $('#saveBankCash').show();
               $(".saveBankCash-load").hide();
            },
            error: function(error){
               console.log(error)
               alert("Account not saved");               
               $('#bankandcash').modal('hide');
               $('#bankandcashForm')[0].reset();
               $('#saveBankCash').show();
               $(".saveBankCash-load").hide();
            }
         });
      });

      //expense category
      $('#expenseCategoryForm').on('submit', function(e){
         var url = "<?php echo url('/'); ?>";
         e.preventDefault();
         $('#savecategory').hide();
         $(".savecategory-load").show();
         $.ajax({
            type:"POST", 
            url: url+"/finance/express/expense/category/store",
            data:$('#expenseCategoryForm').serialize(),
            success:function(response){
               console.log(response)
               $('#expenceCategory').modal('hide');
               $('#expenseCategoryForm')[0].reset();
               $('#savecategory').show();
               $(".savecategory-load").hide();
            },
            error: function(error){
               console.log(error)
               alert("Category not saved");
               $('#expenseCategoryForm').modal('hide');
               $('#expenseCategoryForm')[0].reset();
               $('#savecategory').show();
               $(".savecategory-load").hide();
            }
         });
      });

      //tax reate
      $('#taxrateForm').on('submit', function(e){
         var url = "<?php echo url('/'); ?>";
         e.preventDefault();
         $('#saveRate').hide();
         $(".saveRate-load").show();
         $.ajax({ 
            type:"POST", 
            url: url+"/finance/taxes/express/store",
            data:$('#taxrateForm').serialize(),
            success:function(response){
               console.log(response)
               $('#taxRate').modal('hide');
               $('#taxrateForm')[0].reset();
               $('#saveRate').show();
               $(".saveRate-load").hide();
            },
            error: function(error){
               console.log(error)
               alert("Tax Rate not saved");
               $('#taxRate').modal('hide');
               $('#taxrateForm')[0].reset();
               $('#saveRate').show();
               $(".saveRate-load").hide();
            }
         });
      });

      //suppliers
      $('#supplierForm').on('submit', function(e){
         var url = "<?php echo url('/'); ?>";
         e.preventDefault();
         $('#saveSupplier').hide();
         $(".saveSupplier-load").show();
         $.ajax({
            type:"POST", 
            url: url+"/finance/express/supplier/save",
            data:$('#supplierForm').serialize(),
            success:function(response){
               console.log(response)
               $('#addSupplier').modal('hide');
               $('#supplierForm')[0].reset();
               $('#saveSupplier').show();
               $(".saveSupplier-load").hide();
            },
            error: function(error){
               console.log(error)
               alert("Category not saved");
               $('#addSupplier').modal('hide');
               $('#supplierForm')[0].reset();
               $('#saveSupplier').show();
               $(".saveSupplier-load").hide();
            }
         });
      });

      //method
      $('#paymentForm').on('submit', function(e){
         var url = "<?php echo url('/'); ?>";
         e.preventDefault();
         $('#saveMethod').hide();
         $(".saveMethod-load").show();
         $.ajax({
            type:"POST", 
            url: url+"/finance/express/payment/modes/store",
            data:$('#paymentForm').serialize(),
            success:function(response){
               console.log(response)
               $('#addpayment').modal('hide');
               $('#paymentForm')[0].reset();
               $('#saveMethod').show();
               $(".saveMethod-load").hide();
            },
            error: function(error){
               console.log(error)
               alert("Method not saved");
               $('#addpayment').modal('hide');
               $('#paymentForm')[0].reset();
               $('#saveMethod').show();
               $(".saveMethod-load").hide();
            }
         });
      });

      //method
      $('#expressCustomerForm').on('submit', function(e){
         var url = "<?php echo url('/'); ?>";
         e.preventDefault();
         $('#saveExpressCustomer').hide();
         $(".saveExpressCustomer-load").show();
         $.ajax({
            type:"POST", 
            url: url+"/finance/express/customer/create",
            data:$('#expressCustomerForm').serialize(),
            success:function(response){
               console.log(response)
               $('#addExpressCustomer').modal('hide');
               $('#expressCustomerForm')[0].reset();
               $('#saveExpressCustomer').show();
               $(".saveExpressCustomer-load").hide();
            },
            error: function(error){
               console.log(error)
               alert("Method not saved");
               $('#addExpressCustomer').modal('hide');
               $('#expressCustomerForm')[0].reset();
               $('#saveExpressCustomer').show(); 
               $(".saveExpressCustomer-load").hide();
            }
         });
      });

      //income category express
      $('#expressIncomeForm').on('submit', function(e){
         var url = "<?php echo url('/'); ?>";
         e.preventDefault();
         $('#saveExpressIncome').hide();
         $(".saveExpressIncome-load").show();
         $.ajax({
            type:"POST", 
            url: url+"/finance/express/income/category/create",
            data:$('#expressIncomeForm').serialize(),
            success:function(response){
               console.log(response)
               $('#addExpressIncome').modal('hide');
               $('#expressIncomeForm')[0].reset();
               $('#saveExpressIncome').show();
               $(".saveExpressIncome-load").hide();
            },
            error: function(error){
               console.log(error)
               alert("Method not saved");
               $('#addExpressIncome').modal('hide');
               $('#expressIncomeForm')[0].reset();
               $('#saveExpressIncome').show(); 
               $(".saveExpressIncome-load").hide();
            }
         });
      });
   });
</script>
<script>
   $(document).ready(function() {
      //bank account
      $('#selectAccount').select2({
         placeholder: "Choose account",
         ajax: {
            url: '<?php echo e(route("finance.bank.account.access")); ?>',
            dataType: 'json',
         },
      });

      //category
      $('#selectCategory').select2({
         placeholder: "Choose category",
         ajax: {
            url: '<?php echo e(route("finance.express.expense.category.list")); ?>',
            dataType: 'json',
         },
      });

      //tax rate
      $('#selectTax').select2({
         placeholder: "Choose tax rate",
         ajax: {
            url: '<?php echo e(route("finance.settings.taxes.express")); ?>',
            dataType: 'json',
         },
      });
      
      //supplier
      $('#selectSupplier').select2({
         placeholder: "Choose supplier",
         ajax: {
            url: '<?php echo e(route("finance.supplier.express.list")); ?>',
            dataType: 'json',
         },
      });

      //payment method
      $('#selectMethod').select2({
         placeholder: "Choose method",
         ajax: {
            url: '<?php echo e(route("finance.payment.mode.express")); ?>',
            dataType: 'json',
         },
      });

      //customer
      $('#getCustomers').select2({
         placeholder: "Choose customer",
         ajax: {
            url: '<?php echo e(route("finance.contact.express")); ?>',
            dataType: 'json',
         },
      });

      //express products
      $('#getExpressProducts').select2({
         placeholder: "Choose products",
         ajax: {
            url: '<?php echo e(route("finance.product.express.list")); ?>',
            dataType: 'json',
         },
      });

      //express products
      $('#getIncomeCategory').select2({
         placeholder: "Choose category",
         ajax: {
            url: '<?php echo e(route("finance.income.express.category")); ?>',
            dataType: 'json',
         },
      });
   });
</script><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/partials/_express_scripts.blade.php ENDPATH**/ ?>