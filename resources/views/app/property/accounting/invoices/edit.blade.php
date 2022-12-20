@extends('layouts.app')
@section('title'){!! $property->title !!} | Billing | Edit Invoices @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="#">Billing</a></li>
         <li class="breadcrumb-item active"><a href="#">Edit</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> {!! $property->title !!} | Billing | Edit Invoices</h1>
      
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-12">
                  {!! Form::model($invoice, ['route' => ['property.invoice.update',[$invoice->id,$propertyID]], 'method'=>'post']) !!}
                     @csrf
                     <div class="panel">
                        <div class="panel-body">
                           <div class="row">
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="tenant" class="text-danger">Choose Tenant *</label>
                                    <select name="tenant" class="form-control multiselect" id="tenant" required>
                                       <option selected value="{{ $invoice->tenantID }}">{!! $tenant->tenant_name !!}</option>
                                       @if($invoice->tenantID == "")
                                          <option value=""><b>Choose tenant</b></option>
                                       @endif
                                       @foreach($tenants as $tnt)
                                          <option value="{{ $tnt->tenantID }}">{!! $tnt->tenant_name !!}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group">
                                    <label for="number">Invoice Number</label>
                                    <div class="input-group mb-2">
                                       <div class="input-group-prepend">
                                          @if($invoice->invoice_prefix != "")
                                             <div class="input-group-text">{{ $invoice->invoice_prefix }}</div>
                                          @else 
                                             <div class="input-group-text">{{ $invoiceSetting->prefix }}</div>
                                          @endif
                                       </div>
                                       {!! Form::text('invoice_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')) !!}
                                 </div>
                                 </div>                        
                              </div> 
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="date" class="text-danger">Issue Date *</label>
                                    {!! Form::date('invoice_date', null, array('class' => 'form-control', 'placeholder' => 'YYY-MM-DD','required' => '')) !!}
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="end" class="text-danger">Due Date * </label>
                                    {!! Form::date('invoice_due', null, array('class' => 'form-control', 'placeholder' => 'YYY-MM-DD','required' => '')) !!}
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <label for="" class="text-danger">Choose Category</label>
                                 <div class="form-group form-group-default">
                                    <select name="income_category" class="form-control multiselect"> 
                                       <option value="{!! $invoice->income_category !!}">{!! Finance::original_income_category($invoice->income_category)->name !!}</option>
                                       @foreach($incomes as $income)
                                          <option value="{!! $income->id !!}">{!! $income->name !!}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="end">Subject</label>
                                    {!! Form::text('invoice_title',null,['class'=>'form-control']) !!}
                                 </div>
                           </div>
                           <div class="col-md-3 col-lg-3">
                              <div class="form-group form-group-default required">
                                 <label for="end" class="text-danger">Unit #</label>
                                 <select name="leaseID" id="leases" class="form-control" required>
                                    <option value="{!! $invoice->leaseID !!}">{!! $tenant->serial !!}</option>
                                 </select>
                              </div> 
                           </div>
                           </div>                  
                        </div>
                     </div>
                     <div class="panel panel-default mt-3">
                        <div class="panel-heading">
                           <h4 class="panel-title"><b>Invoice Items</b></h4>
                        </div>
                        <div class="panel-body">
                           <div class='row mt-3'>
                              <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                 <table class="table table-bordered table-striped" id="table">
                                    <thead>
                                       <tr>
                                          <th width="2%"><input id="check_all" class="formcontrol" type="checkbox"/></th>
                                          <th width="35%">Item Name</th>
                                          <th width="13%">Quantity</th>
                                          <th width="13%">Price</th>
                                          <th width="13%">Tax</th>
                                          <th width="25%">Total</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($products as $product)
                                          <tr>
                                             <td><input class="case" type="checkbox"/></td>
                                             <td>
                                                <textarea type="text" name="product_name[]" class="form-control" id="itemName_1">{!! $product->item_name !!}</textarea>
                                             </td>
                                             <td>
                                                <input type="number" name="qty[]" id="quantity_1" value="{{ $product->quantity }}" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                             </td>
                                             <td>
                                                <input type="number" name="price[]" id="price_1" value="{{ $product->price }}" class="form-control onchange changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                             </td> 
                                             <td>
                                                <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                                   @if($product->taxrate == 0 || $product->taxrate == "")
                                                      <option value="0">Choose tax rate</option>
                                                   @else 
                                                      <option value="{!! $product->taxrate !!}">{!! $product->taxrate !!}%</option>
                                                   @endif
                                                   <option value="0">No Tax</option>
                                                   @foreach ($taxes as $tx)
                                                      <option value="{{ $tx->rate }}"> {{ $tx->name }}-{{ $tx->rate }}%</option>
                                                   @endforeach
                                                </select>
                                                <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" value="{!! $product->taxvalue !!}" autocomplete="off" step="0.01" readonly>
                                             </td>
                                             <td>
                                                <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" value="{!! $product->quantity * $product->price !!}" placeholder="Main Amount" step="0.01" readonly>
                                                <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" value="{!! $product->sub_total !!}" placeholder="Total Amount" step="0.01" readonly>
                                                <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" value="{!! $product->total_amount !!}"  placeholder="Total Sum" step="0.01" readonly>
                                             </td>
                                          </tr>
                                       @endforeach
                                    </tbody>
                                    <tfoot>
                                       {{-- <tr>
                                          <td colspan="2" class="col-md-12 col-lg-8"></td>
                                          <td colspan="2" style="width:20%">
                                             <h4 class="pull-right top10">Amount</h4>
                                          </td>
                                          <td colspan="3">
                                             <h4 class="text-center">
                                                <input readonly value="{!! $invoice->main_amount !!}" type="number" class="form-control" id="mainAmountF" step="0.01">
                                             </h4>
                                          </td>
                                       </tr> --}}
                                       <tr>
                                          <td colspan="2" class="col-md-12 col-lg-8"></td>
                                          <td colspan="2" style="width:20%">
                                             <h4 class="pull-right top10">Sub Total</h4>
                                          </td>
                                          <td colspan="3">
                                             <h4 class="text-center">
                                                <input readonly type="number" value="{!! $invoice->sub_total !!}" class="form-control" id="subTotal" step="0.01">
                                             </h4>
                                          </td>
                                       </tr>
                                       <tr id="taxfield">
                                          <td colspan="2" class="col-md-12 col-lg-8"></td>
                                          <td colspan="2" style="width:20%">
                                             <h4 class="pull-right top10">Tax</h4>
                                          </td>
                                          <td colspan="3">
                                             <h4 class="text-center">
                                                <input readonly type="number" class="form-control" value="{!! $invoice->taxvalue !!}" id="taxvalue" step="0.01">
                                             </h4>
                                          </td>
                                       </tr>
                                       <tr class="table-default">
                                          <td colspan="2" class="col-md-12 col-lg-8"></td>
                                          <td colspan="2" style="width:20%">
                                             <h4 class="pull-right top10">Total Amount</h4>
                                          </td>
                                          <td colspan="3">
                                             <h4 class="text-center">
                                                <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="{!! $invoice->total !!}" placeholder="Total" step="0.01">
                                             </h4>
                                          </td>
                                       </tr>
                                    </tfoot>
                                 </table>
                              </div>
                           </div>
                           <div class='row mb-3'>
                              <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                                 <button class="btn btn-danger delete" type="button">- Delete</button>
                                 <button class="btn btn-primary addmore" type="button">+ Add More</button>
                              </div>
                           </div>
                           <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        </div>
                     </div>
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <h4 class="panel-title">Invoice Note | Terms & conditions</h4>
                        </div>
                        <div class="panel-body">
                           <div class='row mt-3'>
                              <div class="col-md-6 mt-3">
                                 <label for="">Customer Notes</label>
                                 <textarea name="customer_note" class="form-control my-editor" rows="8" cols="80">{!! $invoice->customer_note !!}</textarea>
                              </div>
                              <div class="col-md-6 mt-3">
                                 <label for="">Terms & Conditions</label>
                                 <textarea name="terms" class="form-control my-editor" rows="8" cols="80">{!! $invoice->terms !!}</textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                        <div class='form-group text-center'>
                           <center>
                              <button type="submit"class="btn btn-success btn-lg submit"><i class="fas fa-save"></i> Update Invoice </button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                           </center>
                        </div>
                     </div>
                  {{ Form::close() }}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@include('app.property.partials._invoice')
@section('script2')
   <script type="text/javascript">
      $('#tenant').on('change',function(e){
         console.log(e);
         var tenant =  e.target.value;
         var propertyID =  "{{ $propertyID }}";
         var url = "{{ url('/') }}";

         //ajax 
         $.get(url+'/property-management/property/'+propertyID+'/invoices/'+tenant+'/leases', function(data){
            //success data
            $('#leases').empty();
            $.each(data, function(leases, lease){
               $('#leases').append('<option value="'+ lease.leaseID +'">'+lease.serial+'</option>');
            });
         });
      });
   </script>
@endsection
