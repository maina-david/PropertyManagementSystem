<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.property.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="row">
               <div class="col-xl-3 col-lg-6 col-sm-6">
                  <div class="widget widget-stats bg-blue">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-users"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Tenants</div>
                        <div class="stats-number"><?php echo number_format($tenants); ?></div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="<?php echo route('tenants.index'); ?>" class="text-white">View Tenants</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-sm-6">
                  <div class="widget widget-stats bg-warning">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-users-crown"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Owners</div>
                        <div class="stats-number"><?php echo number_format($owners); ?></div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="<?php echo route('landlord.index'); ?>" class="text-white">View Owners</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-sm-6">
                  <div class="widget widget-stats bg-success">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-door-open"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Vacant</div>
                        <div class="stats-number"><?php echo number_format($vacant); ?></div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="<?php echo route('property.index'); ?>" class="text-white">View vacancies</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-sm-6">
                  <div class="widget widget-stats bg-danger">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-door-closed"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Occupied</div>
                        <div class="stats-number"><?php echo number_format($occupied); ?></div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="<?php echo route('property.index'); ?>" class="text-white">View Occupied</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-xxl-4 col-lg-12 col-md-12">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Quick Links</h4>
                     </div>
                     <div class="panel-body">
                        <div id="DZ_W_TimeLine1" class="widget-timeline dz-scroll style-1" style="height:250px;">
                           <div class="row text-center">
                              <div class="col-4 pt-3 pb-3 border-right">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-users"></i></h3>
                                 <span><a href="<?php echo route('tenants.create'); ?>">Tenant</a></span>
                              </div>
                              <div class="col-4 pt-3 pb-3 border-right">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-users-crown"></i></h3>
                                 <span><a href="<?php echo route('landlord.create'); ?>">Owner</a></span>
                              </div>
                              <div class="col-4 pt-3 pb-3">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-building"></i> </h3>
                                 <span><a href="<?php echo route('property.index'); ?>">Property</a></span>
                              </div>
                              <div class="col-12"><hr></div>
                              <div class="col-4 pt-3 pb-3 border-right">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-bullhorn"></i> </h3>
                                 <span><a href="<?php echo route('property.lisitng'); ?>">Marketing</a></span>
                              </div>
                              <div class="col-4 pt-3 pb-3 border-right">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-users-cog"></i></h3>
                                 <span>Supplier</span>
                              </div>
                              <div class="col-4 pt-3 pb-3">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-tools"></i></h3>
                                 <span>Work order</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Current Leads</h4>
                     </div>
                     <div class="panel-body">
                        <div class="table-responsive">
                           <table class="table table-responsive-sm mb-0">
                              <thead>
                                 <tr>
                                    <th width="1%">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Listing</th>
                                    <th>Date</th>
                                    <th width="13%">Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                       <td><?php echo $count++; ?></td>
                                       <td><?php echo $inquiry->names; ?></td>
                                       <td><?php echo $inquiry->mail_from; ?></td>
                                       <td><?php echo $inquiry->phone_number; ?></td>
                                       <td>
                                          <?php if($inquiry->listingID != ""): ?>
                                             <?php echo Property::listing($inquiry->listingID)->title; ?>

                                          <?php endif; ?>
                                       </td>
                                       <td><?php echo date('M jS, Y', strtotime($inquiry->created_at)); ?></td>
                                       <td>
                                          <a href="" class="btn btn-success" data-toggle="modal" data-target="#inquirty<?php echo $inquiry->id; ?>">View</a>
                                       </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="inquirty<?php echo $inquiry->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLabel">Inquiry Message</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <?php echo $inquiry->message; ?>

                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          </div>
                                       </div>
                                       </div>
                                    </div>
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
   </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/property/dashboard/dashboard.blade.php ENDPATH**/ ?>