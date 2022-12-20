<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Documents <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Documents</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Documents</h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12">
            <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row row-space-10 m-b-20">
               <div class="col-md-12 mb-3">
                  <a href="" class="btn btn-warning" data-toggle="modal" data-target="#addImage"><i class="fal fa-images"></i> Add Documents</a>
               </div>
               <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-4">
                     <!-- begin widget-list -->
                     <div class="widget-list widget-list-rounded mb-2">
                        <!-- begin widget-list-item -->
                        <div class="widget-list-item">
                           <div class="widget-list-media">
                              <?php if(Helper::like_match('%image%',$document->file_mime)): ?>
                                 <i class="fas fa-file-image fa-3x"></i>
                              <?php elseif(Helper::like_match('%pdf%',$document->file_mime)): ?>
                                 <i class="fas fa-file-pdf fa-3x"></i>
                              <?php elseif(Helper::like_match('%word%',$document->file_mime)): ?>
                                 <i class="fas fa-file-word fa-3x"></i>
                              <?php elseif(Helper::like_match('%zip%',$document->file_mime)): ?>
                                 <i class="fas fa-file-archive fa-3x"></i>
                              <?php elseif(Helper::like_match('%excel%',$document->file_mime)): ?>
                                 <i class="fas fa-file-excel fa-3x"></i>
                              <?php elseif(Helper::like_match('%powerpoint%',$document->file_mime)): ?>
                                 <i class="fas fa-file-powerpoint fa-3x"></i>
                              <?php elseif(Helper::like_match('%application%',$document->file_mime)): ?>
                                 <i class="far fa-file-code fa-3x"></i>
                              <?php else: ?>
                                 <i class="far fa-file fa-3x"></i>
                              <?php endif; ?>
                           </div>
                           <div class="widget-list-content">
                              <h4 class="widget-list-title font-weight-bold"><?php echo $document->name; ?></h4>
                              <p class="widget-list-desc mt-1">
                                 <b>File Type :</b> <?php echo $document->file_mime; ?><br>
                                 <b>File Size :</b> <?php echo round($document->file_size / 1000000, 2); ?> mb<br>
                                 <b>Created at :</b> <?php echo date('F d, Y', strtotime($document->created_at)); ?><br>
                              </p>
                           </div>
                           <div class="widget-list-action">
                              <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                              <i class="fa fa-ellipsis-h f-s-14"></i>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-right">
                                 <li><a href="#edit<?php echo $document->id; ?>" data-toggle="modal">Edit</a></li>
                                 
                                 <li><a href="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'. $property->property_code .'/documents/'.$document->file_name); ?>" target="_blank">View document</a></li>
                                 <li><a href="<?php echo route('property.documents.delete',[$property->id,$document->id]); ?>" class="delete">Delete</a></li>
                              </ul>
                           </div>
                        </div>
                        <!-- end widget-list-item -->
                     </div>
                     <!-- end widget-list -->
                  </div>
                  
                  <!-- Modal -->
                  <div class="modal fade" id="edit<?php echo $document->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Upload Images</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <?php echo Form::model($document, ['route' => ['property.documents.update',[$property->id,$document->id]],'method'=>'post','class' => 'row','autocomplete' => '']); ?>

                           <?php echo csrf_field(); ?>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="">Name</label>
                                 <?php echo Form::text('name',null,['class'=>'form-control']); ?>

                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="">Description</label>
                                 <?php echo Form::textarea('description',null,['class'=>'form-control']); ?>

                              </div>
                           </div>
                           <div class="col-md-12">
                              <center><button type="submit" class="btn btn-success">Update Document</button></center>
                           </div>
                           <?php echo Form::close(); ?>

                        </div>
                     </div>
                     </div>
                  </div>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
         <!-- Modal -->
         <div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Upload Images</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="<?php echo route('property.documents.upload',$property->id); ?>" class="dropzone" id="my-awesome-dropzone" method="post">
                     <?php echo csrf_field(); ?>
                     <input type="hidden" value="<?php echo $property->id; ?>" name="propertyID">
                  </form>
               </div>
               <div class="modal-footer">
                  <a onClick="window.location.reload()" href="#" class="btn btn-success" onClick="refreshPage()">Save Document(s)</a>
               </div>
            </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/documents.blade.php ENDPATH**/ ?>