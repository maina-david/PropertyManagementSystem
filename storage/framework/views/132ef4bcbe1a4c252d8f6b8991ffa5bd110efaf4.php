<?php $__env->startSection('title'); ?> <?php echo $property->title; ?> | Images <?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Images</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  <?php echo $property->title; ?> | Images</h1>
      <div class="row">
         <?php echo $__env->make('app.property.partials._property_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="col-md-12">
            <div class="row row-space-10 m-b-20">
               <div class="col-md-12 mb-3">
                  <a href="" class="btn btn-warning" data-toggle="modal" data-target="#addImage"><i class="fal fa-images"></i> Add Images</a>
               </div>
               <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-4">
                     <div class="card">
                        <div class="card-body">
                           <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/images/'.$image->file_name); ?>" alt="" class="img-responsive">
                        </div>
                        <div class="card-footer">
                           <div class="row">
                              <div class="col-md-12">
                                 <h5 class="title"><?php echo $image->name; ?></h5>
                                 <a class="float-right btn-danger btn btn-sm delete" href="<?php echo route('property.images.delete',[$property->id,$image->id]); ?>">Delete</a>
                              </div>
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
                  <form action="<?php echo route('property.images.upload',$property->id); ?>" class="dropzone" id="my-awesome-dropzone" method="post">
                     <?php echo csrf_field(); ?>
                     <input type="hidden" value="<?php echo $property->id; ?>" name="propertyID">
                  </form>
               </div>
               <div class="modal-footer">
                  <a onClick="window.location.reload()" href="#" class="btn btn-success" onClick="refreshPage()">Save Images</a>
               </div>
            </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/property/images.blade.php ENDPATH**/ ?>