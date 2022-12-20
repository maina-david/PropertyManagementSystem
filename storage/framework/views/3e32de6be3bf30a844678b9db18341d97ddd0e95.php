<!-- bank account -->
<div class="modal fade" id="addExpressCustomer" tabindex="-1" role="dialog" aria-labelledby="bankandcash" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="expressCustomerForm" action="javascript:void(0)">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addExpressCustomer">Add Customer</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body"> 
               <?php echo csrf_field(); ?>
               <div class="form-group">
                  <label for="">Name</label>
                  <input type="text" name="customer_name" class="form-control" id="customerName" placeholder="Enter name" required>
               </div>
               <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" name="email" class="form-control" id="customerEmail" placeholder="Enter Email">
               </div>
               <div class="form-group">
                  <label for="">Phone Number</label>
                  <input type="text" name="phone_number" class="form-control" id="customerPhonenumber" placeholder="Enter phone number" required>
               </div>
               
            </div>	
            <div class="modal-footer">
               <button type="submit" id="saveExpressCustomer" class="btn btn-success">Add Customer</button>
               
            </div>
         </div>
      </form>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/contacts/express.blade.php ENDPATH**/ ?>