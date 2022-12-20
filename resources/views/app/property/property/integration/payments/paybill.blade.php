<div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div class="panel">
            <div class="panel-heading">Mpesa Paybill</div>
            <div class="panel-body">
               {!! Form::model($mpesaPaybill, ['route' => ['property.mpesapaybill.integration.update',[$property->id,$mpesaPaybill->integrationID]], 'method'=>'post']) !!}
                  @csrf
                  <div class="form-group form-group-default">
                     <label for="name" class="text-danger">Business Name</label>
                     {!! Form::text('business_name',null,['class' => 'form-control','placeholder' => 'Enter business name','required' => '']) !!}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="name" class="text-danger">Paybill Number</label>
                     {!! Form::text('paybill_number',null,['class' => 'form-control','placeholder' => 'Enter paybill number','required' => '']) !!}
                  </div>
                  <div class="form-group form-group-default">
                     <label for="name" class="text-danger">Account Number</label>
                     {!! Form::text('paybill_account',null,['class' => 'form-control','required' => '','placeholder' => 'Account defination']) !!}
                  </div>
                  <div class="form-group required required">
                     <label for="">Choose status</label>
                     {!! Form::select('status',['15' => 'Active', '23' => 'Closed'], null,['class' => 'form-control'] ) !!}
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Paybill</button>
                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>      
   </div>
</div>