@extends('layouts.app')
{{-- page header --}}
@section('title','Add New |  New Purchase Order')

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
         <li class="breadcrumb-item"><a href="{!! route('finance.lpo.index') !!}">Purchase Order</a></li>
         <li class="breadcrumb-item active">New Purchase Order</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-contract"></i> New Purchase Order</h1>
      @include('partials._messages')
      {!! Form::open(array('route' => 'finance.lpo.store', 'enctype'=>'multipart/form-data','method' => 'post','autocomplete' => 'off')) !!}
         @csrf
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default required">
                  <label for="client" class="text-danger">Supplier </label>
                  <select name="supplier" class="form-control multiselect"  required>
                     <option value="" selected>Choose Supplier</option>
                     @foreach ($suppliers as $cli)
                        <option value="{{ $cli->id }}"> {!! $cli->supplierName !!}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group">
                  <label for="number">Purchase Order</label>
                  <div class="input-group">
                     <span class="input-group-addon solso-pre">{{ Finance::lpo()->prefix }}</span>
                     <input type="text" name="lpo_number" class="form-control required no-line" autocomplete="off" value="{{ Finance::lpo()->number + 1 }}" readonly>
                  </div>
                  <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="number" class="">Reference # </label>
                  <div class="input-group">
                     {{ Form::text('reference_number',null, ['class' => 'form-control','placeholder' => 'Enter reference number']) }}
                  </div>
               </div>
            </div>
         </div>
         <div class='row'>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                   <label for="title">Title</label>
                   {!! Form::text('title',null,['class' => 'form-control', 'placeholder' => 'Enter title']) !!}
               </div>
           </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default required">
                  <label for="date" class="text-danger">Issue Date </label>
                  {!! Form::date('lpo_date', null, array('class' => 'form-control required', 'placeholder' => 'Enter date','required' => '')) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default required">
                  <label for="end" class="text-danger">Expected Delivery Date </label>
                  {!! Form::date('lpo_due', null, array('class' => 'form-control required', 'placeholder' => 'Enter date','required' => '')) !!}
               </div>
            </div>
            <div class="col-md-4 col-lg-4">
               <div class="form-group form-group-default">
                  <label for="" class="text-danger">Expense Category <a href="" class="pull-right" data-toggle="modal" data-target="#expenceCategory">Add Expense category</a></label>
                  <select name="expense_category" id="selectCategory" class="form-control select2" required></select>
               </div>
            </div>
         </div> 
         <div class="panel panel-default mt-2">
            <div class="panel-heading">
               <h4 class="panel-title">Purchase Order Items</h4>
            </div>
            <div class="panel-body">
               <div class='row mt-3'>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                     <table class="table table-bordered table-striped" id="lpoItem">
                        <thead>
                           <tr>
                              <th width="35%">Item Name</th>
                              <th width="13%">Quantity</th>
                              <th width="13%">Price</th>
                              <th width="13%">Discount()</th>
                              <th width="13%">Tax</th>
                              <th width="25%">Total</th>
                              <th></th>
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
                                    @foreach ($products as $prod)                                       
                                       <option value="{{ $prod->productID }}"> 
                                          {{ substr($prod->product_name, 0, 100) }} {{ strlen($prod->product_name) > 100 ? '...' : '' }} 
                                          @if($prod->type == 'product' && $prod->current_stock <= 0 )***** OUT OF STOCK ***** @endif
                                       </option>
                                    @endforeach
                                 </select> 
                              </td>                                 
                              <td> 
                                 <input type="number" name="qty[]" id="quantity_1" class="form-control changesNo quanyityChange" required>
                              </td>
                              <td>
                                 <input type="number" name="price[]" id="price_1" class="form-control changesNo" autocomplete="off" step="0.01" required>
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
                                    <option value="">Remove Tax</option>
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
         <div class='row mt-3'>
            <div class="col-md-6 mt-3">
               <label for="">Supplier Notes</label>
               <textarea name="customer_note" class="form-control ckeditor" rows="8" cols="80">{!! Finance::lpo()->default_customer_notes !!}</textarea>
            </div>
            <div class="col-md-6 mt-3">
               <label for="">Terms & Conditions</label>
               <textarea name="terms" class="form-control ckeditor" rows="8" cols="80">{!! Finance::lpo()->default_terms_conditions !!}</textarea>
            </div>
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
               <div class='form-group text-center'>
                  <center>
                     <button type="submit"class="btn btn-pink btn-lg"><i class="fas fa-save"></i> Save Purchase Order </button>
                     {{-- <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%"> --}}
                  </center>
               </div>
            </div>
         </div>
      {{ Form::close() }}
   </div>
   @include('app.finance.expense.category.express')
@endsection	
@include('app.finance.partials._lpo')
