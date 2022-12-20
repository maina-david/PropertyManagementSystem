<!-- expence category -->
<div class="modal fade" id="expenceCategory" tabindex="-1" role="dialog" aria-labelledby="expenceCategory" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="expenseCategoryForm" action="javascript:void(0)" autocomplete="off">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="expenceCategory">Add Expense Category</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="form-group">
                  <label for="">Category Name</label>
                  <input type="text" name="name" class="form-control" id="categoryName" placeholder="Please enter category" required>
               </div>
            </div>	
            <div class="modal-footer">
               <button type="submit" id="savecategory" class="btn btn-success">Save changes</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%" style="display: none">
            </div>
         </div>
      </form>
   </div>
</div>