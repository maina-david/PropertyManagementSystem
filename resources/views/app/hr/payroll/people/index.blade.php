@extends('layouts.app')
{{-- page header --}}
@section('title','Active Employees')
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
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Payroll</li>
         <li class="breadcrumb-item active">Active Employee</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Active Employee </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="panel panel-inverse">
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr class="table-header">
                     <th width="1%">#</th>
                     <th>Employee</th>
                     <th>Position</th>
                     <th>Department</th>
                     <th>Payment basis</th>
                     <th>Salary</th>
                     <th>Payment</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($employees as $employee)
                     <tr class="">
                        <td>{!! $count++ !!}</td>
                        <td>
                           {!! $employee->names !!}
                        </td>
                        <td>
                           @if($employee->position != "")
                              {!! Hr::position()->name !!}
                           @endif
                        </td>
                        <td>
                           @if($employee->department != "")
                              {!! Hr::department()->title !!}
                           @endif
                        </td>
                        <td>
                           {!! $employee->payment_basis !!}
                        </td>
                        <td>
                           {!! number_format($employee->salary_amount) !!} {!! $employee->code !!}
                        </td>
                        <td>
                           @if(Finance::check_account_payment_method($employee->payment_method) == 1)
                              {!! Finance::account_payment_method($employee->payment_method)->name !!}
                           @endif
                           @if(Finance::check_system_payment($employee->payment_method) == 1)
                              {!! Finance::system_payment($employee->payment_method)->name !!}
                           @endif
                        </td>
                        <td>
                           <a href="{!! route('hrm.payroll.people.show',$employee->empID) !!}" class="btn btn-pink btn-sm"><i class="fas fa-eye"></i> Payroll details</a>
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
@section('tips')
<div class="theme-panel theme-panel-lg">
   <a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fas fa-info-circle"></i></i></a>
   <div class="theme-panel-content">
      <h5 class="m-t-0">Tips</h5>
      <div class="row m-t-10">
         <div class="col-md-12">
            <p>Employee listed on this section have their employment status as <b>Employed</b> and the are allocate <b>Salary</b></p>
         </div>
      </div>
   </div>
</div>
@endsection
