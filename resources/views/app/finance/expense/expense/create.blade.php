@extends('layouts.app')
{{-- page header --}}
@section('title','Expense Create')
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
			<li class="breadcrumb-item"><a href="{!! route('finance.expense.index') !!}">Expenses</a></li>
			<li class="breadcrumb-item active">Create</li>
		</ol>
		<h1 class="page-header"><i class="fal fa-money-check-alt"></i> Add Expenses </h1>
		@include('partials._messages')
		{!! Form::open(array('route' => 'finance.expense.store', 'enctype'=>'multipart/form-data', 'method' => 'post', 'autocomplete' => 'off')) !!}
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Expenses Details</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-default">
										<label for="">Bank or Cash Account <a href="" class="pull-right" data-toggle="modal" data-target="#bankandcash">Add Account</a></label>
										<select name="account" id="selectAccount" class="form-control select2"></select>
									</div>
								</div>
							</div>	
							<div class="form-group form-group-default">
								<label for="" class="text-danger">Category <a href="" class="pull-right" data-toggle="modal" data-target="#expenceCategory">Add category</a></label>
								<select name="expense_category" id="selectCategory" class="form-control select2" required></select>
							</div>
							<div class="form-group form-group-default required">
								{!! Form::label('Date', 'Date', array('class'=>'control-label text-danger')) !!}
								{!! Form::date('date', null, array('class' => 'form-control', 'required' =>'', 'autocomplete' => 'off')) !!}
							</div>
							<div class="form-group form-group-default required">
								{!! Form::label('Title', 'Title', array('class'=>'control-label text-danger')) !!}
								{!! Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'', 'autocomplete' => 'off' )) !!}
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default required" aria-required="true">
										{!! Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')) !!}
										{!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'', 'autocomplete' => 'off' )) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										<label for="">Chosse Tax Rate <a href="javascript()" class="pull-right" data-toggle="modal" data-target="#taxRate">Add Tax Rate</a></label>
										<select name="tax_rate" id="selectTax" class="form-control select2"></select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Expence Details</h4>
						</div>
						<div class="panel-body">
							<div class="form-group form-group-default">
								<label for="" class="">Supplier <a href="" class="pull-right" data-toggle="modal" data-target="#addSupplier">Add Supplier</a></label>
								<select name="supplier" id="selectSupplier" class="form-control select2"></select>
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Reference', 'Reference (i.e Payment Code)', array('class'=>'control-label')) !!}
								{!! Form::text('refrence_number', null, array('class' => 'form-control', 'placeholder' => 'Reference')) !!}
							</div>
							<div class="form-group form-group-default required">
								{!! Form::label('Choose status', 'Choose status', array('class'=>'control-label text-danger')) !!}
								{{ Form::select('status', [''=>'Choose status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ]) }}
							</div>
							<div class="form-group form-group-default">
								<label for="" class="text-danger">Method Of Payment</label>
								<select name="payment_method" class="form-control multiselect" required> 
									<option value="">Choose payment method</option>
									@foreach($defaultPayment as $paymentmethod)
										<option value="{!! $paymentmethod->name !!}">{!! $paymentmethod->name !!}</option>
									@endforeach
									@foreach ($accountPayment as $accayment)
										<option value="{!! $accayment->name !!}">{!! $accayment->name !!}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Expence Files', 'Expense Files', array('class'=>'control-label')) !!}<br>
								<input type="file" name="files[]" id="files" multiple>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Description</h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								{!! Form::textarea('description',null,['class'=>'form-control ckeditor', 'rows' => 9, 'placeholder'=>'content']) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<center>
						<button class="btn btn-pink" type="submit"><i class="fas fa-save"></i> Add Expense</button>		
						{{-- <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">				 --}}
					</center>
				</div>
			</div>
		{{ Form::close() }}
	</div>
	@include('app.finance.accounts.express')	
	@include('app.finance.expense.category.express')
	@include('app.finance.taxes.express')	
	@include('app.finance.suppliers.express')
@endsection
@section('scripts')
	<script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
	@include('app.partials._express_scripts')	
@endsection
