@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Mileage Expense')

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
			<li class="breadcrumb-item active">Edit Mileage Expences</li>
		</ol>
		<h1 class="page-header">Edit Mileage Expences</h1>
		@include('partials._messages')
		{!! Form::model($expense, ['route' => ['finance.mileage.update',$expense->id], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
			<div class="row">
				<div class="col-lg-6 col-md-6 ">
				 	<div class="panel panel-default">
					 	<div class="panel-heading">
						 	<h4 class="panel-title">Mileage Expence Details</h4>
					 	</div>
						<div class="panel-body">
						 	<div class="form-group">
							 	{!! Form::label('Date', 'Date', array('class'=>'control-label')) !!}
							 	{!! Form::text('date', null, array('class' => 'form-control datepicker', 'placeholder' => 'Pick a date', 'required' =>'' )) !!}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Expense Title', 'Expense Title', array('class'=>'control-label')) !!}
								{!! Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'' )) !!}
							</div>
						 	<div class="form-group form-group-default">
								{!! Form::label('Expense Category', 'Expense Category', array('class'=>'control-label')) !!}
								{{ Form::select('expense_category', $category, null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2','placeholder' => 'Expense Category','required' =>'']) }}
						 	</div>
						 	<div class="form-group form-group-default">
							 	{!! Form::label('Calculation Type', 'Calculation Type', array('class'=>'control-label')) !!}
							 	{{ Form::select('calculate_type',['' => 'Choose Calculation','Kilometers' => 'Kilometers','Odometer' => 'Odometer' ], null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2','placeholder' => 'Calculation Type','required' =>''  ]) }}
						 	</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-group-default required">
										{!! Form::label('Odometer Start', 'Odometer Start', array('class'=>'control-label')) !!}
										{!! Form::number('odometer_start', null, array('class' => 'form-control', 'placeholder' => 'Odometer Start')) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default required">
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
									<div class="form-group form-group-default required" aria-required="true">
										{!! Form::label('Amount', 'Amount', array('class'=>'control-label')) !!}
										{!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'' )) !!}
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-default">
										{!! Form::label('Choose Tax Rate', 'Chosse Tax Rate', array('class'=>'control-label')) !!}
										{{ Form::select('tax_rate',$tax, null, ['class' => 'form-control', 'required' =>'','data-init-plugin' => 'select2']) }}
									</div>
								</div>
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
							<div class="form-group form-group-default">
								{!! Form::label('Reference', 'Reference', array('class'=>'control-label')) !!}
								{!! Form::text('refrence_number', null, array('class' => 'form-control', 'placeholder' => 'Reference', 'required' =>'' )) !!}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Choose Claimant', 'Choose Claimant', array('class'=>'control-label')) !!}
								{{ Form::select('claimant', $employee, null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2','placeholder' => 'Choose Claimant','required' =>''  ]) }}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Choose expense status', 'Choose expense status', array('class'=>'control-label')) !!}
								{{ Form::select('status', [''=>'Choose expense status','Paid'=>'Paid','Pending'=>'Pending','Dept'=>'Dept'], null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2','placeholder' => 'Choose Claimant','required' =>''  ]) }}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Method of payment', 'Method of payment', array('class'=>'control-label')) !!}
								{{ Form::select('payment_method', $payment, null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2','placeholder' => 'Method of payment','required' =>''  ]) }}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('Mileage Files', 'Mileage Files', array('class'=>'control-label')) !!}
								{!! Form::file('files[]', null, array('class' => 'form-control', 'placeholder' => 'Reference', 'required' =>'' )) !!}
							</div>
							<div class="row mt-4">
								@foreach ($files as $file)
									<div class="col-md-2">
										@if(stripos($file->file_mime, 'image') !== FALSE)
										<img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/'.$file->file_name) !!}" alt="" style="width:100%;height:80px">
										@elseif(stripos($file->file_mime, 'pdf') !== FALSE)
											<center><i class="fas fa-file-pdf fa-4x" style="width:100%;height:80px"></i></center>
										@elseif(stripos($file->file_mime, 'octet-stream') !== FALSE)
											<center><i class="fas fa-file-alt fa-4x" style="width:100%;height:80px"></i></center>
										@elseif(stripos($file->file_mime, 'officedocument') !== FALSE)
											<center><i class="fas fa-file-word fa-4x" style="width:100%;height:80px"></i></center>
										@else
											<center><i class="fas fa-file fa-4x" style="width:100%;height:80px"></i></center>
										@endif
										<center>
											<a href="{!! route('finance.expense.file.delete', $file->id) !!}" title="delete" class="label label-danger"><i class="fas fa-trash"></i></a>
											<a href="{!! route('finance.expense.file.download', $file->id) !!}" title="download" class="label label-primary mt-1"><i class="fas fa-download"></i></a>
											<a href="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/finance/expense/'.$file->file_name) !!}" title="view" class="label label-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
										</center>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 ">
					<div class="panel panel-default">
					 	<div class="panel-heading">
						 	<h4 class="panel-title">Mileage Description</h4>
					 	</div>
							<div class="panel-body">
							<div class="form-group">
								{!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
								{!! Form::textarea('description',null,['class'=>'form-control ck4standard', 'id' => 'editor1', 'rows' => 9, 'placeholder'=>'content']) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<center>
						<button class="btn btn-info submit" type="submit">Update Mileage</button>
						<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
					</center>
				</div>
			</div>
		{{ Form::close() }}
	</div>
@endsection
