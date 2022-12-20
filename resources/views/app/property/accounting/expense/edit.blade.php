@extends('layouts.app')
{{-- page header --}}
@section('title') Expenses | Edit | {!! $property->title !!} @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- page styles --}}
@section('breadcrum')
   <div class="row page-titles mx-0">
      <div class="col-sm-6 p-md-0">
         <div class="welcome-text">
            <h4><i class="fal fa-home"></i> {!! $property->title !!} | Expense | Edit </h4>
         </div>
      </div>
      <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
            <li class="breadcrumb-item"><a href="{!! route('property.show',$property->id) !!}">{!! $property->title !!}</a></li>
            <li class="breadcrumb-item"><a href="{!! route('property.expense',$property->id) !!}">Expense</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('property.expense.edit',[$property->id,$expense->id]) }}">Edit</a></li> 
         </ol>
      </div>
   </div>
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
   <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Edit Expense </h1>
   <div class="row">
      @include('app.property.partials._property_menu')
      <div class="col-md-12 mt-3">   
         {!! Form::model($expense, ['route' => ['property.expense.update',[$property->id,$expense->id]], 'method'=>'post','enctype'=>'multipart/form-data', 'autocomplete' => 'off']) !!}
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
                           <select name="expense_category" id="selectCategory" class="form-control select2" required>
                              @if($expense->expense_category != "")
                                 <option value="{!! $expense->expense_category !!}">{!! $expenseCategory->category_name !!}</option>
                              @endif
                           </select>
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
                                 <select name="tax_rate" id="selectTax" class="form-control select2">
                                    @if($expense->tax_rate != "") 
                                       <option value="{!! $expense->tax_rate !!}">{!! $tax->name !!} | {!! $tax->rate !!}%</option>
                                    @endif
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="form-group form-group-default">
                           <label for="" class="">Supplier <a href="" class="pull-right" data-toggle="modal" data-target="#addSupplier">Add Supplier</a></label>
                           <select name="supplier" id="selectSupplier" class="form-control select2">
                              @if($expense->supplierID != "")
                                 <option value="{!! $expense->supplierID !!}">{!! $supplier->supplierName !!}</option>
                              @endif
                           </select>
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
                           <select name="leaseID" class="form-control multiselect">
                              @if($expense->leaseID != "")
                                 <option value="{!! $expense->leaseID !!}">{!! $leaseInfo->serial !!} | {!! $leaseInfo->tenant_name !!}</option>
                              @else 
                                 <option value="leaseID">Choose Lease</option>
                              @endif
                              @foreach($leases as $lease)
                                 <option value="{!! $lease->leaseID !!}">{!! $lease->serial !!} | {!! $lease->tenant_name !!}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="form-group form-group-default">
                           <label for="">Allocate to Unit</label>
                           {!! Form::select('unitID',$units,null,['class' => 'form-control multiselect']) !!}
                        </div>
                        <div class="form-group form-group-default">
                           {!! Form::label('Choose status', 'Choose status', array('class'=>'control-label text-danger')) !!}
                           {{ Form::select('statusID', [''=>'Choose status','1'=>'Paid','2'=>'Unpaid','18'=>'Dept'], null, ['class' => 'form-control multiselect','required' =>'', 'autocomplete' => 'off'  ]) }}
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
                        <div class="row mt-4">
                           @foreach ($files as $file)
                              <div class="col-md-2">
                                 @if(stripos($file->file_mime, 'image') !== FALSE)
                                    <img src="{!! asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/expense/'.$file->file_name) !!}" alt="" style="width:100%;height:80px">
                                 @elseif(stripos($file->file_mime, 'pdf') !== FALSE)
                                    <center><i class="fas fa-file-pdf fa-4x" style="width:100%;height:80px"></i></center>
                                 @elseif(stripos($file->file_mime, 'octet-stream') !== FALSE)
                                    <center><i class="fas fa-file-alt fa-4x" style="width:100%;height:80px"></i></center>
                                 @elseif(stripos($file->file_mime, 'officedocument') !== FALSE)
                                    <center><i class="fas fa-file-word fa-4x" style="width:100%;height:80px"></i></center>
                                 @else
                                    <center><i class="fas fa-file fa-4x" style="width:100%;height:80px"></i></center>
                                 @endif
                                 <center>
                                    @permission('update-expense')
                                       <a href="{!! route('property.expense.delete.file',[$property->id,$expense->id,$file->id]) !!}" title="delete" class="badge badge-danger delete"><i class="fas fa-trash"></i></a>
                                    @endpermission
                                    <a href="{!! asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/expense/'.$file->file_name) !!}" title="download" class="badge badge-primary mt-1" target="_blank"><i class="fas fa-download"></i></a>
                                    <a href="{!! asset('businesses/'.$business->businessID.'/property/'.$property->property_code.'/expense/'.$file->file_name) !!}" title="view" class="badge badge-warning mt-1" target="_blank"><i class="fas fa-eye"></i></a>
                                 </center>
                              </div>
                           @endforeach
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
                     <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Update Expense</button>		
                     {{-- <img src="{!! url('/') !!}/app/img/btn-loader.gif" class="submit-load none" alt="" width="10%">				 --}}
                  </center>
               </div>
            </div>
         {!! Form::close() !!}
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