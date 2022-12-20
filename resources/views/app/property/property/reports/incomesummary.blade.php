@extends('layouts.app')
{{-- page header --}}
@section('title','Income Summary | Report ')
@section('sidebar')
	@include('app.property.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
			<li class="breadcrumb-item"><a href="#">Reports</a></li>
			<li class="breadcrumb-item active"><a href="javascript:void(0)">Income Summary</a></li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fal fa-building"></i> {!! $property->title !!} | Reports | Income Summary</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <div class="row">
               <div class="col-md-12">
                  <a href="#" data-toggle="modal" data-target="#filter" target="_blank" class="btn btn-sm btn-danger">
                     <i class="fal fa-search"></i> Filter
                  </a>
                  <a href="{!! route('property.reports.incomesummary.generate',[$property->id,$to,$from]) !!}" target="_blank" class="btn btn-sm btn-danger">
                     <i class="fal fa-file-pdf t-plus-1 fa-fw fa-lg"></i> Export as PDF
                  </a>
                  <a href="{!! route('property.reports.incomesummary.generate',[$property->id,$to,$from]) !!}" target="_blank" class="btn btn-sm btn-danger">
                     <i class="fal fa-print t-plus-1 fa-fw fa-lg"></i> Print
                  </a>
               </div>
            </div>
            <div class="row mt-2">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <div class="rep-container">
                           <div class="page-header text-center">
                              <h3>{!! $business->name !!}</h3>
                              <h4>Income Summary</h4>
                              <h5><span class="text-primary">From </span>{!! date('F j,Y', strtotime($from) ) !!} <span>To</span> {!! date('F j,Y', strtotime($to) ) !!} </h5>
                           </div>
                           <div class="reports-table-wrapper fill-container table-container">
                              <table class="table zi-table financial-comparison table-no-border">
                                 <thead>
                                    <tr class="rep-fin-th">
                                    <th class="text-left"><h3>Income</h3></th>
                                    <th class="text-right"><h3>Total</h3></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($originalIncomes as $originalCategory)
                                       @if(Property::check_invoice_in_category_by_period($property->id,$originalCategory->id,$from,$to) != 0)
                                          @foreach(Property::invoices_per_income_category($property->id,$originalCategory->id,$from,$to) as $xx)
                                             <tr class=" balance-tr">
                                                <td>{!! $originalCategory->name !!}</td>
                                                <td class="text-right">{!! $business->code !!}{!! number_format(Property::invoices_per_income_category_sum($property->id,$originalCategory->id,$from,$to)) !!}</td>
                                             </tr>
                                          @endforeach
                                       @endif
                                    @endforeach
                                    @foreach($incomeCategories as $category)
                                       @if(Property::check_invoice_in_category_by_period($property->id,$category->id,$from,$to) != 0)
                                          @foreach(Property::invoices_per_income_category($property->id,$category->id,$from,$to) as $xx)
                                             <tr class=" balance-tr">
                                                <td>{!! $category->name !!}</td>
                                                <td class="text-right">{!! $business->code !!}{!! number_format(Property::invoices_per_income_category_sum($property->id,$category->id,$from,$to)) !!}</td>
                                             </tr>
                                          @endforeach
                                       @endif
                                    @endforeach
                                    @if($unCategorisedInvoicesCount != 0)
                                       <tr class=" balance-tr">
                                          <td>Others</td>
                                          <td class="text-right">{!! $business->code !!}{!! number_format($unCategorisedInvoicesSum) !!}</td>
                                       </tr>
                                    @endif
                                    <tr>
                                       <td><b>Total Income</b></td>
                                       <td class="text-right"><b>{!! $business->code !!}{!! number_format($income) !!}</b></td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-2"></div>
      </div>
	   <!-- Modal -->
	   <form action="{!! route('property.reports.incomesummary',$property->id) !!}" method="GET" autocomplete="off">
	      <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filter" aria-hidden="true">
	         <div class="modal-dialog" role="document">
	            <div class="modal-content">
	               <div class="modal-header">
	                  <h5 class="modal-title" id="exampleModalLabel">Filter by Date</h5>
	                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">&times;</span>
	                  </button>
	               </div>
	               <div class="modal-body">
	                  <div class="form-group form-group-default">
	                     <label for="">From</label>
	                     {!! Form::date('from',null,['class'=>'form-control']) !!}
	                  </div>
	                  <div class="form-group form-group-default">
	                     <label for="">To</label>
	                     {!! Form::date('to',null,['class'=>'form-control']) !!}
	                  </div>
	               </div>
	               <div class="modal-footer">
	                  <button class="btn btn-success badge-light submit" type="submit">Filter date</button>
	                  <img src="{!! url('/') !!}/public/app/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
	               </div>
	            </div>
	         </div>
	      </div>
	   </form>
	</div>
@endsection
