@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Utility Billing | Calculate Bills  @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection  
{{-- content section --}} 
@section('content')
<div id="content" class="content">
   <!-- begin breadcrumb -->
   <ol class="breadcrumb pull-right">
      <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
      <li class="breadcrumb-item"><a href="#">Accounting</a></li>
      <li class="breadcrumb-item active"><a href="#">Utility Billing</a></li>
   </ol>
   <!-- end breadcrumb -->
   <!-- begin page-header -->
   <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Utility Billing | Calculate Bills </h1>
   
   <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12">
            <h3>
               Utility Bills<br>  
               From: {!! date('jS F, Y', strtotime($from)) !!}<br>
               To: {!! date('jS F, Y', strtotime($to)) !!}
            </h3>
         </div>
         <div class="col-md-12">
            <div class="panel panel-inverse">
               <div class="panel-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Tenant</th>
                           <th>Utility</th>
                           <th>Pre </th>
                           <th>Cur </th>
                           <th>Cons </th>
                           <th>price</th>
                           <th>Amount</th>
                           <th width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($utilities as $item)
                           @if($item->unit_price == 0 || $item->unit_price ==  "")
                              <form action="{!! route('property.calculate.utility.consumption',[$propertyID,$item->invoiceProductID]) !!}" method="POST">
                           @else
                              <form action="{!! route('property.update.utility.consumption',[$propertyID,$item->invoiceProductID]) !!}" method="POST">
                           @endif
                              @csrf
                              <input type="hidden" class="form-control" name="invoiceID" value="{!! $item->invoice_id!!}" required>
                              <tr>
                                 <td>{!! $count++ !!}</td>
                                 <td>
                                    {!! $item->tenant_name !!}<br>
                                    <b>Unit#: {!! $item->serial !!}</b>
                                 </td>
                                 <td>{!! $item->utilityName !!}</td>
                                 <td>
                                    @if($item->current_units == "" || $item->current_units == 0)
                                       <input type="text" value="{!! $item->last_reading !!}" class="form-control" name="previous_reading" readonly>
                                    @else 
                                       <input type="text" value="{!! $item->previous_reading !!}" class="form-control" name="previous_reading" readonly>
                                    @endif
                                 </td>
                                 <td>
                                    <input type="text"  name="current" step="0.01" min="{!! $item->last_reading!!}" class="form-control" value="{!! $item->current_units !!} ">
                                 </td>
                                 <td> 
                                    @php 
                                       $consumption = $item->current_units - $item->previous_reading;

                                       if($consumption < 0){
                                          echo 0;
                                       }else{
                                          echo $consumption;
                                       }
                                    @endphp
                                 </td>
                                 <td><input type="text" class="form-control" name="price" value="@if($item->unit_price == 0 || $item->unit_price ==  "" ) {!! $item->price !!} @else {!! $item->unit_price !!} @endif "></td>
                                 <td>
                                    @php 
                                       $answer = $item->unit_price * $consumption;                                    
                                    @endphp
                                    @if($answer > 0)
                                       {!! $answer !!}
                                    @endif
                                 </td>
                                 <td>
                                    @if($item->unit_price == 0 || $item->unit_price ==  "")
                                       <button class="btn btn-warning btn-sm"><i class="fas fa-calculator"></i> Calculate</button>
                                    @else
                                       <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</button>
                                    @endif     
                                 </td>
                              </tr>
                           </form>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div> 
   </div>
</div>
@endsection
