@extends('layouts.app')
{{-- page header --}}
@section('title') Expenses | Create | {!! $property->title !!} @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page styles --}}

@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
      <li class="breadcrumb-item"><a href="{!! route('property.expense',$property->id) !!}">Expense</a></li>
      <li class="breadcrumb-item active"><a href="{!! route('property.expense',$property->id) !!}">All</a></li> 
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Expense</h1>
   <div class="row">

   
      @include('app.property.partials._property_menu')
      <div class="col-md-12 mt-3">
         <a href="{!! route('property.expense.create',$property->id) !!}" class="btn btn-primary"><i class="fal fa-plus-circle"></i> Add Expense</a>
      </div>
      <div class="col-md-12 mt-3">   
         <div class="panel">
            <div class="panel-heading"><b>Expense</b></div>
            <div class="panel-body">
               <table id="example5" class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th width="1%">#</th>
                        <th width="10%">Date</th>
                        <th>Expense Category</th>
                        <th>Reference#</th>
                        <th>Expense Title</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th width="8%">Action</th>
                     </tr>
                  </thead>
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
                              @permission('update-expense')
                                 <a href="{{ route('property.expense.edit',[$property->id,$exp->eid]) }}" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                              @endpermission
                              @permission('update-expense')
                                 <a href="{!! route('property.expense.delete',[$property->id,$exp->eid]) !!}" class="delete btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                              @endpermission
                           </td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection