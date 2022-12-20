<div class="row mt-2 mb-2">
    <div class="col-md-12">
       <a href="#" class="btn btn-pink" data-toggle="modal" data-target="#add-note"> Add Note</a>
    </div>
 </div>
 <?php $__currentLoopData = $notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <div class="card">
      <div class="card-header"><?php echo $note->subject; ?></div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-1">
               <?php if(Wingu::check_user($note->created_by) == 1): ?>
                  <img src="https://ui-avatars.com/api/?name=<?php echo Wingu::user($note->created_by)->name; ?>&rounded=true&size=32" alt="">
               <?php else: ?> 
                  <img src="https://ui-avatars.com/api/?name=No User&rounded=true&size=32" alt="">
               <?php endif; ?>
            </div>
            <div class="col-md-11">
               <?php echo $note->note; ?> 
            </div> 
         </div>
      </div>
      <div class="card-footer text-muted">
         <div class="row">
            <div class="col-md-8">
               <?php if($note->created_by != ""): ?><b>Added by</b> <a href="#"><?php if(Wingu::check_user($note->created_by) == 1): ?><?php echo Wingu::user($note->created_by)->name; ?><?php else: ?> Unknown User <?php endif; ?></a><?php endif; ?> • <b>at</b> <a href="#"><?php echo date('F d, Y', strtotime($note->created_at)); ?> @ <?php echo date('g:i a', strtotime($note->created_at)); ?></a>     
            </div>
            <div class="col-md-4">
               <a href="<?php echo route('crm.customer.notes.delete', $note->id); ?>" class="btn btn-sm btn-danger float-right delete"><i class="fas fa-trash"></i> Delete</a>
               <a href="#" data-toggle="modal" data-target="#edit-note-<?php echo $note->id; ?>" class="btn btn-sm float-right mr-2 btn-primary"><i class="fas fa-edit"></i> Edit</i></a>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="edit-note-<?php echo $note->id; ?>">
      <div class="modal-dialog modal-lg">
         <?php echo Form::model($note, ['route' => ['finance.customer.notes.update', $note->id], 'method'=>'post']); ?>

            <?php echo csrf_field(); ?>
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title"> Update Note</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="">Subject</label>
                           <?php echo Form::text('subject', null, array('class' => 'form-control text-danger', 'required' => '')); ?>

                           <input type="hidden" name="customerID" value="<?php echo $customerID; ?>" required>
                        </div>                       
                        <div class="form-group required">
                        <label for="" class="text-danger">Note</label>
                        <?php echo Form::textarea('note', null, array('class' => 'form-control ckeditor', 'required' => '')); ?>

                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <center>
                     <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update note </button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
                  </center>
               </div>
            </div>
         <?php echo Form::close(); ?>

      </div>
   </div>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="row mt-2">
   <div class="col-md-12">
      <?php if($notes->lastPage() > 1): ?>
         <nav aria-label="...">
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="<?php echo e($notes->url(1)); ?>">Previous</a>
               </li>
               <?php for($i = 1; $i <= $notes->lastPage(); $i++): ?>
                  <li class="page-item <?php echo e(($notes->currentPage() == $i) ? 'active' : ''); ?>">
                     <a class="page-link" href="<?php echo e($notes->url($i)); ?>">
                           <?php echo e($i); ?>

                        <span class="sr-only">(current)</span>
                     </a>
                  </li>
               <?php endfor; ?>
               <li class="page-item">
                  <a class="page-link" href="<?php echo e($notes->url($notes->currentPage()+1)); ?>">Next</a>
               </li>
            </ul>
         </nav>
      <?php endif; ?>
   </div>
</div>

<div class="modal fade" id="add-note">
   <div class="modal-dialog modal-lg">
      <form action="<?php echo route('crm.customer.notes.store'); ?>" method="post">
         <?php echo csrf_field(); ?>
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title"> New Note</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group form-group-default">
                        <label for="">Subject</label>
                        <?php echo Form::text('subject', null, array('class' => 'form-control text-danger', 'placeholder' => 'Enter subject', 'required' => '')); ?>

                        <input type="hidden" name="customerID" value="<?php echo $customerID; ?>" required>
                     </div>
                     <div class="form-group">
                     <label for="" class="text-danger">Note</label>
                     <?php echo Form::textarea('note', null, array('class' => 'form-control ckeditor', 'required' => '')); ?>

                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="10%">
               </center>
            </div>
         </div>
      </form>
   </div>
</div><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/customers/notes.blade.php ENDPATH**/ ?>