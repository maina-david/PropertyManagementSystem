<?php $__env->startSection('title','Update supplier'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.finance.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo route('finance.index'); ?>">Finance</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('finance.supplier.index'); ?>">Suppliers</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users-cog"></i> Update Supplier </h1>
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php echo Form::model($suppliers, ['route' => ['finance.supplier.update',$suppliers->supplierID], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']); ?>

         <?php echo csrf_field(); ?>

         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Details</h4>
                  </div>
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        <?php echo Form::label('Supplier Type', 'Supplier Type', array('class'=>'control-label')); ?>

                        <?php echo e(Form::select('contact_type',[''=>'Choose Supplier Type','Individual'=>'Individual','Organization'=>'Company/Organization'], null, ['class' => 'form-control','data-init-plugin' => 'select2', 'id' => 'contact_type' ])); ?>

                        <input type="hidden" name="client_type" id="" value="Client">
                     </div>
                     <div class="form-group form-group-default">
                        <?php echo Form::label('supplier_name', 'Suppliers Name', array('class'=>'control-label')); ?>

                        <?php echo Form::text('supplier_name', null, array('class' => 'form-control', 'placeholder' => 'Supplier Names')); ?>

                     </div>
                     <?php if($suppliers->contact_type == "Individual"): ?>
                        <div class="row">
                           <div class="col-sm-4">
                              <div class="form-group form-group-default">
                                 <?php echo Form::label('Salutation', 'Salutation', array('class'=>'control-label')); ?>

                                 <?php echo e(Form::select('salutation',[''=>'Choose Salutation','Mr'=>'Mr','Mrs'=>'Mrs','Ms' => 'Ms','Miss' => 'Miss','Dr' => 'Dr'], null, ['class' => 'form-control','data-init-plugin' => 'select2' ])); ?>

                              </div>
                           </div>
                           <div class="col-sm-8">
                              <div class="form-group form-group-default required">
                                 <?php echo Form::label('position', 'Job Position', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('position', null, array('class' => 'form-control', 'placeholder' => 'designation')); ?>

                              </div>
                           </div>
                        </div>
                     <?php endif; ?>
                     <div class="form-group form-group-default required ">
                        <?php echo Form::label('Referral', 'Referral', array('class'=>'control-label')); ?>

                        <input type="text" name="referral" placeholder="Referral" class="form-control">
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h4 class="panel-title">Supplier List</h4>
                  </div>
                  <div class="panel-body">
                     <div class="form-group form-group-default required ">
                        <?php echo Form::label('email', 'Primary Contact Email', array('class'=>'control-label')); ?>

                        <?php echo Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact Email', 'required' =>'' )); ?>

                     </div>
                     <div class="form-group form-group-default">
                        <?php echo Form::label('email_cc', 'Email CC', array('class'=>'control-label')); ?>

                        <?php echo Form::email('email_cc', null, array('class' => 'form-control', 'placeholder' => 'Email CC')); ?>

                     </div>
                     <div class="form-group form-group-default required ">
                        <?php echo Form::label('website', 'Website', array('class'=>'control-label')); ?>

                        <?php echo Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')); ?>

                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default required">
                              <?php echo Form::label('primary_phone_number', 'Primary Phone Number', array('class'=>'control-label')); ?>

                              <?php echo Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x 0700 000 000','required' => '')); ?>

                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              <?php echo Form::label('other_phone_number', 'Other Phone Number', array('class'=>'control-label')); ?>

                              <?php echo Form::text('other_phone_number', null, array('class' => 'form-control', 'placeholder' => 'e.x 0700 000 000')); ?>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <ul class="nav nav-pills">
						<li class="nav-items">
							<a href="#other_details" data-toggle="tab" class="nav-link active">
								<span class="d-sm-none">Other Details</span>
								<span class="d-sm-block d-none">Other Details</span>
							</a>
						</li>
						<li class="nav-items">
							<a href="#address" data-toggle="tab" class="nav-link">
								<span class="d-sm-none">Address</span>
								<span class="d-sm-block d-none">Address</span>
							</a>
						</li>
						<li class="nav-items">
							<a href="#contact-person" data-toggle="tab" class="nav-link  show">
								<span class="d-sm-none">Contact Persons</span>
								<span class="d-sm-block d-none">Contact Persons</span>
							</a>
                  </li>
                  <li class="nav-items">
							<a href="#payment" data-toggle="tab" class="nav-link">
								<span class="d-sm-none">Payment Information</span>
								<span class="d-sm-block d-none">Payment Information</span>
							</a>
						</li>
						<li class="nav-items">
							<a href="#remarks" data-toggle="tab" class="nav-link">
								<span class="d-sm-none">Remarks</span>
								<span class="d-sm-block d-none">Remarks</span>
							</a>
						</li>
					</ul>
               <div class="tab-content">
                  <div class="tab-pane active" id="other_details">
                     <div class="row ">
                        <div class="col-md-6">
                           
                           
                           
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Facebook', 'Facebook', array('class'=>'control-label')); ?>

                                    <?php echo Form::text('facebook', null, array('class' => 'form-control', 'placeholder' => 'Facebook',)); ?>

                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group form-group-default">
                                    <?php echo Form::label('Twitter', 'Twitter', array('class'=>'control-label')); ?>

                                    <?php echo Form::text('twitter', null, array('class' => 'form-control', 'placeholder' => 'Twitter')); ?>

                                 </div>
                              </div>
                           </div>
                           <div class="form-group form-group-default">
										<label>Supplier Category</label>
										<?php echo e(Form::select('categories[]', $joincat, null, ['class' => 'form-control multiple-select2','multiple' => 'multiple'])); ?>

									</div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Supplier Logo or Image</label>
                           </div>
                           <a href="#" id="set-post-thumbnail">Click here to choose an image</a><br>
                           <input type="file" name="image" id="thumbnail" class="file" style="display: none">
                           <div class="row">
                              <center><img src="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/suppliers/'.$suppliers->supplierCode.'/images/'.$suppliers->image); ?>" alt="" style="width:60%"></center>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="address">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="panel-body">
                              <div class="form-group form-group-default required ">
                                    <?php echo Form::label('Attention', 'Attention', array('class'=>'control-label')); ?>

                                    <?php echo Form::text('bill_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')); ?>

                              </div>
                              <div class="form-group form-group-default required ">
                                    <?php echo Form::label('bill_street', 'Street', array('class'=>'control-label')); ?>

                                    <?php echo Form::text('bill_street', null, array('class' => 'form-control', 'placeholder' => 'Street')); ?>

                              </div>
                              <div class="form-group form-group-default required ">
                                    <?php echo Form::label('bill_city', 'City', array('class'=>'control-label')); ?>

                                    <?php echo Form::text('bill_city', null, array('class' => 'form-control', 'placeholder' => 'City')); ?>

                              </div>
                              <div class="form-group form-group-default required ">
                                    <?php echo Form::label('bill_state', 'State', array('class'=>'control-label')); ?>

                                    <?php echo Form::text('bill_state', null, array('class' => 'form-control', 'placeholder' => 'State')); ?>

                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="panel-body">
                              <div class="form-group form-group-default required ">
                                 <?php echo Form::label('bill_address', 'Billing Address', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('bill_address', null, array('class' => 'form-control', 'placeholder' => 'Address')); ?>

                           </div>
                           <div class="form-group form-group-default required ">
                                 <?php echo Form::label('bill_zip_code', 'Zip Code', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('bill_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')); ?>

                           </div>
                           <div class="form-group form-group-default">
                                 <?php echo Form::label('bill_country', 'Country', array('class'=>'control-label')); ?>

                                 <?php echo e(Form::select('bill_country', $country, null, ['class' => 'form-control multiselect' ])); ?>

                           </div>
                           <div class="form-group form-group-default required ">
                                 <?php echo Form::label('bill_fax', 'Fax', array('class'=>'control-label')); ?>

                                 <?php echo Form::text('bill_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')); ?>

                           </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="contact-person">
                     <div class="row"><br>
                        <div class="col-md-12">
                           <table class="table table-bordered">
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Names</th>
                                 <th>Email Address</th>
                                 <th>Phone number</th>
                                 <th>Designation</th>
                                 <th width="1%">Action</th>
                              </tr>
                              <?php $__currentLoopData = $persons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td>
                                       <?php echo $cp->salutation; ?> <?php echo $cp->names; ?>

                                    </td>
                                    <td><?php echo $cp->contact_email; ?></td>
                                    <td><?php echo $cp->phone_number; ?></td>
                                    <td><?php echo $cp->designation; ?></td>
                                    <td>
                                       <a class="btn btn-danger delete" href="<?php echo e(route('finance.supplier.vendor.person',$cp->id)); ?>"><i class="fas fa-trash-alt"></i> Delete</a>
                                    </td>
                                 </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </table>
                           <br><br>
                           <p><b>Add Contact person</b></p>
                           <table class="table table-bordered contact_persons">
                              <tr>
                                 <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                 <th>#</th>
                                 <th>Salutation</th>
                                 <th>Names</th>
                                 <th>Email Address</th>
                                 <th>Phone number</th>
                                 <th>Designation</th>
                              </tr>
                           </table>
                           <button type="button" class='btn btn-danger delete_contact_persons'> - Delete</button>
                           <button type="button" class='btn btn-success addmore_contact_persons'> + Add More</button>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="remarks">
                     <div class="row"><br>
                        <div class="col-md-12">
                           <div class="form-group">
                              <?php echo Form::label('Remarks', 'Remarks', array('class'=>'control-label')); ?>

                              <?php echo Form::textarea('remarks',null,['class'=>'form-control ckeditor', 'rows' => 5, 'placeholder'=>'content']); ?>

                           </div>
                           <br>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="panel-body">
               <center>
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update supplier</button>
                  <img src="<?php echo asset('assets/img/btn-loader.gif'); ?>" class="submit-load none" alt="" width="15%">
               </center>
            </div>
         </div>
      <?php echo Form::close(); ?>

	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
      $(".delete_contact_persons").on('click', function() {
         $('.case:checkbox:checked').parents("tr").remove();
         $('.check_all').prop("checked", false);
         check();
      });

      var i=$('.contact_persons tr').length;
      var n = 1;
      $(".addmore_contact_persons").on('click', function() {
         count = $('.contact_persons tr').length;
         var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum" + i + "'>" + n++ + ".</span></td>";
         data +=
            "<td><select id='cn_salutation' class='form-control' name='cn_salutation[]'><option value='' selected='selected'>Choose Salutation</option><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option></select></td><td><input class='form-control' type='text' id='cn_names" +
            i + "' name='cn_names[]'></td><td><input class='form-control' type='text' id='email_address_" + i + "' name='email_address[]'></td><td><input class='form-control' type='text' id='phone_number" + i + "' name='phone_number[]'></td><td><input class='form-control' type='text' id='cn_desgination_" + i + "' name='cn_desgination[]'></td><tr>";
         $('.contact_persons').append(data);
      });

      $("#set-post-thumbnail").click(function() {
			$("input[id='thumbnail']").click();
		});

      $(".multiple-select2").select2();
		$(".multiple-select2").select2().val(<?php echo json_encode($jointcategories); ?>).trigger('change');
   </script>
   <script src="<?php echo asset('assets/plugins/ckeditor/4/standard/ckeditor.js'); ?>"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/finance/suppliers/edit.blade.php ENDPATH**/ ?>