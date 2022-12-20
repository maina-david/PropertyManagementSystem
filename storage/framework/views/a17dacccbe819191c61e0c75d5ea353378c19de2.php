<?php $__env->startSection('title'); ?> Plans <?php $__env->stopSection(); ?>
<?php $__env->startSection('url'); ?><?php echo route('home.page'); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      .section-container{
         min-height: 350px
      }
      .section-container-plain{
         background-image: none;
      }

      .icon-shape {
         display: -webkit-inline-box;
         display: inline-flex;
         -webkit-box-align: center;
         align-items: center;
         -webkit-box-pack: center;
         justify-content: center;
         text-align: center;
         vertical-align: middle;
      }

      .icon-xs {
         height: 20px;
         width: 20px;
         line-height: 20px;
      }
      .mr-2, .mx-2 {
         margin-right: .5rem!important;
      }

      .rounded-circle {
         border-radius: 50%!important;
      }
      .bg-lightpalegreen {
         background-color: #e4ffcf!important;
      }

      .bg-lightpeach {
         background-color: #ffd7de!important;
      }
   </style>    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>  
   <div class="section-container head-section mb-5 bg-white">
      <div class="pageheader bg-shape mt-5">
         <div class="container">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="page-caption mt-5">
                     <div class="page-caption-para-text text-center mt-5">
                        <h2 class="mb-2"><i class="fal fa-credit-card-front fa-3x"></i></h2>
                        <h1>Upgrade today and get more!</h1>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="section-container-plain head-section mb-5">
      <div class="container">
         <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <div class="row justify-content-center">
            <?php $__currentLoopData = Wingu::get_all_plan(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                  <!--  pricing block start -->
                  <div class="card card-body py-5 px-4 mb-4 border-lightinfo aos-init aos-animate" data-aos="zoom-in">
                     <div class="mb-3 text-center">
                        <h3 class="font-14 textspace-lg text-info mb-3"><?php echo $plan->title; ?></h3>
                        <h4 class="font-weight-bold text-dark">$<?php echo number_format($plan->usd); ?>/month.</h4>
                     </div>
                     <div class="text-center">
                        <?php $__currentLoopData = Wingu::get_active_modules(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activeModules): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="d-flex mb-2">
                              <?php if(Wingu::check_plan_module_link($activeModules->id,$plan->id) == 1): ?>
                                 <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                    <i class="fas fa-check text-success"></i>
                                 </div>
                              <?php else: ?> 
                                 <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                    <i class="fas fa-times text-danger"></i>
                                 </div>
                              <?php endif; ?>
                              <!-- Text -->
                              <p class="mb-0 font-14">
                                 <span><?php echo $activeModules->name; ?></span>
                              </p>
                           </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($plan->invoices != ""): ?>
                           <div class="d-flex mb-2">
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                              <p class="mb-0 font-14">
                                 <span><?php if($plan->invoices > 1000): ?>Unlimited <?php else: ?><?php echo $plan->invoices; ?><?php endif; ?> invoices/month</span>
                              </p>
                           </div>
                        <?php endif; ?>
                        <div class="d-flex mb-2">
                           <?php if($plan->employees == 0): ?>
                              <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-times text-danger"></i>
                              </div>
                           <?php else: ?>                              
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                           <?php endif; ?>
                           <p class="mb-0 font-14">
                              <span><?php if($plan->employees > 0): ?>Unlimited <?php endif; ?> Employees</span>
                           </p>
                        </div>
                        <div class="d-flex mb-2">
                           <?php if($plan->users == 0): ?>
                              <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-times text-danger"></i>
                              </div>
                           <?php else: ?>                              
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                           <?php endif; ?>
                           <p class="mb-0 font-14">
                              <span><?php echo $plan->users; ?> users included</span>
                           </p>
                        </div>
                        <?php if($plan->leads != ""): ?>
                           <div class="d-flex mb-2">
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                              <p class="mb-0 font-14">
                                 <span><?php if($plan->leads > 1000): ?>Unlimited <?php else: ?><?php echo $plan->leads; ?><?php endif; ?> Leads/month</span>
                              </p>
                           </div>
                        <?php endif; ?>
                        <?php if($plan->customers != ""): ?>
                           <div class="d-flex mb-2">
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                              <p class="mb-0 font-14">
                                 <span><?php if($plan->customers > 1000): ?> Unlimited <?php else: ?><?php echo $plan->customers; ?><?php endif; ?> Customers/mo</span>
                              </p>
                           </div>
                        <?php endif; ?>
                        <div class="d-flex mb-2">
                           <?php if($plan->suppliers == 0): ?>
                              <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-times text-danger"></i>
                              </div>
                           <?php else: ?>                              
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                           <?php endif; ?>
                           <p class="mb-0 font-14">
                              <span><?php if($plan->suppliers > 1000): ?>Unlimited <?php else: ?><?php echo $plan->suppliers; ?><?php endif; ?> Vendors/month</span>
                           </p>
                        </div>
                        <div class="d-flex mb-2">
                           <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                              <i class="fas fa-check text-success"></i>
                           </div>
                           <p class="mb-0 font-14">
                              <span><?php if($plan->projects > 1000): ?>Unlimited <?php else: ?><?php echo $plan->projects; ?><?php endif; ?> Projects/month</span>
                           </p>
                        </div>
                        <div class="d-flex mb-2">
                           <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                              <i class="fas fa-check text-success"></i>
                           </div>
                           <p class="mb-0 font-14">
                              <span><?php if($plan->products > 1000): ?>Unlimited <?php else: ?><?php echo $plan->products; ?><?php endif; ?> Items/month</span>
                           </p>
                        </div>
                        <div class="d-flex mb-2">
                           <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                              <i class="fas fa-check text-success"></i>
                           </div>
                           <p class="mb-0 font-14">
                              <span><?php echo $plan->roles; ?> Custom Roles</span>
                           </p>
                        </div>    
                        <div class="d-flex mb-2">
                           <?php if($plan->assets == 0): ?>
                              <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-times text-danger"></i>
                              </div>
                           <?php else: ?>                              
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                           <?php endif; ?>
                           <p class="mb-0 font-14">
                              <span><?php echo $plan->assets; ?> Assets in Management</span>
                           </p>
                        </div>                        
                        <?php if($plan->id == Wingu::business()->plan): ?>
                           <button type="button" class="btn btn-inverse btn-block btn-success mt-5">
                              <i class="fal fa-check-circle"></i> Selected
                           </button>
                        <?php else: ?>
                           <?php if($plan->id == 1): ?>
                              <a href="#" class="btn btn-inverse btn-pink btn-block mt-5">
                                 Choose this
                              </a>
                           <?php else: ?> 
                              <button type="button" class="btn btn-inverse btn-pink btn-block btn-primary mt-5" data-toggle="modal" data-target="#plan<?php echo $plan->id; ?>">
                                 Upgrade
                              </button>
                           <?php endif; ?>
                        <?php endif; ?>
                     </div>
                  </div>
                  <!--  pricing block close -->
               </div>
               
               <div class="modal fade" id="plan<?php echo $plan->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Choose method of payment</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <form action="https://payments.ipayafrica.com/v3/ke">
                                    <input name="hsh" type="hidden" value="<?php echo Wingu::ipay($plan->id); ?>">  
                                    <input type="hidden" name="live" value="1" class="form-control">
                                    <input type="hidden" name="oid" value="<?php echo $plan->id; ?>" class="form-control">
                                    <input type="hidden" name="inv" value="<?php echo Wingu::business()->businessID; ?>" class="form-control">
                                    <input type="hidden" name="ttl" value="<?php echo $plan->price; ?>" class="form-control">
                                    <input type="hidden" name="tel" value="0700000000" class="form-control">
                                    <input type="hidden" name="eml" value="<?php echo Wingu::business()->primary_email; ?>" class="form-control">
                                    <input type="hidden" name="vid" value="treeb" class="form-control">
                                    <input type="hidden" name="curr" value="KES" class="form-control">
                                    <input type="hidden" name="p1" value="Webpayment" class="form-control">
                                    <input type="hidden" name="p2" value="<?php echo Auth::user()->businessID; ?>" class="form-control">
                                    <input type="hidden" name="p3" value="" class="form-control">
                                    <input type="hidden" name="p4" value="" class="form-control">
                                    <input type="hidden" name="cbk" value="https://cloud.winguplus.com/subscriptions/ipay/callback" class="form-control">
                                    <input type="hidden" name="cst" value="1" class="form-control">
                                    <input type="hidden" name="crl" value="0" class="form-control">
                                    <center><button type="submit" class="btn btn-lg btn-success btn-block"><i class="fas fa-credit-card"></i> Ipay</button></center>
                                 </form>
                              </div>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/wingu/hold/plans.blade.php ENDPATH**/ ?>