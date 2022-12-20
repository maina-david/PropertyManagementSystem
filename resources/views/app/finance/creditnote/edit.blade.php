@extends('layouts.app')
{{-- page header --}}
@section('title','Update Credit note')
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
         <li class="breadcrumb-item"><a href="{!! route('finance.creditnote.index') !!}">Credit note</a></li>
         <li class="breadcrumb-item active">Update</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-credit-card"></i> Update Credit note</h1>
      @include('partials._messages')
      
         {!! Form::model($creditnote, ['route' => ['finance.creditnote.update',$creditnote->id], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data','autocomplete' => 'off']) !!}
            @csrf
            <div class='row'>
               <div class="col-md-6 col-lg-6">
                  <div class="form-group form-group-default">
                     <label for="customer" class="text-danger">Customer</label>
                     <select name="customer" class="form-control multiselect" id="client_select" required>
                        <option value="{!! $creditnote->customerID !!}">{!! $client->customer_name !!}</option>
                        @foreach ($clients as $cli)
                           <option value="{{ $cli->id }}">{!! $cli->customer_name !!}</option>
                        @endforeach
                     </select>
                     <?php echo $errors->first('client', '<p class="error">:messages</p>');?>
                  </div>
               </div>
               <div class="col-md-6 col-lg-6">
                  <div class="form-group">
                     <label for="number">Credit Note Number</label>
                     <div class="input-group">
                        <span class="input-group-addon solso-pre">{{ Finance::creditnote()->prefix }}</span>
                        {!! Form::text('creditnote_number', null, array('class' => 'form-control equired no-line', 'autocomplete' => 'off', 'placeholder' => '','readonly' => '')) !!}
                     </div>
                     <?php echo $errors->first('number', '<p class="error">:messages</p>');?>
                  </div>
               </div>
               <div class="col-md-4 col-lg-4">
                  <div class="form-group form-group-default">
                     <label for="number" class="">Title</label>
                     {!! Form::text('title', null ,['class' => 'form-control','placeholder' => 'Enter title']) !!}
                  </div>
               </div>
               <div class="col-md-4 col-lg-4">
                  <div class="form-group form-group-default">
                     <label for="number" class="">Reference number #</label>
                     {!! Form::text('reference_number', null ,['class' => 'form-control','placeholder' => 'Enter Reference Number']) !!}
                  </div>
               </div>
               <div class="col-md-4 col-lg-4">
                  <div class="form-group form-group-default">
                     <label for="date" class="text-danger">Credit Note Date *</label>
                     {!! Form::text('creditnote_date', null ,['class' => 'form-control required datepicker','placeholder' => 'Choose date','required' => '']) !!}
                  </div>
               </div>
            </div>
            <div class="panel panel-default mt-3">
               <div class="panel-heading">
                  <h4 class="panel-title">Credit note Items</h4>
               </div>
               <div class="panel-body">
                  <div class='row mt-3'>
                     <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                        <table class="table table-bordered table-striped" id="lpoItem">
                           <thead>
                              <tr>
                                 <th width="38%">Item Name</th>
                                 <th width="15%">Price</th>
                                 <th width="15%">Quantity</th>
                                 <th width="15%">Total</th>
                                 <th width="1%"></th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($creditProducts as $product)
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
                                          @foreach($Itemproducts as $prod)                                       
                                             <option value="{{ $prod->productID }}"> 
                                                {{ substr($prod->product_name, 0, 100) }} {{ strlen($prod->product_name) > 100 ? '...' : '' }} 
                                                @if($prod->track_inventory == 'Yes')
                                                   @if($prod->type == 'product' && $prod->current_stock <= 0 )***** OUT OF STOCK ***** @endif
                                                @endif
                                             </option>
                                          @endforeach
                                          @foreach($Itemservice as $service)                                       
                                             <option value="{{ $service->productID }}"> 
                                                {{ substr($service->product_name, 0, 100) }} {{ strlen($service->product_name) > 100 ? '...' : '' }} 
                                             </option>
                                          @endforeach
                                       </select>
                                    </td>                                 
                                    <td> 
                                       <input type="number" name="qty[]" id="quantity_1" value="{{ $product->quantity }}" class="form-control changesNo quanyityChange" required>
                                    </td>
                                    <td>
                                       <input type="number" name="price[]" id="price_1"  value="{{ $product->price }}" class="form-control changesNo" autocomplete="off" step="0.01" required>
                                    </td>
                                    <td class="none">
                                       <input type="number"  id="discount_1" class="form-control discount changesNo" autocomplete="off" step="0.01" >
                                    </td>
                                    <td class="none">
                                       <select  class="form-control changesNo onchange" id="tax_1" autocomplete="off">                                    
                                          
                                       </select>
                                       <input type="hidden" id="taxvalue_1" name="taxValue[]" class="form-control totalLineTax addNewRow" autocomplete="off" step="0.01" readonly>
                                    </td>
                                    <td>
                                       <input type="hidden" id="mainAmount_1" class="form-control mainAmount addNewRow" autocomplete="off" placeholder="Main Amount" step="0.01" readonly>
                                       <input type="hidden" id="total_1" class="form-control totalLinePrice addNewRow" autocomplete="off" placeholder="Total Amount" step="0.01" readonly>
                                       <input type="text" id="sum_1" class="form-control totalSum addNewRow"  value="<?php echo $product->price * $product->quantity ?>" autocomplete="off" placeholder="Total Sum" step="0.01" readonly>
                                    </td>
                                    <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                        <div class="row">
                           <div class="col-md-6">
   
                           </div>
                           <div class="col-md-6">
                              <table class="table table-bordered table-striped">
                                 <tr>
                                    <td>Sub Total</td>
                                    <td>
                                       <input readonly value="{!! $creditnote->sub_total !!}" type="number" class="form-control" id="subTotal"  onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                                    </td>
                                 </tr>
                                 <tr>
                                    <td>Total Amount</td>
                                    <td>
                                       <input readonly value="{!! $creditnote->total !!}" type="number" class="form-control" id="InvoicetotalAmount" placeholder="Total" step="0.01">
                                    </td>
                                 </tr>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='row mb-3'>
                     <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                        <a class="btn btn-primary" id="addRows" href="javascript:;"><i class="fal fa-plus-circle"></i> Add More</a>
                     </div>
                  </div>
               </div>
            </div>
            <div class='row'>
               <div class="col-md-6 mt-3">
                  <label for="">Customer Notes</label>
                  <textarea name="customer_note" class="form-control ckeditor" rows="8" cols="80">{!! $creditnote->customer_note !!}</textarea>
               </div>
               <div class="col-md-6 mt-3">
                  <label for="">Customer Notes</label>
                  <textarea name="terms" class="form-control ckeditor" rows="8" cols="80">{!! $creditnote->terms !!}</textarea>
               </div>
               <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                  <div class='form-group text-center'>
                     <center>
                        <button type="submit"class="btn btn-pink btn-lg submit"><i class="fas fa-save"></i> Update Credit note </button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                     </center>
                  </div>
               </div>
            </div>
         {{ Form::close() }}
   </div>
@endsection
@include('app.finance.partials._lpo')
