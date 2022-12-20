<?php $__env->startSection('title','Deal details'); ?>
<?php $__env->startSection('stylesheet'); ?>
   <style>
      .progressbar {
      counter-reset: step;
      }
      .progressbar li {
            list-style-type: none;
            width: 13%;
            float: left;
            font-size: 12px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: #7d7d7d;
      }
      .progressbar li:before {
            font-family: 'Font';
            width: 30px;
            height: 30px;
            content: counter(step);
            counter-increment: step;
            line-height: 30px;
            border: 2px solid #7d7d7d;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
      }
      .progressbar li:after {
            width: 100%;
            height: 2px;
            content: '';
            position: absolute;
            background-color: #7d7d7d;
            top: 15px;
            left: -50%;
            z-index: -1;
      }
      .progressbar li:first-child:after {
            content: none;
      }
      .progressbar li.active {
            color: green; 
      }
      .progressbar li.active:before {
            border-color: #55b776;
      }
      .progressbar li.active + li:after {
            background-color: #55b776;
      }   
   </style>    
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.crm.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         
         
         <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true"> <i class="fal fa-ellipsis-h"></i></button>
            <ul class="dropdown-menu mr-5">
               <li><a href="<?php echo route('crm.deals.edit',$deal->dealID); ?>"><i class="fad fa-edit"></i> Edit</a></li>   
               <li><a href="#<?php echo route('crm.deals.delete',$deal->dealID); ?>" class="delete"><i class="fad fa-trash"></i> Delete</a></li>                           
            </ul>
         </div>   
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullseye"></i> <?php echo $deal->title; ?></h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <div class="row">
         <div class="col-md-12 mb-5">
            <ul class="progressbar">
               <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li class="<?php if($stage->id == $deal->stage): ?> active <?php endif; ?>"><?php echo $stage->title; ?></li>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
         </div>
      </div>  
      <div class="row">
         <div class="col-md-3">
            <div class="panel panel-default">
               <div class="panel-heading"><i class="fal fa-info-circle"></i> <b>About Deal</b></div>
               <div class="panel-body">
                  <p>
                     <b>Deal  :</b> <span class="text-primary">Age <?php echo number_format(Helper::date_difference($deal->close_date,$deal->create_date)); ?> Day(s)</span><br>
                     <b>Closure Date :</b> <span class="text-primary"><?php if($deal->close_date != ""): ?><?php echo date('F jS Y', strtotime($deal->close_date)); ?><?php endif; ?></span><br>
                     <b>Assign to :</b> <span class="text-primary"><?php if(Hr::check_employee($deal->owner) != 0): ?><?php echo Hr::employee($deal->owner)->names; ?><?php endif; ?></span><br>
                     <b>Pipeline :</b> <span class="text-primary"><?php if(Crm::check_pipeline($deal->pipeline) != 0): ?><?php echo Crm::pipeline($deal->pipeline)->title; ?><?php endif; ?></span> <br>
                     <b>Stage :</b> <span class="text-primary"><?php if(Crm::check_pipeline_stage($deal->stage) != 0): ?>  
                        <?php echo Crm::pipeline_stage($deal->stage)->title; ?>

                     <?php endif; ?></span> <br>
                     <b>Estimated worth :</b> <span class="text-primary"><?php echo $deal->code; ?> <?php echo number_format($deal->value); ?></span> <br>
                     <b>Created At :</b> <span class="text-primary"><?php echo date('F jS Y', strtotime($deal->create_date)); ?></span>
                  </p>
               </div>
            </div>
            
            
            
         </div>
         <div class="col-md-9">
            <ul class="nav nav-tabs">
               <li class="nav-item">
                  <a class="nav-link <?php echo Nav::isRoute('crm.deals.show'); ?>" href="<?php echo route('crm.deals.show',$deal->dealID); ?>"><i class="fas fa-globe"></i> Overview</a>
               </li>               
               <li class="nav-item">
                  <a class="nav-link <?php echo Nav::isRoute('crm.deals.calllog.index'); ?>" href="<?php echo route('crm.deals.calllog.index',$deal->dealID); ?>"><i class="fad fa-phone-square-alt"></i> Call logs</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link <?php echo Nav::isRoute('crm.deals.notes.index'); ?>" href="<?php echo route('crm.deals.notes.index',$deal->dealID); ?>"><i class="fad fa-sticky-note"></i> Notes</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link <?php echo Nav::isRoute('crm.deals.task.index'); ?>" href="<?php echo route('crm.deals.task.index',$deal->dealID); ?>"><i class="fad fa-tasks"></i> Tasks</a>
               </li>
               
               
               
               
               <li class="nav-item">
                  <a class="nav-link <?php echo Nav::isRoute('crm.deals.appointments.index'); ?>" href="<?php echo route('crm.deals.appointments.index',$deal->dealID); ?>"><i class="fad fa-calendar-check"></i> Appointments</a>
               </li>               
            </ul>
            <?php if(Request::is('crm/deals/'.$deal->dealID.'/show')): ?>
               <?php echo $__env->make('app.crm.deals.deal.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>  
            <?php if(Request::is('crm/deals/'.$deal->dealID.'/call_log')): ?>
               <?php echo $__env->make('app.crm.deals.deal.call_log', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>            
            <?php if(Request::is('crm/deals/'.$deal->dealID.'/notes')): ?>
               <?php echo $__env->make('app.crm.deals.deal.notes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>   
            <?php if(Request::is('crm/deals/'.$deal->dealID.'/task')): ?>
               <?php echo $__env->make('app.crm.deals.deal.task', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(Request::is('crm/deals/'.$deal->dealID.'/appointments')): ?>
               <?php echo $__env->make('app.crm.deals.deal.appointments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
         </div>
      </div>    
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/crm/deals/deal/show.blade.php ENDPATH**/ ?>