@extends('layouts.app')
{{-- page header --}}
@section('title','Product Price')

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
		<li class="breadcrumb-item"><a href="{!! route('finance.product.index') !!}">Products</a></li>
		<li class="breadcrumb-item active">Edit Product</li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header"><i class="fal fa-usd-circle"></i> Product Price | {!! $product->product_name !!}</h1>
	<!-- end page-header -->
	@include('partials._messages')
	<div class="row">
		@include('app.finance.partials._shop_menu')
		<div class="col-md-9">
			@if($product->same_price != 'No')
				{!! Form::model($defaultPrice,['route' =>['finance.price.update',$defaultPrice->id],'method'=>'post','enctype'=>'multipart/form-data','data-parsley-validate' => '']) !!}
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">{!! $product->product_name !!} - Product Price</h4>
						</div>
						<div class="panel-body">
							<div class="col-md-12">
								<div class="form-group form-group-default required">
									{!! Form::label('title', 'Buying Price Per Unit', array('class'=>'control-label')) !!}
									{!! Form::number('buying_price', null, array('class' => 'form-control','step' => '0.01','placeholder' => 'Buying Price','required' => '')) !!}
								</div>
								<div class="form-group form-group-default required">
									{!! Form::label('title', 'Selling Price Per Unit', array('class'=>'control-label')) !!}
									{!! Form::number('selling_price', null, array('class' => 'form-control', 'step' => '0.01','placeholder' => 'Selling Price','required' => '')) !!}
								</div>
								{{-- <div class="form-group form-group-default">
									{!! Form::label('title', 'Offer Price Per Unit', array('class'=>'control-label')) !!}
									{!! Form::number('offer_price', null, array('class' => 'form-control', 'placeholder' => 'Offer Price','step' => '0.01')) !!}
								</div> --}}
								{{-- <div class="form-group form-group-default">
									{!! Form::label('title', 'Tax rule:', array('class'=>'control-label')) !!}
									<select name="taxID" id="" class="form-control multiselect">
										@if($price->taxID != "")
											<option value="{!! $price->taxID !!}">
												{!! Finance::tax($price->taxID)->name !!}-{!! Finance::tax($price->taxID)->rate !!}%
											</option>
										@else
											<option value=""> Choose tax</option>
										@endif
										@foreach($taxes as $tax)
											<option value="{!! $tax->id !!}">{!! $tax->name !!}-{!! $tax->rate !!}%</option>
										@endforeach
									</select>
								</div> --}}
								<div class="form-group">
									<center>
										<button type="submit" class="btn btn-pink submit mt-4"><i class="fas fa-save"></i> Update Price</button>
										<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="25%">
									</center>
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			@endif

			@if($product->same_price == 'No')
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title mb-1">Prices</h4>
					</div>
					<div class="panel-body">
						<div class="col-md-12 mt-3">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-striped">
										<thead>
											<th width="25%">Out Let</th>
											<th>Buying price</th>
											<th>Selling price</th>
											<th>Offer price</th>
											<th width="13%"></th>
										</thead>
										<tbody>
											@foreach ($prices as $price)
												{!! Form::model($price,['route' =>['finance.price.update',$price->id],'method'=>'post']) !!}
													<tr>
														<td>
															@if($price->default_price == 'Yes')
                                                {!! $mainBranch->branch_name !!}
                                             @else
                                                @if(Hr::check_branch($price->branch_id) == 1)
                                                   {!! Hr::branch($price->branch_id)->branch_name !!}
                                                @endif
                                             @endif
														</td>
														<td><input type="text" class="form-control" name="buying_price" value="{!! $price->buying_price !!}"></td>
														<td><input type="text" class="form-control" name="selling_price" value="{!! $price->selling_price !!}" required></td>
														<td><input type="text" class="form-control" name="offer_price" value="{!! $price->offer_price !!}"></td>
														<td>
															<button type="submit" class="btn btn-pink btn-block"><i class="fas fa-edit"></i> Update Price</button>
														</td>
													</tr>
												{!! Form::close() !!}
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
</div>
@endsection
{{-- page scripts --}}
