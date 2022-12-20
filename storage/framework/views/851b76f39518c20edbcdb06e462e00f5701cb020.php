<?php $__env->startSection('title','Settings | Payment Method'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Property</a></li>
         <li class="breadcrumb-item active">Settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-tools"></i> Settings | Payment Method</h1>
      <div class="row">
         <?php echo $__env->make('app.property.settings._settings_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12 mb-3">
                  <a class="btn btn-danger float-right" href="#add-mode" data-toggle="modal"><i class="fal fa-plus-circle"></i> Add Payment Method</a>
               </div>
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <table id="example5" class="table table-striped table-bordered">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Title</th>
                                 <th>Description</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </thead>
                           <tfoot>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Title</th>
                                 <th>Description</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </tfoot>
                           <tbody>
                              <?php $__currentLoopData = $defaultMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $default): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $defaultcount++; ?></td>
                                    <td><?php echo $default->name; ?></td>
                                    <td><?php echo $default->description; ?></td>
                                    <td>

                                    </td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php $__currentLoopData = $modes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $defaultcount++; ?></td>
                                    <td><?php echo $mode->name; ?></td>
                                    <td><?php echo $mode->description; ?></td>
                                    <td>
                                       <a href="#modal-dialog<?php echo $mode->id; ?>" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fas fa-edit"></i> Edit</a>
                                       <a href="<?php echo route('property.payment.method.delete', $mode->id); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                                    </td>
                                 </tr>
                                 <!-- #modal-dialog -->
                                 <div class="modal fade" id="modal-dialog<?php echo $mode->id; ?>">
                                    <div class="modal-dialog">
                                       <?php echo Form::model($mode, ['route' => ['property.payment.method.update',$mode->id], 'method'=>'post',]); ?>

                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <h4 class="modal-title">Update Payment Method</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                             </div>
                                             <div class="modal-body">
                                                <?php echo csrf_field(); ?>

                                                <div class="form-group">
                                                   <label for="">Method Name</label>
                                                   <?php echo Form::text('name', null, array('class' => 'form-control', 'required' => '')); ?>

                                                </div>
                                                <div class="form-group">
                                                   <label for="">Descriptions</label>
                                                   <?php echo Form::textarea('description', null, array('class' => 'form-control')); ?>

                                                </div>
                                             </div>
                                             <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Update Method</button>
                                                <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                                             </div>
                                          </div>
                                       <?php echo Form::close(); ?>

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
      <?php echo Form::open(array('route' => 'property.payment.method.store','enctype'=>'multipart/form-data','method'=>'post' )); ?>

         <?php echo csrf_field(); ?>
         <div class="modal fade" id="add-mode">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <h4 class="modal-title">Add payment Method</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Method name', 'Method name', array('class'=>'control-label text-danger')); ?>

                        <?php echo Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Method Name', 'required' =>'' )); ?>

                     </div>
                     <div class="form-group">
                        <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                        <?php echo Form::textarea('description', null, array('class' => 'form-control', 'size' => '6x10', 'placeholder' => 'Description')); ?>

                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-danger submit"><i class="fas fa-save"></i> Submit Information</button>
                     <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="Loader" width="15%">
                  </div>
               </div>
            </div>
         </div>
      <?php echo Form::close(); ?>

   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/settings/paymentmethod/index.blade.php ENDPATH**/ ?>