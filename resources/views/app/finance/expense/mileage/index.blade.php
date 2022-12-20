@extends('layouts.app')
{{-- page header --}}
@section('title','Mileage Expense')

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
			<li class="breadcrumb-item active">All Mileage Expences</li>
		</ol>
		<h1 class="page-header">All Mileage Expences</h1>
		@include('partials._messages')
		<div class="hpanel">
			<a href="{{ route('finance.mileage.create') }}" title="" class="btn btn-success mb-3"><i class="fa fa-plus"></i> Add Mileage Expense</a>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">Mileage Expence List</h4>
				</div>
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered">
			        	<thead>
			            <tr>
			            	<th width="1%">#</th>
			               <th width="10%">Date</th>
			               <th>Expense Category</th>
			               <th>Refrence#</th>
			               <th>Expense Title</th>
			               <th>Customer Name</th>
			               <th>Status</th>
			               <th>Amount</th>
			               <th width="10%">Action</th>
			            </tr>
			        </thead>
			        	<tbody>
				        	@foreach ($expense as $exp)
				            <tr {{-- class="success" --}}>
				            	<td>{!! $count++ !!}</td>
				               <td>{!! date('F j, Y',strtotime($exp->date)) !!}</td>
				               <td>{!! $exp->category_name !!}</td>
				               <td>{!! $exp->refrence_number !!}</td>
				               <td>{!! $exp->expense_name !!}</td>
				               <td>{!! Hr::employee($exp->claimant)->names !!}</td>
				               <td><button data-toggle="button" class="btn btn-xs btn-warning {!! $exp->status !!}" type="button">{!! $exp->status !!}</button></td>
				               <td>{!! number_format($exp->amount) !!} ksh</td>
				               <td>
									<div class="btn-group">
				                  <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
				                  <ul class="dropdown-menu">
											<li><a href="{{ route('finance.mileage.edit', $exp->eid) }}"><i class="far fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
											<li><a href="{!! route('finance.mileage.destroy', $exp->eid) !!}"><i class="fas fa-trash"></i>&nbsp;&nbsp; Delete</a></li>
				                     <li class="divider"></li>
				                     <li><a href="#">the end</a></li>
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
{{-- page scripts --}}
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
	    $('#expense-form').DataTable( {
	        dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	        buttons: [
                {extend: 'copy',className: 'btn-sm'},
                {extend: 'csv',title: 'Finance Contact list', className: 'btn-sm'},
                {extend: 'pdf', title: 'Finance Contact list', className: 'btn-sm'},
                {extend: 'print',className: 'btn-sm'}
            ]
		    } );
		} );
	</script>
@endsection
