<div class="modal fade" id="addpayment" tabindex="-1" role="dialog" aria-labelledby="addpayment" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form id="paymentForm" action="javascript:void(0)" autocomplete="off">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addpayment">Add Payment Method</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               @csrf
               <div class="form-group">
                  <label for="">Payment Name</label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Enter name">
               </div>
            </div>	
            <div class="modal-footer">
               <button type="submit" id="saveMethod" class="btn btn-success">Add Method</button>
               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%" style="display: none">
            </div>
         </div>
      </form>
   </div>
 </div>