<?php $__env->startSection('title','Travel Expenses | Human Resource'); ?>


<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('app.hr.partials._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="<?php echo e(Nav::isRoute('hrm.dashboard')); ?>">Human resource</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.travel.index'); ?>">Travel</a></li>
         <li class="breadcrumb-item"><a href="<?php echo route('hrm.travel.expenses'); ?>">Expenses</a></li>
         <li class="breadcrumb-item active">Add Expenses</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-usd-circle"></i> Edit Expenses</h1>
      <!-- end page-header -->
      <?php echo $__env->make('partials._messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <!-- begin panel -->
      <?php echo Form::model($edit, ['route' => ['hrm.travel.expenses.update',$edit->expenseID], 'method'=>'post','enctype' => 'multipart/form-data','class' => 'row']); ?>

         <?php echo csrf_field(); ?>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">Expense Details</div>
               <div class="panel-body">
                  <div class="form-group form-group-default">
                     <label for="" class="text-danger">Choose Travel</label>
                     <select name="travel" id="" class="from-control multiselect" required>
                        <option value="<?php echo $edit->expense_travelID; ?>">
                           TravelID - <?php echo $edit->travel_code; ?> | Place - <?php echo $edit->place_of_visit; ?> | Date - <?php echo date('F d, Y', strtotime($edit->departure_date)); ?> | Client - <?php echo $edit->customer_name; ?> 
                        </option>
                        <?php $__currentLoopData = $travels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $travel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($travel->trID == $edit->expense_travelID ): ?><?php else: ?>
                              <option value="<?php echo $travel->trID; ?>">
                                 TravelID - <?php echo $travel->travel_code; ?> | Place - <?php echo $travel->place_of_visit; ?> | Date - <?php echo date('F d, Y', strtotime($travel->departure_date)); ?> | Client - <?php echo $travel->customer_name; ?> 
                              </option>
                           <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                        
                     </select>
                  </div>
                  <div class="form-group form-group-default required">
                     <?php echo Form::label('Title', 'Title', array('class'=>'control-label text-danger')); ?>

                     <?php echo Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'', 'autocomplete' => 'off' )); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="" class="text-danger">Choose Expense Category <a href="" class="pull-right" data-toggle="modal" data-target="#expenceCategory">Add category</a></label>
                     <select name="expense_category" id="selectCategory" class="form-control select2" required>
                        <?php if(Finance::check_expense_category($edit->expense_category) == 1): ?>
                           <option value="<?php echo $edit->expense_category; ?>"><?php echo Finance::expense_category($edit->expense_category)->category_name; ?></option>
                        <?php endif; ?>
                     </select>
                  </div>                 
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <div class="panel panel-default">
               <div class="panel-heading">Expense Details</div>
               <div class="panel-body">
                  <div class="form-group form-group-default required">
                     <?php echo Form::label('Date', 'Date', array('class'=>'control-label text-danger')); ?>

                     <?php echo Form::date('date', null, array('class' => 'form-control', 'placeholder' => 'YYYY-MM-DD', 'required' =>'', 'autocomplete' => 'off')); ?>

                  </div>
                  <div class="form-group form-group-default required">
                     <?php echo Form::label('Choose status', 'Choose status', array('class'=>'control-label text-danger')); ?>

                     <?php echo e(Form::select('status', [''=>'Choose status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ])); ?>

                  </div>
                  <div class="form-group form-group-default">
                     <label for="">Choose Files</label>
                     <input type="file" name="files[]" id="files" multiple>
                     <span class="badge badge-primary pull-right"><a href="#" class="text-white" data-toggle="modal" data-target=".expense-file">View documents</a></span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">Expense Items</div>
               <div class="panel-body">
                  <table class="table table-bordered table-striped table-responsive" id="table">
                     <thead>
                        <th width="1%">#</th>
                        <th width="40%">Title</th>
                        <th width="20%">Quantity</th>
                        <th width="20%">Price</th>
                        <th>Total</th>
                     </thead>
                     <tbody>
                        <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr>
                              <td><input class="case" type="checkbox"/></td>
                              <td>
                                 <div class="form-group">
                                    <textarea name="expense[]" class="form-control calculate" id="expense_1" cols="16" rows="2" required><?php echo $expense->expense; ?></textarea>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="number" name="quantity[]" value="<?php echo $expense->quantity; ?>" class="form-control calculate" id="quantity_1" placeholder="Enter Quantity" step="0.01" required>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="number" value="<?php echo $expense->price; ?>"  name="price[]" class="form-control calculate" id="price_1" placeholder="Enter Price" step="0.01" required>
                                 </div>
                              </td>
                              <td>
                                 <div class="form-group">
                                    <input type="number" value="<?php echo $expense->price * $expense->quantity; ?>"  class="form-control calculate lineSum" id="total_1" disabled>
                                 </div>
                              </td>
                           </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <td colspan="2" class="col-md-12 col-lg-8"></td>
                           <td colspan="2" style="width:20%">
                              <h4 class="pull-right top10">Total Amount</h4>
                           </td>
                           <td colspan="3">
                              <h4 class="text-center">
                                 <input readonly placeholder="0" type="number" value="<?php echo $edit->amount; ?>" class="form-control" id="totalAmount" step="0.01">
                              </h4>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
                  <div class="col-md-12">
                     <button class="btn btn-danger delete" type="button">- Delete</button>
                     <button class="btn btn-primary addmore" type="button">+ Add More</button>
                  </div>
               </div>
            </div>
         </div>
         <div class='col-md-12'>              
            <button class="pull-right btn btn-success" type="submit"><i class="fal fa-save"></i> Update Expense</button>
         </div>
         <!-- end panel -->         
      <?php echo Form::close(); ?>

   </div>
   <?php echo $__env->make('app.finance.expense.category.express', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <div class="modal fade expense-file" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Expense Files</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <div class="col-md-3">
                        <div class="card">
                           <div class="card-body">
                              <center>
                                 <?php if(Helper::like_match('%image%',$file->file_mime)): ?>
                                    <i class="fas fa-file-image fa-3x"></i>
                                 <?php elseif(Helper::like_match('%pdf%',$file->file_mime)): ?>
                                    <i class="fas fa-file-pdf fa-3x"></i>
                                 <?php elseif(Helper::like_match('%word%',$file->file_mime)): ?>
                                    <i class="fas fa-file-word fa-3x"></i>
                                 <?php elseif(Helper::like_match('%zip%',$file->file_mime)): ?>
                                    <i class="fas fa-file-archive fa-3x"></i>
                                 <?php elseif(Helper::like_match('%excel%',$file->file_mime)): ?>
                                    <i class="fas fa-file-excel fa-3x"></i>
                                 <?php elseif(Helper::like_match('%powerpoint%',$file->file_mime)): ?>
                                    <i class="fas fa-file-powerpoint fa-3x"></i>
                                 <?php elseif(Helper::like_match('%application%',$file->file_mime)): ?>
                                    <i class="far fa-file-code fa-3x"></i>
                                 <?php else: ?>
                                    <i class="far fa-file fa-3x"></i>
                                 <?php endif; ?>
                              </center>
                           </div>
                           <div class="card-footer">
                              <a href="<?php echo asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/'.$file->file_name); ?>" target="_blank" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                              <a href="<?php echo route('hrm.travel.expenses.delete.files',[$edit->expenseID,$file->id]); ?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
                           </div>
                        </div>
                     </div>       
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                             
               </div>
            </div>
         </div>
      </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
   <script>
      //adds extra table rows
      var i=$('table tr').length;
      var no = 0; 

      $(document).ready(function(){
         var x = 1;
         $(".addmore").click(function () {
            $("#table tbody tr:first").clone().find("input").each(function () {
            $(this).val('').attr({
               'id': function (_, id) {
                  return id + x
               }
            });
            }).end().appendTo("table");
            x++;
         }); 
      });

      //deletes the selected table rows
      $(".delete").on('click', function() {
         $('.case:checkbox:checked').parents("tr").remove();
         $('#check_all').prop("checked", false);
         calculateTotal();
      });

      //calculate amount
      $(document).on('keyup','.calculate',function(){
         id_arr = $(this).attr('id');
         id = id_arr.split("_");

         quantity = $('#quantity_'+id[1]).val();
         price = $('#price_'+id[1]).val();         
         amount = price * quantity;
         
         $('#total_'+id[1]).val(amount);
         calculateTotal();
      });

      //total price calculation
      function calculateTotal(){
         mainTotal = 0;

         //main total
         $('.lineSum').each(function(){
            if($(this).val() != '' )
            mainTotal += parseFloat($(this).val() );
            mainTotal = mainTotal;
         });
         $('#totalAmount').val(mainTotal.toFixed(2));
      }
   </script> 
   <?php echo $__env->make('app.partials._express_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/propertywingu/cloud.propertywingu.com/resources/views/app/hr/travel/expenses/edit.blade.php ENDPATH**/ ?>