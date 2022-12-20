<?php $__env->startSection('title','Currency Settings'); ?>

<?php $__env->startSection('stylesheet'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item active">Currency</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-money-bill-wave"></i> Currency Settings</h1>
      <?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <?php echo $__env->make('app.finance.settings._nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        
                        <table id="data-table-default" class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Name</th>
                                 <th>Code</th>
                                 <th>symbol</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </thead>
                           <tfoot>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Name</th>
                                 <th>Code</th>
                                 <th>symbol</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </tfoot>
                           <tbody>
                              <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $currency->currency_name; ?></td>
                                    <td><?php echo $currency->code; ?></td>
                                    <td><?php echo $currency->symbol; ?></td>
                                    <td>
                                       <a href="#modal-dialog<?php echo $currency->id; ?>" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fas fa-edit"></i> Edit</a>
                                       <a href="<?php echo route('finance.settings.currency.delete', $currency->id); ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a></td>
                                 </tr>
                                    <!-- #modal-dialog -->
                                    <div class="modal fade" id="modal-dialog<?php echo $currency->id; ?>">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <h4 class="modal-title">Update Currency</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                             </div>
                                             <div class="modal-body">
                                                <?php echo Form::model($currency, ['route' => ['finance.settings.currency.update',$currency->id], 'method'=>'post',]); ?>

                                                   <?php echo csrf_field(); ?>

                                                   <div class="form-group">
                                                      <label for="">Currency Name</label>
                                                      <?php echo Form::text('currency_name', null, array('class' => 'form-control', 'required' => '')); ?>

                                                   </div>
                                                   <div class="form-group">
                                                      <label for="">Currency Code</label>
                                                      <?php echo Form::text('code', null, array('class' => 'form-control', 'required' => '')); ?>

                                                   </div>
                                                   <div class="form-group">
                                                      <label for="">Currency Symbol</label>
                                                      <?php echo Form::text('symbol', null, array('class' => 'form-control', 'required' => '')); ?>

                                                   </div>
                                                   <div class="form-group">
                                                      <center><button type="submit" class="btn btn-primary submit">Update Currency</button></center>
                                                   </div>
                                                <?php echo Form::close(); ?>

                                             </div>
                                             <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- #modal-without-animation -->
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="add-currency">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Update Status</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <form action="<?php echo route('finance.settings.currency.store'); ?>" method="POST">
                  <?php echo csrf_field(); ?>
                  <div class="form-group">
                     <label for="">Currency Name</label>
                     <input type="text" class="form-control" name="currency_name" required>
                  </div>
                  <div class="form-group">
                     <label for="">Currency Code</label>
                     <input type="text" class="form-control" name="code" required>
                  </div>
                  <div class="form-group">
                     <label for="">Currency Symbol</label>
                     <input type="text" class="form-control" name="symbol" required>
                  </div>
                  <div class="form-group">
                     <center><button type="submit" class="btn btn-primary submit">Submit</button>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
               <a href="javascript:;" class="btn btn-success">Action</a>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/settings/currency/index.blade.php ENDPATH**/ ?>