@extends('layouts.app')
{{-- page header --}}
@section('title','Edit | Sales Order')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.salesorders.index') !!}">Sales orders</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-cart-arrow-down"></i>  Edit Sales Order </h1>
      @include('partials._messages')
      {!! Form::model($salesorder, ['route' => ['finance.salesorders.update',$salesorder->salesorderID], 'method'=>'post']) !!}
         @csrf
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="client" class="text-danger">Choose Customer *</label>
                  <select name="customer" class="form-control multiselect" required>
                     <option selected value="{{ $salesorder->customerID }}">{!! $salesorder->customer_name !!}</option>
                     <option value=""><b>Choose Customer</b></option>
                     @foreach ($clients as $cli)
                        <option value="{{ $cli->id }}">{!! $cli->customer_name !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group">
                  <label for="number">Invoice Number</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre">{{ $salesorder->prefix }}</span>
                     {!! Form::text('salesorder_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')) !!}
                  </div>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Reference Number # </label>
                  <div class="input-group">
                     <input type="text" name="reference" class="form-control" value="{{ $salesorder->reference }}" >
                  </div>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
                <div class="form-group form-group-default">
                    <label for="end">Subject</label>
                    {!! Form::text('subject', null, array('class' => 'form-control', 'placeholder' => 'Enter subject'))!!}
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="date" class="text-danger">Sales Order Date *</label>
                  {!! Form::date('salesorder_date', null, array('class' => 'form-control datepicker','required' => '')) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Due Date * </label>
                  {!! Form::date('salesorder_due_date', null, array('class' => 'form-control datepicker','required' => '')) !!}
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end"> Items are 
                     <span class="pull-right" data-toggle="tooltip" data-placement="top" title="If the amount is tax exlusive the tax field will be hidden on the invoice view">
                        <i class="fas fa-info-circle"></i>
                     </span>
                  </label> 
                  {!! Form::select('taxconfig',['Inclusive' => 'Tax Inclusive','Exclusive' => 'Tax Exclusive'],null,['class' => 'form-control multiselect', 'id' => 'taxconfig' ]) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Sales person</label>
                  {!! Form::select('salesperson',$salespersons,null,['class' => 'form-control multiselect']) !!}
               </div>
            </div>
         </div>
         <div class="panel panel-default mt-3">
            <div class="panel-heading">
               <h4 class="panel-title">Sales Order Items</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                     <table class="table table-bordered table-striped" id="invoiceItems">
                        <thead>
                           <tr>
                              <th width="35%">Item Name</th>
                              <th width="13%">Quantity</th>
                              <th width="13%">Price</th>
                              <th width="13%">Discount({!! $salesorder->symbol !!})</th>
                              <th width="13%">Tax</th>
                              <th width="25%">Total</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($salesorderProducts as $product)
                              <tr class="clone-item">
                                 <td>
                                    <select name="productID[]" class="form-control dublicateSelect2 onchange solsoCloneSelect2" id="itemName_1" data-init-plugin='select2' required>
                                       <option value="{{ $product->productID }}">
                                          @if(Finance::check_product($product->productID) == 1)
                                             {!! Finance::product($product->productID)->product_name !!}
                                          @else
                                             <i>Unknown Product</i>
                                          @endif
                                       </option>
                                       @foreach ($products as $prod)
                                          <option value="{{ $prod->id }}"> {!! $prod->product_name !!} </option>
                                       @endforeach
                                    </select>
                                    <?php echo $errors->first('currency', '<p class="error">:messages</p>');?>
                                 </td>
                                 <td>
                                    <input type="number" name="qty[]" id="quantity_1" value="{{ $product->quantity }}" class="form-control changesNo quanyityChange" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                 </td>
                                 <td>
                                    <input type="number" name="price[]" id="price_1" value="{{ $product->selling_price }}" class="form-control onchange changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" step="0.01">
                                 </td> 
                                 <td>
                                    <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" value="{{ $product->discount }}" autocomplete="off" step="0.01">
                                 </td>
                                 <td>
                                    <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">
                                       @if($product->taxrate == 0 || $product->taxrate == "")
                                          <option value="0">Choose tax rate</option>
                                       @else 
                                          <option value="{!! $product->taxrate !!}">{!! $product->taxrate !!}%</option>
                                       @endif
                                       @foreach ($taxs as $tx)
                                          <option value="{{ $tx->rate }}"> {{ $tx->name }}-{{ $tx->rate }}%</option>
                                       @endforeach
                                       <option value="" class="text-danger">Remove Tax</option>
                                    </select>
                                    <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" value="{!! $product->taxvalue !!}" autocomplete="off" step="0.01" readonly>
                                 </td>
                                 <td>
                                    <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" value="{!! $product->quantity * $product->selling_price !!}" placeholder="Main Amount" step="0.01" readonly>
                                    <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" value="{!! $product->sub_total !!}" placeholder="Total Amount" step="0.01" readonly>
                                    <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" value="{!! $product->total_amount !!}"  placeholder="Total Sum" step="0.01" readonly>
                                 </td>
                                 <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                              </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Amount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="{!! $salesorder->main_amount !!}" type="number" class="form-control" id="mainAmountF" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Discount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">                                    
                                    <input readonly type="number" value="{!! $salesorder->discount !!}" class="form-control" id="discountTotal" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Sub Total</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly type="number" value="{!! $salesorder->sub_total !!}" class="form-control" id="subTotal" step="0.01">
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
                                    <input readonly type="number" class="form-control" value="{!! $salesorder->taxvalue !!}" id="taxvalue" step="0.01">
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
                                    <input readonly type="number" class="form-control" id="InvoicetotalAmount" value="{!! $salesorder->total !!}" placeholder="Total" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
               <div class='row mb-3'>
                  <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                     <a class="btn btn-primary" id="addRows" href="javascript:;"><i class="fal fa-plus-circle"></i> Add More</a>
                  </div>
               </div>
               <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            </div>
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Sales Note | Terms & conditions</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class="col-md-6 mt-3">
                     <label for="">Customer Notes</label>
                     <textarea name="customer_note" class="form-control ckeditor" rows="8" cols="80">{!! $salesorder->customer_note !!}</textarea>
                  </div>
                  <div class="col-md-6 mt-3">
                     <label for="">Terms & Conditions</label>
                     <textarea name="terms_conditions" class="form-control ckeditor" rows="8" cols="80">{!! $salesorder->terms_conditions !!}</textarea>
                  </div>
               </div>
            </div>
         </div>
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
            <div class='form-group text-center'>
               <center>
                  <button type="submit"class="btn btn-pink btn-lg"><i class="fas fa-save"></i> Update sales order  </button>
                  {{-- <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%"> --}}
               </center>
            </div>
         </div>
      {{ Form::close() }}
   </div>
@endsection
@include('app.finance.partials._invoice')
