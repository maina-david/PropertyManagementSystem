@extends('layouts.app')
{{-- page header --}}
@section('title','Add Mileage Expense')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
			<li class="breadcrumb-item"><a href="{!! route('finance.expense.index') !!}">Expences</a></li>
			<li class="breadcrumb-item"><a href="{!! route('finance.mileage.index') !!}">Mileage</a></li>
			<li class="breadcrumb-item active">Add Mileage Expences</li>
		</ol>
		<h1 class="page-header">Add Mileage Expences</h1>
		@include('partials._messages')
		{!! Form::open(array('route' => 'finance.mileage.store', 'enctype'=>'multipart/form-data', 'data-parsley-validate' => '','method' => 'post')) !!}
			<div class="row">
				<div class="col-lg-6 col-md-6 ">
					<div class="panel panel-default">
					 	<div class="panel-heading">						 
						 	<h4 class="panel-title">Mileage Expence Details</h4>
					 	</div>
						<div class="panel-body">
							<div class="form-group form-group-default">
								{!! Form::label('Date', 'Date', array('class'=>'control-label')) !!}
								{!! Form::text('date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Pick a date', 'required' =>'','autocomplete' => 'off')) !!}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Expense Title', 'Expense Title', array('class'=>'control-label')) !!}
								{!! Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'' )) !!}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Expense Category', 'Expense Category', array('class'=>'control-label')) !!}
								{{ Form::select('expense_category', ['13' => 'Mileage Expense'], null, ['class' => 'form-control','placeholder' => 'Choose Category','required' =>''  ]) }}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Calculation Type', 'Calculation Type', array('class'=>'control-label')) !!}
								{{ Form::select('calculate_type',['' => 'Choose Calculation','Kilometers' => 'Kilometers','Odometer' => 'Odometer' ], null, ['class' => 'form-control','placeholder' => 'Calculation Type','required' =>''  ]) }}
							</div>
							<div class="row clearfix">
								<div class="col-sm-6">
									<div class="form-group form-group-default required" aria-required="true">
										{!! Form::label('Odometer Start', 'Odometer Start', array('class'=>'control-label')) !!}
										{!! Form::number('odometer_start', null, array('class' => 'form-control', 'placeholder' => 'Odometer Start')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default required" aria-required="true">
										{!! Form::label('Odometer Stop', 'Odometer Stop', array('class'=>'control-label')) !!}
										{!! Form::number('odometer_stop', null, array('class' => 'form-control', 'placeholder' => 'Odometer Stop')) !!}
									</div>
								</div>
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Distance', 'Distance', array('class'=>'control-label')) !!}
								{!! Form::number('distance', null, array('class' => 'form-control', 'placeholder' => 'Distance', 'required' =>'' )) !!}
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group required" aria-required="true">
										{!! Form::label('Amount', 'Amount', array('class'=>'control-label')) !!}
										{!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										{!! Form::label('Choose Tax Rate', 'Chosse Tax Rate', array('class'=>'control-label')) !!}
										{{ Form::select('tax_rate',$tax, null, ['class' => 'form-control default-select2 full-width', 'required' =>'']) }}
									</div>
								</div>
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Reference', 'Reference', array('class'=>'control-label')) !!}
								{!! Form::text('reference', null, array('class' => 'form-control', 'placeholder' => 'Reference', 'required' =>'' )) !!}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Choose expense status', 'Choose expense status', array('class'=>'control-label')) !!}
								{{ Form::select('status', [''=>'Choose expense status','Paid'=>'Paid','Pending'=>'Pending','Dept'=>'Dept'], null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2','placeholder' => 'Choose Claimant','required' =>''  ]) }}
							</div>
							<div class="form-group">
								{!! Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')) !!}
								{{ Form::select('payment_method', $payment, null, ['class' => 'form-control default-select2','placeholder' => 'Method of payment','required' =>''  ]) }}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 ">
					<div class="panel panel-default">
					 	<div class="panel-heading">
						 	<h4 class="panel-title">Mileage Expence Details</h4>
					 	</div>
						<div class="panel-body">
							<div class="form-group">
								{!! Form::label('Choose Claimant', 'Choose Claimant', array('class'=>'control-label')) !!}
								{{ Form::select('claimant', $employee, null, ['class' => 'form-control default-select2 full-width', 'data-init-plugin' => 'select2','placeholder' => 'Choose Claimant','required' =>''  ]) }}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Upload Files', 'Upload Files', array('class'=>'control-label')) !!}
								{!! Form::file('files[]', null, array('class' => 'form-control', 'placeholder' => 'Upload Files', 'required' =>'' )) !!}
							</div>
							<div class="form-group">
								{!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
								{!! Form::textarea('description',null,['class'=>'form-control ck4standard', 'rows' => 9, 'placeholder'=>'content']) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<center><button class="btn btn-info submit" type="submit">Add Mileage Expense</button>
						<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%"></center>
				</div>
			</div>
		{{ Form::close() }}
	</div>
@endsection
