<!-- expence category -->
<div class="modal fade" id="addSupplier" tabindex="-1" role="dialog" aria-labelledby="addSupplier" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="supplierForm" action="javascript:void(0)" autocomplete="off">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addSupplier">Add Supplier</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="form-group">
                  <label for="">Supplier Name</label>
                  <input type="text" name="name" class="form-control" id="supplierName" placeholder="Enter name" required>
               </div>
            </div>	
            <div class="modal-footer">
               <button type="submit" class="btn" id="saveSupplier" btn-success">Save changes</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
            </div>
         </div>
      </form>
   </div>
</div>