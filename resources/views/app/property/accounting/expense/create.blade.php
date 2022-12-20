@extends('layouts.app')
{{-- page header --}}
@section('title') Expenses | Add | {!! $property->title !!} @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 

@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)">Expense</a></li>
      <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Add Expense </h1>
   <div class="row">
      @include('app.property.partials._property_menu')
      <div class="col-md-12 mt-3">   
         <form action="{!! route('property.expense.store',$property->id) !!}" enctype="multipart/form-data" method="POST" autocomplete="off">
            @csrf
            <div class="row">
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Expenses Details</h4>
                     </div>
                     <div class="panel-body">
                        <div class="form-group form-group-default">
                           <label for="" class="text-danger">Category</label><a href="" class="float-right text-primary" data-toggle="modal" data-target="#expenceCategory">Add category</a>
                           <select name="expense_category" id="selectCategory" class="form-control select2" required></select>
                        </div>
                        <div class="form-group form-group-default">
                           {!! Form::label('Date', 'Date', array('class'=>'control-label text-danger')) !!}
                           {!! Form::date('date', null, array('class' => 'form-control','required' =>'')) !!}
                        </div>
                        <div class="form-group form-group-default">
                           {!! Form::label('Title', 'Title', array('class'=>'control-label text-danger')) !!}
                           {!! Form::text('expense_name', null, array('class' => 'form-control', 'placeholder' => 'Expense Title', 'required' =>'')) !!}
                        </div>
                        <div class="row">
                           <div class="col-sm-6">
                              <div class="form-group form-group-default" aria-required="true">
                                 {!! Form::label('Amount', 'Amount', array('class'=>'control-label text-danger')) !!}
                                 {!! Form::number('amount', null, array('class' => 'form-control', 'placeholder' => 'Amount', 'required' =>'')) !!}
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group form-group-default">
                                 <label for="">Chosse Tax Rate </label><a href="javascript()" class="float-right text-primary" data-toggle="modal" data-target="#taxRate">Add Tax Rate</a>
                                 <select name="tax_rate" id="selectTax" class="form-control select2"></select>
                              </div>
                           </div>
                        </div>
                        <div class="form-group form-group-default">
                           <label for="" class="">Supplier <a href="" class="pull-right" data-toggle="modal" data-target="#addSupplier">Add Supplier</a></label>
                           <select name="supplier" id="selectSupplier" class="form-control select2"></select>
                        </div>
                        <div class="form-group form-group-default">
                           {!! Form::label('Reference', 'Reference (i.e Payment Code)', array('class'=>'control-label')) !!}
                           {!! Form::text('refrence_number', null, array('class' => 'form-control', 'placeholder' => 'Reference')) !!}
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Expence Details</h4>
                     </div>
                     <div class="panel-body">                  
                        <div class="form-group form-group-default">
                           <label for="">Allocate to lease </label>
                           <select name="" class="form-control multiselect">
                              <option value="leaseID">Choose Lease</option>
                              @foreach ($leases as $lease)
                                 <option value="{!! $lease->leaseID !!}">{!! $lease->serial !!} | {!! $lease->tenant_name !!}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group form-group-default">
                           <label for="">Allocate to Unit</label>
                           <select name="unitID" class="form-control multiselect">
                              <option value="">Choose Unit</option>
                              @foreach ($units as $unit)
                                 <option value="{!! $unit->propID !!}">{!! $unit->serial !!}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group form-group-default">
                           {!! Form::label('Choose status', 'Choose status', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('status', [''=>'Choose status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ]) }}
                        </div>
                        <div class="form-group form-group-default">
                           <label for="">Method Of Payment</label>
                           <select name="payment_method" class="form-control multiselect">
                              @foreach($mainMethods as $main)
                                 <option value="{!! $main->id !!}">{!! $main->name !!}</option>
                              @endforeach
                              @foreach($paymentmethod as $method)
                                 <option value="{!! $method->id !!}">{!! $method->name !!}</option>
                              @endforeach
                           </select>                     
                        </div>
                        <div class="form-group form-group-default">
                           {!! Form::label('Expence Files', 'Expense Files', array('class'=>'control-label')) !!}<br>
                           <input type="file" name="files[]" id="files" multiple>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Description</h4>
                     </div>
                     <div class="panel-body">
                        <div class="form-group">
                           {!! Form::textarea('description',null,['class'=>'form-control my-editor', 'rows' => 9, 'placeholder'=>'content']) !!}
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 mb-5">
                  <center>
                     <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Add Expense</button>		
                     {{-- <img src="{!! url('/') !!}/app/img/btn-loader.gif" class="submit-load none" alt="" width="10%">				 --}}
                  </center>
               </div>
            </div>
         </form>
      </div>
      @include('app.finance.expense.category.express')
      @include('app.finance.taxes.express')	
      @include('app.finance.payments.express')	
   </div>
</div>
@endsection
@section('scripts')
	@include('app.partials._express_scripts')	
@endsection