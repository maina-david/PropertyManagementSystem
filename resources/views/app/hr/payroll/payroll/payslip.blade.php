@extends('layouts.app')
{{-- page header --}}
@section('title','Payslip')
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
         <li class="breadcrumb-item active">Payslip</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-money-check-alt"></i> Payslip</h1>
      <div class="row">
         <div class="col-md-12">
            {{-- <a href="" class="btn btn-warning btn-sm"><i class="fal fa-print"></i> Print</a> --}}
            @if(Finance::check_business_payment_integrations(3) == 1)
               <a href="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#mpesaPayment"><i class="fal fa-credit-card"></i> Make Payment</a>
            @endif
         </div>
      </div>
      <div class="card mt-2">
         <div class="card-header">Employee payslip</div>
         <div class="card-body">
            <div class="employee-payslip-container">
               <div class="employee-payslip employee-payslip--sg">
                  <table class="employee-payslip__header">
                     <tbody>
                        <tr class="employee-payslip-company-row">
                           <td class="employee-payslip-company-name" colspan="2">{!! $person->names !!}</td>
                           <td class="employee-payslip-company-logo" rowspan="3"></td>
                        </tr>
                        <tr class="employee-payslip-employee-row">
                           <td class="employee-payslip-employee-info">
                              <div><label>Name :</label> {!! $person->names !!}</div>
                              <div><label>Department :</label> @if($person->department != ""){!! Hr::department($person->department)->title !!}@endif</div>
                              <div><label>Branch :</label> @if($person->department != ""){!! Hr::department($person->department)->title !!}@endif</div>
                              <div><label>Position :</label> @if($person->department != ""){!! Hr::position($person->position)->name !!}@endif</div>
                              <div><label>Pay Period :</label> {!! date('F jS Y', strtotime($person->payroll_date)) !!}</div>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <ul class="employee-payslip__body">
                     <li class="net-income"><div>Net Income</div>
                        <div class="right"><span class="price"><span class="currency-symbol">{!! $currency->symbol !!}</span>{!! number_format($person->net_pay) !!}</span></div>
                     </li>
                     <li class="earning first">
                        <div class="name">Earning</div>
                        <div class="right">Amount</div>
                     </li>
                     <li class="earning desc">
                        <div class="name">Salary</div>
                        <div class="right"><span class="price"><span class="currency-symbol">{!! $currency->symbol !!}</span>{!! number_format($person->salary) !!}</span></div>
                     </li>
                     <li class="earning total desc">
                        <div class="name">Total</div>
                        <div class="right"><span class="price"><span class="currency-symbol">{!! $currency->symbol !!}</span>{!! number_format($person->salary) !!}</span></div>
                     </li>

                     @if($check_deductions > 0)
                        <li class="deduction first">
                           <div class="name">Deduction</div>
                           <div class="right">Amount</div>
                        </li>
                        @foreach ($deductions as $deduction)
                           <li class="deduction desc">
                              <div class="name">{!! $deduction->item !!}</div>
                              <div class="right"><span class="price"><span class="currency-symbol">{!! $currency->symbol !!}</span>{!! number_format($deduction->amount) !!}</span></div>
                           </li>
                        @endforeach
                        <li class="deduction total desc">
                           <div class="name">Total</div><div class="right"><span class="price"><span class="currency-symbol">{!! $currency->symbol !!}</span>{!! number_format($deductions->sum('amount')) !!}</span></div>
                        </li>
                     @endif

                     @if($check_benefits > 0)
                           <li class="employer-contribution first">
                              <div class="name">Deduction</div>
                              <div class="right">Amount</div>
                           </li>
                        @foreach($benefits as $benefit)
                           <li class="employer-contribution desc">
                              <div class="name">{!! $benefit->item !!}</div>
                              <div class="right"><span class="price"><span class="currency-symbol">{!! $currency->symbol !!}</span>{!! number_format($benefit->amount) !!}</span></div>
                           </li>
                        @endforeach
                        <li class="employer-contribution total desc">
                           <div class="name">Total</div>
                           <div class="right">
                              <span class="price"><span class="currency-symbol">{!! $currency->symbol !!}</span>{!! number_format($benefits->sum('amount')) !!}</span>
                           </div>
                        </li>
                     @endif
                  </ul>
               </div>
            </div>
         </div>
      </div>
	</div>
   <!-- Modal -->
   <div class="modal fade" id="mpesaPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <form class="modal-content" method="post" action="{!! route('hrm.payroll.mpesa.payment') !!}">
            @csrf
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Make Payment with Mpesa</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button> 
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="">Employee</label>
                  <input type="text" class="form-control" value="{!! $person->names !!}" readonly>
               </div>
               <div class="form-group">
                  <label for="">Phone Number</label>
                  <input type="text" class="form-control" name="phone_number" value="{!! $person->personal_number !!}" placeholder="format 2547xxxxxxxx" required>
               </div>
               <div class="form-group">
                  <label for="">Amount</label>
                  <input type="text" name="amount" class="form-control" value="{!! $person->balance !!}" required>
                  <input type="hidden" class="form-control" name="businessID" value="{!! Wingu::business()->businessID !!}">
                  <input type="hidden" class="form-control" value="{!! $person->payrollID !!}" name="payrollID">
                  <input type="hidden" class="form-control" value="{!! $person->payroll_code !!}" name="payroll_code">
               </div>
            </div>
            <div class="modal-footer">
               <center>
                  <button type="submit" class="btn btn-success btn-sm submit"><i class="fa fa-save"></i> Submit Payment</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="45%">
               </center>
            </div>
         </form>
      </div>
   </div>
@endsection
