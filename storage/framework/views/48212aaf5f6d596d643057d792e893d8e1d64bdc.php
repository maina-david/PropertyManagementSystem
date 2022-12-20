<?php $__env->startSection('title','Update Payments'); ?>

<?php $__env->startSection('stylesheet'); ?>
	<link rel="stylesheet" href="<?php echo asset('assets/resources/assets/css/custome-form.css'); ?>" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('main-menu'); ?>
	<?php echo $__env->make('app.finance.partials._main_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div class="normalheader ">
      <div class="hpanel">
         <div class="panel-body">
            <a class="small-header-action" href="">
               <div class="clip-header">
                  <i class="fa fa-arrow-up"></i>
               </div>
            </a>
            <div id="hbreadcrumb" class="pull-right m-t-lg">
               <ol class="hbreadcrumb breadcrumb">
                  <li><a href="<?php echo e(url('home')); ?>">Expence</a></li>
                  <li>
                        <span>Paymnets Received</span>
                  </li>
                  <li class="active">
                        <span>Update Paymnets</span>
                  </li>
               </ol>
            </div>
            <h2 class="font-light m-b-xs">
               Update Payments Received
            </h2>
            <small>Update Payments Received</small>
         </div>
      </div>
    </div>
	<div class="content">
      <a class="btn btn-info" href="<?php echo url('finance/payments/'.$paymentid.'/edit'); ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Payments</a><br><br>
      <div class="row">
         
         <?php echo $__env->make('Limitless.Finance.partials.gallery-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         
         <div class="col-md-9">
               <div class="row">
                  <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <div class="col-md-3">
                           <?php if( strpos($file->file_mime, 'image') !== false): ?>
                              <div class="hpanel">
                                 <img src="<?php echo asset($file->file_path); ?>" alt="" width="100%" style="height:118px">
                                 <div class="panel-footer">
                                       <span class="label label-info" style="margin-right:2px;">
                                          
                                 <a href="" data-toggle="modal" data-target="#file-details" class="file-details" onclick="fun_edit('<?php echo e($file->id); ?>')"><i class="fa fa-eye white"></i></a>
                                       </span>
                                       <span class="label label-danger">
                                             <a href="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o white"></i></a>
                                       </span>
                                       <a href="#" class="pull-right"><?php echo $file->caption; ?></a>
                                 </div>
                              </div>
                           <?php endif; ?>
                           <?php if($file->file_mime == "application/pdf"): ?>
                              <div class="hpanel">
                                 <div class="panel-body file-body">
                                       <i class="fa fa-file-pdf-o text-info"></i>
                                 </div>
                                 <div class="panel-footer">
                                       <span class="label label-info" style="margin-right:2px;">
                                             <a href="" data-toggle="modal" data-target="#file-details"><i class="fa fa-eye white"></i></a>
                                       </span>
                                       <span class="label label-danger">
                                             <a href="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o white"></i></a>
                                       </span>
                                       <a href="#" class="pull-right"><?php echo $file->caption; ?></a>
                                 </div>
                              </div>
                           <?php endif; ?>
                           <?php if($file->file_mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"): ?>
                              <div class="hpanel">
                                 <div class="panel-body file-body">
                                       <i class="fa  fa-file-word-o text-primary"></i>
                                 </div>
                                 <div class="panel-footer">
                                       <span class="label label-info" style="margin-right:2px;">
                                             <a href="" data-toggle="modal" data-target="#file-details"><i class="fa fa-eye white"></i></a>
                                       </span>
                                       <span class="label label-danger">
                                             <a href="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o white"></i></a>
                                       </span>
                                       <a href="#" class="pull-right"><?php echo $file->caption; ?></a>
                                 </div>
                              </div>
                           <?php endif; ?>
                           <?php if($file->file_mime == "application/octet-stream"): ?>
                              <div class="hpanel">
                                 <div class="panel-body file-body">
                                       <i class="fa  fa-file-code-o text-success"></i>
                                 </div>
                                 <div class="panel-footer">
                                       <span class="label label-info" style="margin-right:2px;">
                                             <a href="" data-toggle="modal" data-target="#file-details"><i class="fa fa-eye white"></i></a>
                                       </span>
                                       <span class="label label-danger">
                                             <a href="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o white"></i></a>
                                       </span>
                                       <a href="#" class="pull-right"><?php echo $file->caption; ?></a>
                                 </div>
                              </div>
                           <?php endif; ?>
                     </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <input type="hidden" name="hidden_view" id="hidden_view" value="<?php echo e(url('fileview')); ?>">
               
               </div>
         </div>
      </div>
   </div>
	<br>
	<div id="upload_media" class="modal fade" role="dialog">
	  	<div class="modal-dialog modal-lg">
	    	<!-- Modal content-->
		    <div class="modal-content">
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Upload Files</h4>
		      	</div>
		      	<div class="modal-body">
		        	<?php echo Form::open(array('url' => 'finance/paymentsfile/store','class'=>'dropzone','id'=>'my-awesome-dropzone','action' => 'post')); ?>

		        		<input type="hidden" name="parentid" value="<?php echo $paymentid; ?>">
					<?php echo Form::close(); ?>

		      	</div>
		      	<div class="modal-footer">
		       		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		       		<button type="button" class="btn btn-success" onClick="window.location.href=window.location.href">Save</button>
		      	</div>
		    </div>
	  	</div>
	</div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script type="text/javascript">
		var view_url = $("#hidden_view").val();
		function fun_edit(id){
	      	var view_url = $("#hidden_view").val();
		      	$.ajax({
		        url: view_url,
		        type:"GET",
		        data: {"id":id},
		        success: function(result){
			        //console.log(result);
			        $("#edit_id").val(result.id);
			        $("#caption").val(result.caption);
			        $("#file_path").val(result.file_path);
			        $("#edit_email").val(result.email);
					$("#link").text(result.file_path);
					$("#image").src(result.file_path);
		        }
	      	});
	    }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/payments/file.blade.php ENDPATH**/ ?>