@extends('layouts.app')
@section('title'){!! $property->title !!} | Billing | Edit Invoices @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item"><a href="javascript:void(0)">Billing</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i> Propery | Create | Billing</h1>
      
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-12">
                  {{ Form::open(array('route' => ['property.invoice.store',$propertyID], 'role' => 'form', 'class' => 'solsoForm')) }}
                  @csrf
                  <div class="panel">
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-3 col-lg-3">
                              <div class="form-group form-group-default">
                                 <label for="tenant" class="text-danger">Choose Tenant *</label>
                                 {!! Form::select('tenant',$tenants,null,['class'=>'form-control multiselect','id' => 'tenant','required' => '']) !!}
                              </div>
                           </div> 
                           <div class="col-md-3 col-lg-3">
                              <div class="form-group">
                                 <label for="number">Invoice Number</label>
                                 <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                       <div class="input-group-text">{{ $settings->prefix }}</div>
                                    </div>
                                    <input type="text" value="{{ $settings->number + 1 }}" name="invoice_number" class="form-control" readonly> 
                                    <input type="hidden" name="invoice_prefix" value="{{ $settings->prefix }}" required>
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
                                 <label for="" class="text-danger">Choose Billing Category</label>
                                 <select name="category" class="form-control multiselect" id="billing_category" required>
                                    <option value="">Choose category</option>
                                    @foreach($incomes as $income)
                                       @if($income->id != 2)
                                          <option value="{!! $income->id !!}">{!! $income->name !!}</option>
                                       @endif
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
                                 <label for="date" class="text-danger">Tax *</label>
                                 <select name="tax_rate" class="form-control multiselect" required>
                                    <option value="0">Choose Tax</option>
                                    @foreach ($taxes as $tax)                                 
                                       <option value="{!! $tax->rate !!}">{!! $tax->name !!} - {!! $tax->rate !!}%</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3 col-lg-3">
                              <div class="form-group form-group-default">
                                 <label for="end">Title</label>
                                 <input type="text" name="invoice_title" class="form-control" autocomplete="off" placeholder = "Enter title">
                              </div>
                           </div>
                           <div class="col-md-3 col-lg-3">
                              <div class="form-group form-group-default required">
                                 <label for="end" class="text-danger">Unit #</label>
                                 <select name="leaseID" id="leases" class="form-control" required>

                                 </select>
                              </div> 
                           </div>
                        </div>                  
                     </div>
                  </div>
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Invoice Note | Terms & conditions</h4>
                     </div>
                     <div class="panel-body">
                        <div class='row mt-3'>
                           <div class="col-md-6 mt-3">
                              <label for="">Customer Notes</label>
                              <textarea name="customer_note" class="form-control my-editor" rows="8" cols="80"></textarea>
                           </div>
                           <div class="col-md-6 mt-3">
                              <label for="">Terms & Conditions</label>
                              <textarea name="terms" class="form-control my-editor" rows="8" cols="80"></textarea>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5'>
                     <div class='form-group text-center'>
                        <center>
                           <button type="submit"class="btn btn-success btn-lg submit"><i class="fas fa-save"></i> Create Invoice </button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                        </center>
                     </div>
                  </div>
                  {{ Form::close() }}
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@include('app.property.partials._invoice')
@section('script2')
   <script type="text/javascript">
      $('#tenant').on('change',function(e){
         console.log(e);
         var tenant =  e.target.value;
         var propertyID =  "{{ $propertyID }}";
         var url = "{{ url('/') }}";

         //ajax 
         $.get(url+'/property-management/property/'+propertyID+'/invoices/'+tenant+'/leases', function(data){
            //success data
            $('#leases').empty();
            $.each(data, function(leases, lease){
               $('#leases').append('<option value="'+ lease.leaseID +'">'+lease.serial+'</option>');
            });
         });
      });
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