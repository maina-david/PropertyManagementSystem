<div class="row"> 
   <form method="post" action="{!! route('licenses.maintenances.store',$details->id) !!}" autocomplete="off" class="col-md-8">
      @csrf   
      <div class="row">
         <div class="col-md-6">
            <div class="form-group form-group-default required">
               <label for="">Supplier</label>
               {!! Form::select('supplier',$suppliers,null,['class'=>'form-control multiselect', 'required' => '']) !!}
            </div>
         </div>   
         <div class="col-md-6">
            <div class="form-group form-group-default">
               <label for="">Asset Maintenance Type</label>
               {!! Form::select('maintenance_type',['' => 'Select an asset maintenance type','Maintenance' => 'Maintenance','Repair' => 'Repair','Upgrade' => 'Upgrade','PAT test' => 'PAT test','Calibration' => 'Calibration','Software Support' => 'Software Support','Hardware Support' => 'Hardware Support'],null,['class'=>'form-control multiselect']) !!}
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default required">
               <label for="">Title</label>
               {!! Form::text('title',null,['class'=>'form-control','placeholder' => 'Enter title', 'required' => '']) !!}
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default required">
               <label for="">Start Date</label>
               {!! Form::text('start_date',null,['class'=>'form-control datetimepicker' ,'placeholder' => 'Choose date', 'required' => '']) !!}
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default">
               <label for="">Completion Date</label>
               {!! Form::text('completion_date',null,['class'=>'form-control datetimepicker','placeholder' => 'Choose date']) !!}
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default">
               <label for="">Warranty Improvement</label>
               {!! Form::select('warranty_improvement',['' => 'Choose', 'No' => 'No', 'Yes' => 'Yes'],null,['class'=>'form-control multiselect']) !!}
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group form-group-default">
               <label for="">Cost</label>
               {!! Form::number('cost',null,['class'=>'form-control','placeholder' => 'Enter cost']) !!}
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group">
               <label for="">Maintenance Notes</label>
               {!! Form::textarea('note',null,['class'=>'form-control ckeditor']) !!}
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group">
               <center>
                  <button class="btn btn-pink submit" type="submit"><i class="fas fa-save"></i> Save information</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
               </center>         
            </div>
         </div>
      </div>
   </form>
</div>