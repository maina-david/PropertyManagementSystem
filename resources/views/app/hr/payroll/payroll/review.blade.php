@extends('layouts.app')
{{-- page header --}}
@section('title','Review Payroll')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Human resource</a></li>
         <li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Payroll</a></li>
         <li class="breadcrumb-item active">Review Payroll</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> Review & Confirm</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <form action="{!! route('hrm.payroll.process.run') !!}" method="post" enctype="multipart/form-data" class="row">
         @csrf
         <div class="col-md-12">
            <div class="card">
	            <div class="card-body">
						<div class="col-md-12">
							<h3><b>Date:</b> {!! date('F jS, Y', strtotime($payroll_date)) !!}</h3>
							<h3><b>Type:</b> {!! $type !!}</h3>
							<h3><b>Branch:</b> {!! $branch !!}</h3>
						</div>
	               <div class="col-md-12">
	                  <!-- begin panel -->
	                  <table class="table table-striped table-bordered">
	                     <thead>
	                        <th width="1%">#</th>
	                        <th class="text-left" style="width: 20%;">Employee</th>
	                        <th>Basic salary</th>
	                        {{-- <th>Additions</th> --}}
	                        <th>Gross pay</th>
	                        <th>Deductions</th>
	                        <th>Net pay</th>
	                        <th>Payment Type</th>
	                     </thead>
	                     <tbody>
	                        @foreach($results as $result)
	                           <tr>
	                              <td>{!! $count++ !!}</td>
	                              <td>
	                                 <div class="row">
	                                    @if($result->avator != "")
	                                       <img class="rounded-circle" width="40" height="40" alt="" class="rounded-circle col-md-2" src="{!! asset('businesses/'.$result->business_code.'/hr/employee/images/'.$result->avator) !!}">
	                                    @else
	                                       <img src="https://ui-avatars.com/api/?name={!! $result->employee_name !!}&rounded=true&size=32" alt="">
	                                    @endif
	                                    <div class="col-md-10">
	                                       <a href="#">{!! $result->employee_name !!}</a> <br> 
														@if($result->position != ""){!! Hr::position($result->position)->name !!}@endif
	                                    </div>
	                                 </div>
	                                 <input type="hidden" name="people_employeeID[]" value="{!! $result->empID !!}" required>
	                              </td>
	                              <td>
	                                 <b>
	                                    {!! $result->symbol !!}{!! number_format($result->salary_amount) !!}	                                    
	                                    <input type="hidden" name="people_salary[]" value="{!! $result->salary_amount !!}" required>
	                                 </b>
	                              </td>
	                              {{-- <td>
	                                 <b>
	                                    {!! number_format($result->total_additions) !!}
	                                    {!! $result->symbol !!}
	                                    <input type="hidden" value="{!! $result->total_additions !!}" name="people_additions[]">
	                                 <b>
	                              </td> --}}
	                              <td>
	                                 <b>
	                                    {!! $result->symbol !!}{!! number_format($result->total_additions + $result->salary_amount) !!}
	                                    <input type="hidden" value="{!! $result->total_additions + $result->salary_amount !!}" name="people_gross_pay[]">
	                                 </b>
	                              </td>
	                              <td>
	                                 <b>
													{!! $result->symbol !!}{!! number_format($result->total_deductions) !!}
	                                    <input type="hidden" value="{!! $result->total_deductions !!}" name="people_deduction[]">
	                                 </b>
	                              </td>
	                              <td>
	                                 <b>
	                                    {!! $result->symbol !!}{!! number_format(($result->salary_amount - $result->total_deductions) + $result->total_additions) !!}
	                                    <input type="hidden" value="{!! ($result->salary_amount - $result->total_deductions) + $result->total_additions !!}" name="people_net_pay[]">
	                                 </b>
	                              </td>
	                              <td>
	                                 {!! $result->payment_basis !!}
	                                 <input type="hidden" name="people_type[]" value="{!! $result->payment_basis !!}">
	                              </td>
	                           </tr>
	                        @endforeach
	                     </tbody>
	                     <tfoot>
	                        <th colspan="2" class="text-center">
	                           Grand total
	                           <input type="hidden" value="{!! $payroll_date !!}" name="payroll_date" required>
										<input type="hidden" value="{!! $type !!}" class="form-control"  name="type" required>
										<input type="hidden" value="{!! $branch !!}" class="form-control"  name="branch" required>
	                        </th>
	                        <th>
	                           {!! number_format($results->sum('salary_amount')) !!}
	                           <input type="hidden" class="form-control" name="salary_amount" value="{!! $results->sum('salary_amount') !!}" required>
	                        </th>
	                        {{-- <th>
	                           {!! number_format($results->sum('total_additions')) !!}
	                           <input type="hidden" class="form-control" name="total_additions" value="{!! $results->sum('total_additions') !!}">
	                        </th> --}}
	                        <th>
	                           {!! number_format($results->sum('total_deductions') + $results->sum('total_additions') + $results->sum('salary_amount')) !!}
	                           <input type="hidden" class="form-control" name="gross_pay" value="{!! $results->sum('total_deductions') + $results->sum('total_additions') + $results->sum('salary_amount') !!}">
	                        </th>
	                        <th>
	                           {!! number_format($results->sum('total_deductions')) !!}
	                           <input type="hidden" class="form-control" value="{!! $results->sum('total_deductions') !!}" name="total_deductions">
	                        </th>
	                        <th>
	                           {!! number_format(($results->sum('salary_amount') - $results->sum('total_deductions')) + $results->sum('total_additions')) !!}
	                           <input type="hidden" class="form-control" name="net_pay" value="{!! ($results->sum('salary_amount') - $results->sum('total_deductions')) + $results->sum('total_additions') !!}">
	                        </th>
	                        <th colspan="2"></th>
	                     </tfoot>
	                  </table>
	                  <!-- end panel -->
	               </div>
	               <div class="row">
	                  <div class="col-md-8"></div>
	                  <div class="col-md-4">
	                     <button type="submit" class="float-right btn btn-pink btn-block submit"><i class="fas fa-save"></i> Save and process payroll</button>
	                     <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="45%">
	                  </div>
	               </div>
	            </div>
	         </div>
         </div>
      </form>
   </div>
@endsection
