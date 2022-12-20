<div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div class="panel">
            <div class="panel-heading">Mpesa Till</div>
            <div class="panel-body">
               {!! Form::model($mpesaTill, ['route' => ['property.mpesatill.integration.update',[$property->id,$mpesaTill->integrationID]], 'method'=>'post']) !!}
                  @csrf
                  <div class="form-group form-group-default required">
                     <label for="name" class="text-danger">Business Name</label>
                     {!! Form::text('business_name',null,['class' => 'form-control','placeholder' => 'Enter business name','form-group-default required' => '']) !!}
                  </div>
                  <div class="form-group form-group-default required">
                     <label for="name" class="text-danger">Till Number</label>
                     {!! Form::text('till_number',null,['class' => 'form-control','placeholder' => 'Enter Till Number','required' => '']) !!}
                  </div>
                  <div class="form-group required required">
                     <label for="">Choose status</label>
                     {!! Form::select('status',['15' => 'Active', '23' => 'Closed'], null,['class' => 'form-control'] ) !!}
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Till Information</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>      
   </div>
</div>