@extends('layouts.app')
{{-- page header --}}
@section('title','Add New | Invoice')

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
         <li class="breadcrumb-item"><a href="{!! route('finance.invoice.index') !!}">Invoice</a></li>
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> New Invoice</h1>
      @include('partials._messages')
      {{ Form::open(array('route' => 'finance.invoice.product.store', 'role' => 'form', 'class' => 'solsoForm')) }}
         @csrf
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="customer" class="text-danger">Choose Customer * <a href="" class="pull-right" data-toggle="modal" data-target="#addExpressCustomer">Add Customer</a></label>
                  <select name="customer" id="getCustomers" class="form-control select2" required></select>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group">
                  <label for="number">Invoice Number</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre">{{ Finance::invoice_settings()->prefix }}</span>
                     <input type="text" name="invoice_number" class="form-control required no-line" autocomplete="off" value="{{ Finance::invoice_settings()->number + 1 }}" readonly>
                  </div>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number">Order Number #</label>
                  <div class="input-group">
                     <input type="text" name="lpo_number" class="form-control required" placeholder="Enter order number" autocomplete="off" >
                  </div>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
                <div class="form-group form-group-default">
                    <label for="end">Subject</label>
                    <input type="text" name="invoice_title" class="form-control" autocomplete="off" placeholder = "Enter invoice title">
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="date" class="text-danger">Issue Date *</label>
                  <input type="date" name="invoice_date" class="form-control" autocomplete="off" required>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">Due Date * </label>
                  <input type="date" name="invoice_due" class="form-control required" autocomplete="off" required>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end"> Amounts are 
                     <span class="pull-right" data-toggle="tooltip" data-placement="top" title="If the amount is tax exlusive the tax field will be hidden on the invoice view">
                        <i class="fas fa-info-circle"></i>
                     </span>
                  </label> 
                  {!! Form::select('taxconfig',['Inclusive' => 'Tax Inclusive','Exclusive' => 'Tax Exclusive'],null,['class' => 'form-control multiselect', 'id' => 'taxconfig' ]) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end">Sales person</label>
                  {!! Form::select('salesperson',$salespersons,null,['class' => 'form-control multiselect']) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="end" class="text-danger">
                     Income account * 
                     <a href="" class="pull-right" data-toggle="modal" data-target="#addExpressIncome">Add Income</a>
                     <span class="pull-right mr-1" data-toggle="tooltip" data-placement="top" title="This will help in categorising the invoice to specific income categories">
                        <i class="fas fa-info-circle"></i>
                     </span>
                  </label>
                  <select name="income_category" id="getIncomeCategory" class="form-control select2" required></select>
               </div>
            </div>
         </div>

         <div class="panel panel-default mt-3">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice Items</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <table class="table table-bordered table-striped" id="invoiceItems">
                        <thead>
                           <tr>
                              <th width="35%">Item Name</th>
                              <th width="13%">Quantity</th>
                              <th width="13%">Price</th>
                              <th width="13%">Discount()</th>
                              <th width="13%">Tax</th>
                              <th width="25%">Total</th>
                              <th width=""></th>
                           </tr>
                        </thead>
                        <?php
                           $count = 1;
                        ?>
                        <tbody> 
                           <tr class="clone-item">
                              <td>
                                 <select name="productID[]" class="form-control dublicateSelect2 onchange solsoCloneSelect2" id="itemName_1" data-init-plugin='select2' required>
                                    <option value="">Choose Producrs</option>
                                    @foreach ($Itemproducts as $prod)                                       
                                       <option value="{{ $prod->productID }}"> 
                                          {{ substr($prod->product_name, 0, 100) }} {{ strlen($prod->product_name) > 100 ? '...' : '' }} 
                                          @if($prod->track_inventory == 'Yes')
                                             @if($prod->type == 'product' && $prod->current_stock <= 0 )***** OUT OF STOCK ***** @endif
                                          @endif
                                       </option>
                                    @endforeach
                                    @foreach ($Itemservice as $service)                                       
                                       <option value="{{ $service->productID }}"> 
                                          {{ substr($service->product_name, 0, 100) }} {{ strlen($service->product_name) > 100 ? '...' : '' }} 
                                       </option>
                                    @endforeach
                                 </select> 
                              </td>                                 
                              <td> 
                                 <input type="number" name="qty[]" id="quantity_1" class="form-control changesNo quanyityChange">
                              </td>
                              <td>
                                 <input type="number" name="price[]" id="price_1" class="form-control changesNo" autocomplete="off" step="0.01">
                              </td>
                              <td>
                                 <input type="number" name="discount[]" id="discount_1" class="form-control discount changesNo" autocomplete="off" step="0.01" >
                              </td>
                              <td>
                                 <select name="tax[]" class="form-control changesNo onchange" id="tax_1" autocomplete="off">                                    
                                    <option value="0">Choose tax rate</option>
                                    @foreach ($taxs as $tx)
                                       <option value="{{ $tx->rate }}"> {{ $tx->name }}-{{ $tx->rate }}%</option>
                                    @endforeach
                                    <option value="" class="text-danger">Remove Tax</option>
                                 </select>
                                 <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" autocomplete="off" step="0.01" readonly>
                              </td>
                              <td>
                                 <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" placeholder="Main Amount" step="0.01" readonly>
                                 <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" placeholder="Total Amount" step="0.01" readonly>
                                 <input type="text" id="sum_1" class="form-control totalSum addNewRow" autocomplete="off" placeholder="Total Sum" step="0.01" readonly>
                              </td>
                              <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                           </tr>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Amount</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="0" type="number" class="form-control" id="mainAmountF" step="0.01">
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
                                    <input readonly value="0" type="number" class="form-control" id="discountTotal" step="0.01">
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
                                    <input readonly value="0" type="number" class="form-control" id="subTotal" step="0.01">
                                 </h4>
                              </td>
                           </tr>
                           <tr>
                              <td colspan="2" class="col-md-12 col-lg-8"></td>
                              <td colspan="2" style="width:20%">
                                 <h4 class="pull-right top10">Tax</h4>
                              </td>
                              <td colspan="3">
                                 <h4 class="text-center">
                                    <input readonly value="0" type="number" class="form-control" id="taxvalue" step="0.01">
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
                                    <input readonly value="0" type="number" class="form-control" id="InvoicetotalAmount" placeholder="Total" step="0.01">
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
            </div>
         </div>
         {{-- <div class="panel panel-default">
            <div class="panel-heading">
               <div class="panel-heading-btn">
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
               </div>
               <h4 class="panel-title">Add Payments</h4>
            </div>
            <div class="panel-body">
               <div class="row mt-3">
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <label for="paymentAmount">Amount Paid</label>
                        <input type="number" name="paymentAmount" class="form-control" autocomplete="off"	placeholder="Enter amount">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <label for="paymentDate">Payment Date</label>
                        <input type="text" name="paymentDate" class="form-control datepicker" placeholder="Choose date" autocomplete="off">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group form-group-default">
                        <label for="paymentMethod">Payment Method</label>
                        <select name="paymentMethod" class="form-control multiselect">
                           <option value="" selected>Choose Payment Type</option>
                           @foreach ($paymenttypes as $pt)
                                 <option value="{{ $pt->id }}"> {{ $pt->name }} </option>
                           @endforeach
                        </select>
                     </div>
                  </div>
               </div>
            </div>
         </div> --}}
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Invoice Note | Terms & conditions</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class="col-md-6 mt-3">
                     <label for="">Customer Notes</label>
                     <textarea name="customer_note" class="form-control ckeditor" rows="8" cols="80">{!! Finance::invoice_settings()->default_customer_notes !!}</textarea>
                  </div>
                  <div class="col-md-6 mt-3">
                     <label for="">Terms & Conditions</label>
                     <textarea name="terms" class="form-control ckeditor" rows="8" cols="80">{!! Finance::invoice_settings()->default_terms_conditions !!}</textarea>
                  </div>
               </div>
            </div>
         </div>
         <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
         <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
            <div class='form-group text-center'>
               <center>
                  <button type="submit" class="btn btn-pink btn-lg"><i class="fas fa-save"></i> Create Invoice </button>
                  {{-- <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="invoice-load none" alt="" width="15%"> --}}
               </center>
            </div>
         </div>
      {{ Form::close() }}
   </div>
   @include('app.finance.contacts.express')
   @include('app.finance.income.express')
@endsection
@include('app.finance.partials._invoice')
@section('script2')
   <script type="text/javascript">
      $(document).ready(function(){
         $("form").on("submit", function(){
            $(".save-invoice").hide();
            $(".invoice-load").show();
         });//submit
      });//document ready
   </script> 
   
@endsection