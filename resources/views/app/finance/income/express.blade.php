<!-- bank account -->
<div class="modal fade" id="addExpressIncome" tabindex="-1" role="dialog" aria-labelledby="bankandcash" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="expressIncomeForm" action="javascript:void(0)">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addExpressIncome">Add Income Category</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="form-group">
                  <label for="">Title</label>
                  <input type="text" name="category_name" class="form-control" id="customerName" placeholder="Please enter name" required>
               </div>
            </div>	
            <div class="modal-footer">
               <button type="submit" id="saveExpressIncome" class="btn btn-success">Add Category</button>
               <img src="{!! url('/') !!}/public/backend/img/btn-loader.gif" class="saveExpressIncome-load none" alt="" width="15%">
            </div>
         </div>
      </form>
   </div>
</div>