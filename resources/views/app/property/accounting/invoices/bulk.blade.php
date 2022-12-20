@extends('layouts.app')
@section('title')Propery | {!! $property->title !!} | Billing | Bulk @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Billing</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Bulk</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> Propery | {!! $property->title !!} | Billing | Bulk</h1>
      
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-12"> 
                  {{ Form::open(array('route' => ['property.invoice.store.bulk',$propertyID], 'role' => 'form', 'class' => 'solsoForm')) }}
                     @csrf
                     <div class="panel">
                        <div class="panel-heading">Rental Bulk Billing Details</div>
                        <div class="panel-body">
                           <div class="row">                    
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group">
                                    <label for="number">Invoice Number</label>
                                    <div class="input-group mb-2">
                                       <div class="input-group-prepend">
                                          <div class="input-group-text">{{ $invoiceSetting->prefix }}</div>
                                       </div>
                                       <input type="text" value="{{ $invoiceSetting->number + 1 }}" name="invoice_number" class="form-control" readonly> 
                                       <input type="hidden" value="{{ $invoiceSetting->prefix }}" name="invoice_prefix" required>
                                    </div>
                                 </div>                        
                              </div> 
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="date" class="text-danger">Issue Date *</label>
                                    {!! Form::date('invoice_date', null, array('class' => 'form-control', 'placeholder' => 'YYY-MM-DD','required' => '')) !!}
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="end" class="text-danger">Due Date * </label>
                                    {!! Form::date('invoice_due', null, array('class' => 'form-control', 'placeholder' => 'YYY-MM-DD','required' => '')) !!}
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default required">
                                    <label for="" class="text-danger">
                                       What would you want to bill?
                                    </label>
                                    <select name="category" class="form-control select2" id="billing_category" required>
                                       <option value="">Choose</option>
                                       @foreach($category as $cat)
                                          <option value="{!! $cat->id !!}">{!! $cat->name !!}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3" style="display: none" id="apply_tax">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Apply tax to', 'Apply tax to', array('class'=>'control-label text-danger')) !!}
                                    {!! Form::select('apply_tax_to', ['Rent' => 'Rent Alone','All' => 'All Items'], null, array('class' => 'form-control multiselect','required' => '')) !!}
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="date" class="">Tax</label>
                                    <select name="tax_rate" class="form-control multiselect" >
                                       <option value="0">Choose Tax</option>
                                       @foreach ($taxes as $tax)                                 
                                          <option value="{!! $tax->rate !!}">{!! $tax->name !!} - {!! $tax->rate !!}%</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3 col-lg-3">
                                 <div class="form-group form-group-default">
                                    <label for="end">Subject</label>
                                    <input type="text" name="invoice_title" class="form-control" autocomplete="off" placeholder = "Enter invoice title">
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group form-group-default required ">
                                    {!! Form::label('Lease Type', 'Lease Type', array('class'=>'control-label text-danger')) !!}
                                    {!! Form::select('lease_type', ['' => 'Choose Type','Commercial Lease' => 'Commercial Lease', 'Residential Lease' => 'Residential Lease'], null, array('class' => 'form-control multiselect','required' => '')) !!}
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group form-group-default">
                                    <label for="" class="text-danger">Billing schedule
                                       <span  class="pull-right" data-container="body" data-toggle="popover" data-placement="right" data-content="This will select the leases for defined by the shedule you choose" title="" ><i class="fas fa-info-circle"></i></span>  
                                    </label>                         
                                    {!! Form::select('billing_schedule', [''=>'Choose',7 => 'Weekly',1 => 'Monthly',3 => 'Quarterly',6 => 'Half Year',12 => 'Yearly'], null, array('class' => 'form-control', 'required' => '')) !!}
                                 </div>
                              </div>
                              
                              <div class="col-md-12">
                                 <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Process Billing</button>
                                 {{-- <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%"> --}}
                              </div>
                           </div>                  
                        </div>
                     </div>
                  {{ Form::close() }}
               </div>
            </div>
         </div>
      </div>
   </div>
   @include('app.property.partials._invoice')
@endsection
@section('script2')
   <script>
      $(document).ready(function() {
         $('#billing_category').on('change', function() {
            if (this.value == 38) {
               $('#apply_tax').show();
            } else {
               $('#apply_tax').hide();
            }
         });
      });
   </script>
@endsection