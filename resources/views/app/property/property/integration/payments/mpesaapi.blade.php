<div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div class="panel">
            <div class="panel-heading">Mpesa API</div>
            <div class="panel-body">
               {!! Form::model($mpesaApi, ['route' => ['property.mpesaapi.integration.update',[$property->id,$mpesaApi->integrationID]], 'method'=>'post','autocomplete' => 'off']) !!}
                  @csrf
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Business Name</label>
                           {!! Form::text('business_name',null,['class' => 'form-control','placeholder' => 'Enter Business Name','required' => '']) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Consumer key</label>
                           {!! Form::text('customer_key',null,['class' => 'form-control','placeholder' => 'Enter customer key','required' => '']) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Customer secret</label>
                           {!! Form::text('customer_secret',null,['class' => 'form-control','required' => '','placeholder' => 'Enter customer secret']) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="name" class="text-danger">Iframelink</label>
                           {!! Form::text('iframelink',null,['class' => 'form-control','required' => '', 'placeholder' => 'Enter customer iframelink']) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="name" class="text-danger">Callback url</label>
                           {!! Form::textarea('callback_url',null,['class' => 'form-control','required' => '', 'size' => '5x5', 'placeholder' => 'Enter customer callback url']) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           <label for="">Choose status</label>
                           {!! Form::select('status',['15' => 'Active', '23' => 'Closed'], null,['class' => 'form-control'] ) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Mpesa API</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                        </div>
                     </div>
                  </div>
               {!! Form::close() !!}
            </div>
         </div>
      </div>      
   </div>
</div>