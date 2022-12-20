@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Item')
@section('stylesheet')
	<style>
      ul.product li {
         width: 100%;
      }
   </style>
	<link href="{!! asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.css') !!}" rel="stylesheet" />
@endsection
@php  
   $property = Wingu::get_account_module_details(1);
@endphp
{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
      <li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">Item</a></li>
      <li class="breadcrumb-item active">Edit Item</li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-shopping-basket"></i> Edit Item</h1>
   <!-- end page-header -->
   @include('partials._messages')
   <div class="row">
      @include('app.finance.partials._shop_menu')
      <div class="col-md-9">
         {!! Form::model($product, ['route' => ['finance.products.update',$product->productID], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
            {!! csrf_field() !!}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">{!! $product->product_name !!} - Information</h4>
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group form-group-default required ">
                           {!! Form::label('title', 'Item type', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('type',[''=>'Choose type','service'=>'Service','product'=>'Standard Product'], null, ['class' => 'form-control multiselect', 'required' => '', 'id' => 'type']) }}
                        </div>
                     </div>
                     @if($product->type == 'variants')
                        <div class="col-md-6">
                           <div class="form-group form-group-default required ">
                                 {!! Form::label('title', 'Varient Attribute', array('class'=>'control-label')) !!}
                                 {{ Form::select('attributeID',$attributes, null, ['class' => 'form-control multiselect']) }}
                           </div>
                        </div>
                     @endif
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'Name', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('product_name', null, array('class' => 'form-control', 'placeholder' => 'Enter Product Name','required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required ">
                           {!! Form::label('title', 'Is Item Active', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('status',['Yes'=>'Yes','No'=>'No'], null, ['class' => 'form-control multiselect', 'required' => '']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default required">
                           {!! Form::label('title', 'SKU code', array('class'=>'control-label')) !!}
                           {!! Form::text('sku_code', null, array('class' => 'form-control', 'placeholder' => 'SKU code', 'required' => '')) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group form-group-default">
                           {!! Form::label('title', 'Brand', array('class'=>'control-label')) !!}
                           {{ Form::select('brandID', $brands, null, ['class' => 'form-control multiselect']) }}
                        </div>
                     </div>
                     @if($property->module_status == 15 && $property->payment_status == 1)
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('title', 'Supplier', array('class'=>'control-label')) !!}
                              {!! Form::select('supplierID',$suppliers,null,['class' => 'form-control multiselect']) !!}
                           </div>
                        </div>
                     @endif
							<div class="col-md-12">
                        <div class="row">
                           @if(Wingu::check_business_modules(7) == 1)
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('title', 'Sell on Point-of-Sale', array('class'=>'control-label')) !!}
                                    {{ Form::select('pos_item',[''=>'Choose option','No'=>'No','Yes'=>'Yes'], null, ['class' => 'form-control multiselect']) }}
                                 </div>
                              </div>
                           @endif
                           @if(Wingu::check_business_modules(20) == 1)
                              <div class="col-md-6">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('title', 'Sell on eCommerce site', array('class'=>'control-label')) !!}
                                    {{ Form::select('ecommerce_item',[''=>'Choose option','No'=>'No','Yes'=>'Yes'], null, ['class' => 'form-control multiselect']) }}
                                 </div>
                              </div>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="col-md-12">
                     <div class="form-group required form-group-default">
                        {!! Form::label('title', 'Product category', array('class'=>'control-label')) !!}
                        {{ Form::select('category[]',$joincat,null,['class' => 'form-control multiple-select2','multiple' => 'multiple']) }}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('title', 'Product Tags', array('class'=>'control-label')) !!}
                        {{ Form::select('tags[]',$jointag,null,['class' => 'form-control multiple-tag', 'multiple' => 'multiple']) }}
                     </div>
                     <div class="form-group mt-3">
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Item</button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         {!! Form::close() !!}
      </div>
   </div>
</div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script type="text/javascript">
		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val({!! json_encode($jointcategories) !!}).trigger('change');
		$(".multiple-tag").select2();
		$(".multiple-tag").select2().val({!! json_encode($jointtags) !!}).trigger('change');
	</script>
	<script>
		$(document).ready(function() {
			$('#size').tagsInput({
				'height':'auto',
				'width':'100%',
				'interactive':true,
				'defaultText':'add a size',
				'removeWithBackspace' : true,
				'placeholderColor' : '#666666'
			});
			$('#color').tagsInput({
				'height':'auto',
				'width':'100%',
				'interactive':true,
				'defaultText':'add a color',
				'removeWithBackspace' : true,
				'placeholderColor' : '#666666'
			});
		});
	</script>
	<script src="{!! asset('assets/plugins/jquery-tags-Input/src/jquery.tagsinput.js') !!}"></script>
@endsection
