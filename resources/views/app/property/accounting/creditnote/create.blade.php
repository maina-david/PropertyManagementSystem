@extends('layouts.app')
{{-- page header --}}
@section('title') {!! $property->title !!} | Add Credit Notes @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="j{!! route('property.creditnote.index',$property->id) !!}">Credit Notes</a></li>
         <li class="breadcrumb-item active"><a href="{!! route('property.creditnote.index',$property->id) !!}">Index</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Credit Notes</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
            <div class="col-md-12">
               <form action="{!! route('property.creditnote.store',$property->id) !!}" method="POST" class="solsoForm" autocomplete="off">
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
                                 <label for="number">Credit Note Number</label>
                                 <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                       <div class="input-group-text">{{ $settings->prefix }}</div>
                                    </div>
                                    <input type="text" value="{{ $settings->number + 1 }}" name="creditnote_number" class="form-control" readonly>
                                    <input type="hidden" name="creditnote_prefix" value="{{ $settings->prefix }}" required>
                              </div>
                              </div>
                           </div>
                           <div class="col-md-3 col-lg-3">
                              <div class="form-group form-group-default">
                                 <label for="date" class="text-danger">Credited Date </label>
                                 {!! Form::date('creditnote_date', null, array('class' => 'form-control','required' => '')) !!}
                              </div>
                           </div>
                           <div class="col-md-3 col-lg-3">
                              <div class="form-group form-group-default">
                                 <label for="end">Title</label>
                                 <input type="text" name="title" class="form-control" autocomplete="off" placeholder = "Enter title">
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
                  <div class="panel panel-default mt-3">
                     <div class="panel-heading">
                        <h4 class="panel-title"><b>Credit Note Items</b></h4>
                     </div>
                     <div class="panel-body">
                        <div class='row mt-3'>
                           <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                              <table class="table table-bordered table-striped" id="creditNoteItems">
                                 <thead>
                                    <tr>
                                       <th width="35%">Item Name</th>
                                       <th width="13%">Quantity</th>
                                       <th width="13%">Price</th>
                                       <th width="13%">Tax</th>
                                       <th width="25%">Total</th>
                                       <th width=""></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr class="clone-item">
                                       <td>
                                          <textarea type="text" name="product_name[]" class="form-control" required></textarea>
                                       </td>
                                       <td>
                                          <input type="number" name="qty[]" id="quantity_0" class="form-control changesNo quanyityChange" required>
                                       </td>
                                       <td>
                                          <input type="number" name="price[]" id="price_0" class="form-control onchange changesNo" step="0.01" required>
                                       </td>
                                       <td>
                                          <select name="tax[]" class="form-control onchange" id="tax_0">
                                             <option value="0">Choose tax rate</option>
                                             <option value="0">No Tax</option>
                                             @foreach ($taxes as $tx)
                                                <option value="{{ $tx->rate }}"> {{ $tx->name }}-{{ $tx->rate }}%</option>
                                             @endforeach
                                          </select>
                                          <input type="hidden" id="taxvalue_0" name="taxValue[]" class="form-control totalLineTax addNewRow" autocomplete="off" step="0.01" readonly>
                                       </td>
                                       <td>
                                          <input type="hidden" id="mainAmount_0" class="form-control mainAmount addNewRow" autocomplete="off" placeholder="Main Amount" step="0.01" readonly>
                                          <input type="hidden" id="amountAfterDiscount_0" class="form-control totalLinePrice addNewRow" autocomplete="off" placeholder="Amount After Discount" step="0.01" readonly>
                                          <input type="text" id="totalAmount_0" class="form-control totalSum addNewRow" autocomplete="off" placeholder="Total Amount" step="0.01" readonly>
                                       </td>
                                       <td><a href="javascript:void(0)" class="remove-item btn btn-sm btn-danger remove-social-media"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                 </tbody>
                                 <tfoot>
                                    <tr>
                                       <td colspan="2" class="col-md-12 col-lg-8"></td>
                                       <td colspan="2" style="width:20%">
                                          <h4 class="pull-right top10">Sub Total</h4>
                                       </td>
                                       <td colspan="3">
                                          <h4 class="text-center">
                                             <input readonly type="number" class="form-control" id="subTotal" step="0.01">
                                          </h4>
                                       </td>
                                    </tr>
                                    <tr id="taxfield">
                                       <td colspan="2" class="col-md-12 col-lg-8"></td>
                                       <td colspan="2" style="width:20%">
                                          <h4 class="pull-right top10">Tax</h4>
                                       </td>
                                       <td colspan="3">
                                          <h4 class="text-center">
                                             <input readonly type="number" class="form-control" id="taxvalue" step="0.01">
                                          </h4>
                                       </td>
                                    </tr>
                                    <tr class="table-default">
                                       <td colspan="2" class="col-md-12 col-lg-8"></td>
                                       <td colspan="2" style="width:20%">
                                          <h4 class="pull-right top10">Total Amount</h4>
                                       </td>
                                       <td colspan="3">
                                          <h4 class="text-center">
                                             <input readonly type="number" class="form-control" id="InvoicetotalAmount" placeholder="Total" step="0.01">
                                          </h4>
                                       </td>
                                    </tr>
                                 </tfoot>
                              </table>
                           </div>
                        </div>
                        <div class='row mb-3'>
                           <div class='col-xs-12 col-sm-3 col-md-3 col-lg-3'>
                              <a class="btn btn-primary" id="addRows" href="javascript:;">+ Add More</a>
                           </div>
                        </div>
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                     </div>
                  </div>
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Credit Note | Terms & conditions</h4>
                     </div>
                     <div class="panel-body">
                        <div class='row mt-3'>
                           <div class="col-md-6 mt-3">
                              <label for="">Tenant Notes</label>
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
                           <button type="submit"class="btn btn-success btn-lg submit"><i class="fas fa-save"></i> Create Credit Note </button>
                           <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                        </center>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   @include('app.property.partials._creditnote_scripts')
@endsection
@section('script2')
   <script type="text/javascript">
      $('#tenant').on('change',function(e){
         console.log(e);
         var tenant =  e.target.value;
         var propertyID =  "{{ $property->id }}";
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
   </script>
@endsection
