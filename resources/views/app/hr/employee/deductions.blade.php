@extends('layouts.app')
{{-- page header --}}
@section('title','Salary Deduction')
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="{!! route('hrm.dashboard') !!}">Home</a></li>
			<li class="breadcrumb-item"><a href="{!! route('hrm.employee.index') !!}">Employee</a></li>
			<li class="breadcrumb-item active">Salary Deduction</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header"><i class="fas fa-minus"></i> Salary Deduction </h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			@include('app.hr.partials._hr_employee_menu')
         <div class="col-md-9">
            @include('partials._messages')
            <div class="row">
               <div class="col-md-12">
                  <a href="#add-deduction" data-toggle="modal" class="float-right btn btn-pink btn-sm mb-2"><i class="fas fa-plus"></i> Add Deduction</a>
               </div>
            </div>
            <div class="card">
               <div class="card-header">
                  {!! $employee->names !!} - Deductions
               </div>
               <div class="card-body">
                  <div class="row">
                     <table id="data-table-default" class="table table-striped table-bordered">
                        <tr>
                           <th width="1%">#</th>
                           <th>Dedaction</th>
                           <th>Rate (% of salary)</th>
                           <th>Amount</th>
                           <th width="10%">Action</th>
                        </tr>
                        <tbody>
                           @foreach ($allocations as $all)
                              <tr>
                                 <td>{!! $count++ !!}</td>
                                 <td>{!! $all->title !!}</td>
                                 <td>{!! $all->rate !!}%</td>
                                 <td>
                                    {!! number_format($all->amount) !!}
                                    @if(Wingu::business()->base_currency != "")
                                    {!! Finance::currency(Wingu::business()->base_currency)->code !!}
                                    @endif
                                 </td>
                                 <td>
                                    <a href="{!! route('hrm.employee.deductions.delete.allocate',$all->deductID) !!}" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i> Remove</a>
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
   </div>
   <div class="modal fade" id="add-deduction" tabindex="-1" role="dialog">
      <div class="modal-dialog">
         {!! Form::open(array('route' => 'hrm.employee.deductions.allocate','method' =>'post','autocomplete'=>'off')) !!}
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add Deduction</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  @csrf
                  <div class="form-group form-group-default required">
                     {!! Form::label('names', 'Choose deduction', array('class'=>'control-label')) !!}
                     {!! Form::select('deduction', $deductions, null, array('class' => 'form-control', 'required' => '')) !!}
                     <input type="hidden" name="employeeID" value="{!! $employee->id !!}" required>
                  </div>
                  <div class="form-group form-group-default required">
                     {!! Form::label('names', 'Choose deduction value type', array('class'=>'control-label')) !!}
                     {!! Form::select('type', ['' => 'Choose','Amount' => 'Amount','Percentage' => 'Percentage'], null, array('class' => 'form-control', 'required' => '', 'id' => 'type')) !!}
                  </div>
                  <div class="form-group form-group-default" id="rate" style="display:none">
                     {!! Form::label('names', 'Deduction rate in %', array('class'=>'control-label')) !!}
                     {!! Form::text('rate',null, array('class' => 'form-control', 'placeholder' => 'Enter deduction in %')) !!}
                  </div>
                  <div class="form-group form-group-default" id="amount" style="display:none">
                     {!! Form::label('names', 'Deduction Amount', array('class'=>'control-label')) !!}
                     {!! Form::text('amount',null, array('class' => 'form-control', 'placeholder' => 'Enter deduction in amount')) !!}
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Deduction</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
               </div>
            </div>
         {!! Form::close() !!}
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
      $(document).ready(function() {
         $('#type').on('change', function() {
            if (this.value == 'Amount') {
               $('#amount').show();
               $('#rate').hide();
            }

            if(this.value == 'Percentage') {
               $('#rate').show();
               $('#amount').hide();
            }
         });
      });
   </script>
@endsection
