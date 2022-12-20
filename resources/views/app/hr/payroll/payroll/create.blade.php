@extends('layouts.app')
{{-- page header --}}
@section('title','Run payroll')
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
         <li class="breadcrumb-item active">Run payroll</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-file-invoice-dollar"></i> Run payroll</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <!-- begin panel -->
      <div class="row">
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-8">
                  <div class="card">
                     <div class="card-header">
                        Run payroll for
                     </div>
                     <div class="card-body">
                        <form action="{!! route('hrm.payroll.process.post') !!}" method="post" autocomplete="off">
                           @csrf
                           <div class="form-group form-group-default required">
                              <label for="" class="text-danger">Branch</label>
                              <select name="branch" class="form-control multiselect" required>
                                 <option name="" id="">Choose</option>
                                 <option name="All" id="">All</option>
                                 @foreach ($branches as $branch)
                                    <option value="{!! $branch->id !!}">{!! $branch->branch_name !!}</option>
                                 @endforeach
                              </select>
                           </div>
                           {{-- <div class="form-group form-group-default required">
                              <label for="">Choose Department</label>
                              <select class="form-control multiselect" name="department" required>
                                 <option value="">Choose department</option>
                                 <option value="All">All</option>
                                 @foreach($departments as $department)
                                    <option value="{!! $department->id !!}">{!! $department->title !!}</option>
                                 @endforeach
                              </select>
                           </div> --}}
                           <div class="form-group form-group-default required">
                              <label class="text-danger">Payroll type</label>
                              {!! Form::select('payroll_type',['' => 'Choose basis','Monthly' => 'Monthly','Bi-weekly' => 'Bi-weekly','Daily' => 'Daily'], null, array('class' => 'form-control multiselect','required' =>'')) !!}
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">Payroll For</label>
                                    <input type="date" class="form-control" name="payroll_date" required>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group mt-2">
                              <center>
                                 <button class="btn btn-pink submit" type="submit"><i class="fas fa-sync-alt"></i> Run payroll</button>
                                 <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                              </center>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3"></div>
      </div>
      <!-- end panel -->
   </div>
@endsection
