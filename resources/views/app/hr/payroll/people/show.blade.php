@extends('layouts.app')
{{-- page header --}}
@section('title','Employee payroll profile')
{{-- page styles --}}
@section('stylesheet')
   <style>
      .avatar-lg {
         height: 4.5rem;
         width: 4.5rem;
      }
   </style>
@endsection

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
         <li class="breadcrumb-item active">Employee payroll profile</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user-circle"></i> {!! $details->names !!} </h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row mt-3">
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  Payroll information
               </div>
               <div class="card-body">
                  {!! Form::model($details, ['route' => ['hrm.payroll.people.show.update', $details->empID], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
                     @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('type', 'Payment basis', array('class'=>'control-label text-danger')) !!}
                              {!! Form::select('payment_basis', ['' => 'Choose basis','Monthly' => 'Monthly'], null, array('class' => 'form-control multiselect', )) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('Salary amount', 'Salary amount', array('class'=>'control-label text-danger')) !!}
                              {!! Form::text('salary_amount', null, array('class' => 'form-control', 'placeholder' => 'Enter Salary Amount')) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('payment_method', 'Payment Method', array('class'=>'control-label text-danger')) !!}
                              <select class="form-control multiselect" name="payment_method" id="paymentMethod" required>
                                 @if($details->payment_method != "")
                                    @if(Finance::check_account_payment_method($details->payment_method) == 1)
                                       <option value="{!! $details->payment_method !!}">{!! Finance::account_payment_method($details->payment_method)->name !!}</option>
                                    @endif
                                    @if(Finance::check_system_payment($details->payment_method) == 1)
                                       <option value="{!! $details->payment_method !!}">{!! Finance::system_payment($details->payment_method)->name !!}</option>
                                    @endif
                                 @else
                                    <option value="">Choose payment method</option>
                                 @endif
                                 @foreach($mainPaymentType as $main)
                                    <option value="{!! $main->id !!}">{!! $main->name !!}</option>
                                 @endforeach
                                 @foreach($payments as $payment)
                                    <option value="{!! $payment->id !!}">{!! $payment->name !!}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        @if($details->payment_method == 4 || $details->payment_method == 2)
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('account_number', 'BanK Account Number', array('class'=>'control-label')) !!}
                                 {!! Form::text('account_number', null, array('class' => 'form-control', 'placeholder' => 'BanK Account Number')) !!}
                              </div>
                           </div>
                        @endif
                        @if($details->payment_method == 4 || $details->payment_method == 2)
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('bank_name', 'BanK Name', array('class'=>'control-label')) !!}
                                 {!! Form::text('bank_name', null, array('class' => 'form-control', 'placeholder' => 'BanK Name')) !!}
                              </div>
                           </div>
                        @endif
                        @if($details->payment_method == 4 || $details->payment_method == 2)
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('bank_branch', 'BanK Branch', array('class'=>'control-label')) !!}
                                 {!! Form::text('bank_branch', null, array('class' => 'form-control', 'placeholder' => 'BanK Branch')) !!}
                              </div>
                           </div>
                        @endif
                        @if($details->payment_method == 3)
                           <div class="col-md-6">
                              <div class="form-group form-group-default required">
                                 {!! Form::label('mpesa_number', 'Mpesa number', array('class'=>'control-label')) !!}
                                 {!! Form::text('mpesa_number', null, array('class' => 'form-control', 'placeholder' => 'Enter Mpesa Number')) !!}
                              </div>
                           </div>
                        @endif
                        <div class="col-md-12 mt-3">
                           <div class="form-group">
                              <center>
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information</button>
                                 <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                              </center>
                           </div>
                        </div>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
   <script>
      $(document).ready(function() {
         $('#paymentMethod').on('change', function() {
            if(this.value == 4 || this.value == 2) {
               $('.bank').show();
            } else {
               $('.bank').hide();
            }

            if(this.value == 3) {
               $('.mpesa').show();
            } else {
               $('.mpesa').hide();
            }
         });
      });
   </script>
@endsection
