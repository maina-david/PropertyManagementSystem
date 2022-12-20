<?php $__env->startSection('title','Branches'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<link href="<?php echo asset('assets/plugins/jstree/dist/themes/default/style.min.css'); ?>" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL JS ================== -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?> 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Organization</li>
         <li class="breadcrumb-item active">Branches</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-map-marked-alt"></i> Branches</h1>
		<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin widget-list -->
      <div class="row">
         <div class="col-md-12 mb-2">
            <a href="<?php echo route('hrm.branches.create'); ?>" class="float-right btn btn-pink btn-sm"><i class="fas fa-plus"></i> Add Branch</a>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%"> #</th>
                           <th>Branch</th>
                           <th>Country</th>
                           <th>City</th>
                           <th>Address</th>
                           <th>Phone number</th>
                           <th>Email</th>
                           <th width="14%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><?php echo $count++; ?></td>
                              <td>
                                 <?php echo $branch->branch_name; ?>

                                 <?php if($branch->main_branch == 'Yes'): ?>
                                    <br><span class="badge badge-primary"><?php echo $branch->main_branch; ?></span>
                                 <?php endif; ?>
                              </td>
                              <td>
                                 <?php if($branch->countryID != ""): ?>
                                    <?php echo Wingu::country($branch->countryID)->name; ?>

                                 <?php endif; ?>
                              </td>
                              <td><?php echo $branch->city; ?></td>
                              <td><?php echo $branch->address; ?></td>
                              <td><?php echo $branch->phone_number; ?></td>
                              <td><?php echo $branch->email; ?></td>
                              <td>
                                 <a href="<?php echo route('hrm.branches.edit',$branch->branchID); ?>" class="btn btn-sm btn-pink"><i class="fas fa-edit"></i> Edit</a>
                                 <a href="<?php echo route('hrm.branches.delete',$branch->branchID); ?>" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo url('backend/plugins/ckeditor/4/basic/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/organization/branches/index.blade.php ENDPATH**/ ?>