<div class="col-md-12">
   <div class="row">
      <div class="col-md-12">
         <div class="panel">
            <div class="panel-heading">Bank 3 information</div>
            <div class="panel-body">
               {!! Form::model($bank, ['route' => ['property.bank3.integration.update',[$property->id,$bank->integrationID]], 'method'=>'post']) !!}
                  @csrf
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group form-group-default required">
                           {!! Form::label('name', 'Bank Name', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('bank_name', null, array('class' => 'form-control', 'placeholder' => 'Enter bank name', 'required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default">
                           {!! Form::label('branch', 'Branch', array('class'=>'control-label')) !!}
                           {!! Form::text('bank_branch', null, array('class' => 'form-control', 'placeholder' => 'Enter branch')) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required ">
                           {!! Form::label('Account', 'Account Name', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('bank_account_name', null, array('class' => 'form-control', 'placeholder' => 'Enter account name', 'required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group form-group-default required ">
                           {!! Form::label('account number', 'Account Number', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('bank_account_number', null, array('class' => 'form-control', 'placeholder' => 'Enter account number', 'required' => '')) !!}
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
                           <button type="submit" class="btn btn-success submit"><i class="fas fa-save"></i> Update Bank Details</button>
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