<?php $__env->startSection('title','New Proposal'); ?>
<?php $__env->startSection('sidebar'); ?>
   <?php echo $__env->make('backend.cms.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Cms</a></li>
         <li class="breadcrumb-item"><a href="#">Proposal</a></li>
         <li class="breadcrumb-item active">New</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Update Proposal</h1>
      <!-- end page-header -->
      <?php echo $__env->make('backend.partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <?php echo Form::open(array('route' => 'cms.knowledgebase.store','class' => 'row')); ?>

         <?php echo csrf_field(); ?>
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('name', 'Title', array('class'=>'control-label')); ?>

                        <?php echo Form::text('title', null, array('class' => 'form-control','required' => '')); ?>

                     </div>
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('name', 'Proposal type', array('class'=>'control-label')); ?>

                        <?php echo Form::select('proposal_type', ['' => 'choose proposal type','edocument' => 'Make e-document','upload' => 'upload proposal'], null, array('class' => 'form-control','required' => '')); ?>

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group form-group-default">
                        <?php echo Form::label('title', 'proposal Category', array('class'=>'control-label')); ?>

                        <?php echo Form::text('proposal_category', null, array('class' => 'form-control','placeholder' => 'e.g Marketing proposal')); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <?php echo Form::label('title', 'Upload Proposal', array('class'=>'control-label')); ?>

                        <?php echo Form::file('proposal_category', null, array('class' => 'form-control')); ?>

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <div class="panel-body">
                     <div class="form-group">
                        <?php echo Form::label('Description', 'Description', array('class'=>'control-label')); ?>

                        
                        <textarea  cols="30" rows="10" class="ckeditor">

                              <h2>The Flavorful Tuscany Meetup</h2>

                              <p><strong>Welcome letter</strong></p>
                              
                              <p>Dear Guest,</p>
                              
                              <p>We are delighted to welcome you to the annual <em>Flavorful Tuscany Meetup</em> and hope you will enjoy the programme as well as your stay at the Bilancino Hotel.</p>
                              
                              <p>Please find below the full schedule of the event.</p>
                              
                              <table cellpadding="15" cellspacing="0">
                                 <thead>
                                    <tr>
                                       <th colspan="2" scope="col">Saturday, July 14</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>9:30 AM - 11:30 AM</td>
                                       <td>Americano vs. Brewed - &ldquo;know your coffee&rdquo; session with <strong>Stefano Garau</strong></td>
                                    </tr>
                                    <tr>
                                       <td>1:00 PM - 3:00 PM</td>
                                       <td>Pappardelle al pomodoro - live cooking session with <strong>Rita Fresco</strong></td>
                                    </tr>
                                    <tr>
                                       <td>5:00 PM - 8:00 PM</td>
                                       <td>Tuscan vineyards at a glance - wine-tasting session with <strong>Frederico Riscoli</strong></td>
                                    </tr>
                                 </tbody>
                              </table>
                              
                              <blockquote>
                              <p>The annual Flavorful Tuscany meetups are always a culinary discovery. You get the best of Tuscan flavors during an intense one-day stay at one of the top hotels of the region. All the sessions are lead by top chefs passionate about their profession. I would certainly recommend to save the date in your calendar for this one!</p>
                              
                              <p>Angelina Calvino, food journalist</p>
                              </blockquote>
                              
                              <p>Please arrive at the Bilancino Hotel reception desk at least <strong>half an hour earlier</strong> to make sure that the registration process goes as smoothly as possible.</p>
                              
                              <p>We look forward to welcoming you to the event.</p>
                              
                              <p><strong>Victoria Valc</strong><br />
                              <strong>Event Manager</strong><br />
                              <strong>Bilancino Hotel</strong></p>
                              
                        </textarea>
                     </div>
                  </div>
                  <div class="panel-body">
                     <div class="form-group">
                        <center><button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Proposal</button></center>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php echo Form::close(); ?>

   </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script src="<?php echo url('/'); ?>/public/backend/plugins/ckeditor/4/full/ckeditor.js"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/cms/proposal/edit.blade.php ENDPATH**/ ?>