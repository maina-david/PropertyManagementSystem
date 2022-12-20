@extends('layouts.app')
{{-- page header --}}
@section('title','Expence List | winguPlus')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection


{{-- content section --}}
@section('content')
	<div class="content">
		@if(Finance::count_expense() != Wingu::plan()->expenses && Finance::count_expense() < Wingu::plan()->expenses)
         @permission('create-expense')
				<div class="pull-right">
					<a href="{!! route('finance.expense.create') !!}" class="btn btn-pink"><i class="fal fa-plus"></i> New Expense</a>
				</div>
			@endpermission
		@endif
		<!-- end breadcrumb --> 
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-money-check-alt"></i> All Expenses</h1>
		@include('partials._messages')
		<div class="hpanel">
		   <div class="panel panel-default mt-3">
				<div class="panel-heading">
					<h4 class="panel-title">Expenses List</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="1%">#</th>
								<th width="10%">Date</th>
								<th>Expense Category</th>
								<th>Reference#</th>
								<th>Expense Title</th>
								<th>Status</th>
								<th>Amount</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th width="1%">#</th>
								<th width="10%">Date</th>
								<th>Expense Category</th>
								<th>Reference#</th>
								<th>Expense Title</th>
								<th>Status</th>
								<th>Amount</th>
								<th width="10%">Action</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach ($expense as $exp) 
								<tr {{-- class="success" --}}>
									<td>{!! $count++ !!}</td>
									<td>{!! date('M j, Y',strtotime($exp->date)) !!}</td>
									<td>{!! $exp->category_name !!}</td>
									<td><b>{!! $exp->refrence_number !!}</b></td>
									<td>{!! $exp->expense_name !!}</td>
									<td>
										<span class="badge {!! $exp->statusName !!}">
											{!! $exp->statusName !!}
										</span>
									</td>
									<td><b>{!! $exp->code !!} {!! number_format($exp->amount) !!}</b></td>
									<td>
										<div class="btn-group">
											<button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
											<ul class="dropdown-menu">
												@permission('update-expense')
												<li><a href="{{ route('finance.expense.edit', $exp->eid) }}"><i class="far fa-edit"></i> &nbsp;&nbsp; Edit</a></li>
												@endpermission
												@permission('update-expense')
												<li><a href="{!! route('finance.expense.destroy', $exp->eid) !!}" class="delete"><i class="fas fa-trash"></i> &nbsp;&nbsp; Delete</a></li>
												@endpermission
											</ul>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
		    	</div>
			</div>
		</div>
	</div>
@endsection
