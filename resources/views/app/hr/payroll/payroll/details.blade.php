@extends('layouts.app')
{{-- page header --}}
@section('title','payroll')
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
         <li class="breadcrumb-item"><a href="{!! route('hrm.payroll.index') !!}">Payroll</a></li>
         <li class="breadcrumb-item active"> Month end pay</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"> {!! date('F jS Y', strtotime($payroll->payroll_date)) !!} - {!! $payroll->payroll_type !!}</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr class="table-header">
                     <th width="1%">#</th>
                     <th class="text-left" style="width: 25%;">Employee</th>
                     <th>Basic salary</th>
                     {{-- <th>Additions</th> --}}
                     <th>Gross Pay</th>
                     <th>Deductions</th>
                     <th>Net Pay</th>
                     <th>Status</th>
                     <th width="15%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($payslips as $payslip)
                     <tr class="">
                        <td>{!! $count++ !!}</td>
                        <td>
                           {!! $payslip->names !!}
                        </td>
                        <td>
                           {!! $payslip->symbol !!}{!! number_format($payslip->salary)!!} 
                        </td>
                        {{-- <td>
                           {!! number_format($payslip->addition) !!} {!! $payslip->symbol !!}
                        </td> --}}
                        <td>
                           {!! $payslip->symbol !!}{!! number_format($payslip->gross_pay) !!} 
                        </td>
                        <td>
                           {!! $payslip->symbol !!}{!! number_format($payslip->deduction) !!} 
                        </td>
                        <td>
                           {!! $payslip->symbol !!}{!! number_format($payslip->net_pay) !!} 
                        </td>
                        <td>
                           
                        </td>
                        <td>
                           <a href="{!! route('hrm.payroll.payslip',[$payslip->employeeID,$payroll->payroll_code]) !!}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>
                           @permission('delete-payroll')
                              <a href="{!! route('hrm.payroll.payslip.delete',[$payslip->employeeID,$payroll->payroll_code]) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Delete</a>
                           @endpermission
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <!-- end panel -->
   </div>
@endsection
