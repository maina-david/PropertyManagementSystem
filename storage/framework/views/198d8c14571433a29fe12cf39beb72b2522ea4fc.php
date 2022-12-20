<?php $__env->startSection('title','List Asset'); ?>


<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('app.assets.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="content">
	<div class="pull-right">
		<?php if(Asset::count_assets() != Wingu::plan()->assets && Asset::count_assets() < Wingu::plan()->assets): ?>
			<?php if (app('laratrust')->isAbleTo('create-assets')) : ?>
	      	<a href="<?php echo route('assets.create'); ?>" class="btn btn-pink"><i class="fal fa-plus-circle"></i> Add Asset</a>
			<?php endif; // app('laratrust')->permission ?>
		<?php endif; ?>
   </div>
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fas fa-barcode"></i> Asset List</h1>
	<?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Asset List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="10%">Image</th>
                     <th>Name </th>
                     <th>Type</th>
                     <th>Asset Tag</th>
                     <th>Serial</th>
                     <th>Status</th>
                     <th>Assigned To</th>
                     <th width="12%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th width="1%">#</th>
                     <th width="10%">Image</th>
                     <th>Name </th>
                     <th>Type</th>
                     <th>Asset Tag</th>
                     <th>Serial</th>
                     <th>Status</th>
                     <th>Assigned To</th>
                     <th width="12%">Action</th>
                  </tr>
               </tfoot>
               <tbody>
						<?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                           <?php if($asset->asset_image == ""): ?>
                              <img src="<?php echo asset('/img/product_placeholder.jpg'); ?>" width="80px" height="60px">
                           <?php else: ?>
                              <img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/assets/'.$asset->asset_image); ?>" alt="" class="img-responsive">
                           <?php endif; ?>
                        </td>
                        <td><?php echo $asset->asset_name; ?></td>
                        <td>
                           <?php if($asset->asset_type == 1): ?>
                              Vehicle
                           <?php else: ?>
                              <?php if($asset->asset_type != ""): ?>
                                 <?php echo Asset::type($asset->asset_type)->name; ?>

                              <?php endif; ?>
                           <?php endif; ?>
                        </td>
                        <td><?php echo $asset->asset_tag; ?></td>
                        <td><?php echo $asset->serial; ?></td>
                        <td>
                           <?php if($asset->status != ""): ?>
                              <?php echo Wingu::status($asset->status)->name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
                           <?php if($asset->employee != ""): ?>
                              <b>Employee :</b> <?php echo Hr::employee($asset->employee)->names; ?>

                           <?php endif; ?>
                           <?php if($asset->customer != ""): ?>
                              <b>Customer :</b> <?php echo Finance::client($asset->customer)->customer_name; ?>

                           <?php endif; ?>
                        </td>
                        <td>
									<?php if (app('laratrust')->isAbleTo('update-assets')) : ?>
                           	<a href="<?php echo route('assets.edit',$asset->id); ?>" class="btn btn-primary btn-sm"><i class="fal fa-edit"></i></a>
									<?php endif; // app('laratrust')->permission ?>
									<?php if (app('laratrust')->isAbleTo('read-assets')) : ?>
                           	<a href="<?php echo route('assets.show',$asset->id); ?>" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
									<?php endif; // app('laratrust')->permission ?>
									<?php if (app('laratrust')->isAbleTo('delete-assets')) : ?>
                           	<a href="<?php echo route('assets.delete',$asset->id); ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
									<?php endif; // app('laratrust')->permission ?>
                        </td>
                     </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </tbody>
            </table>
         </div>
      </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/assets/assets/index.blade.php ENDPATH**/ ?>