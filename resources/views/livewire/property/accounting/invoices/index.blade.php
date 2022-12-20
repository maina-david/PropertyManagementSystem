<div>
   <div class="col-md-12 mt-3">
      <div class="row">
         <div class="col-md-3">
            <div class="form-group">
               <label for="">Tenant Name</label>
               <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Tenant Name">
            </div>
         </div>
         {{-- <div class="col-md-3">
            <div class="form-group">
               <label for="">From Issue Date</label>
               <input wire:model="from" type="date" class="form-control">
            </div>
         </div>
         <div class="col-md-3">
            <div class="form-group">
               <label for="">To Issue Date</label>
               <input wire:model="to" type="date" class="form-control">
            </div>
         </div> --}}
         <div class="col-md-3">
            <div class="form-group">
               <label for="">Per Page</label>
               <select wire:model="perPage" class="form-control">                  
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="75">75</option>
                  <option value="100">100</option>
               </select>
            </div>
         </div>
         <div class="col-md-12 mt-2">   
            <div class="panel">
               <div class="panel-body">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="1%">#</th>
                           <th>Tenant</th>
                           <th width="8%">Invoice</th>
                           <th>Amount</th>
                           <th>Paid</th>
                           <th>Balance</th>
                           <th>Date</th>
                           <th width="8%">Status</th>
                           <th width="13%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($invoices as $crt => $v)
                           <tr role="row" class="odd"> 
                              <td>{{ $crt+1 }}</td> 
                              <td>
                                 <a class="text-danger" href="{!! route('property.tenants.show',[$propertyID,$v->tenantID]) !!}" target="_blank">{!! $v->tenant_name !!}</a>
                                 @if($v->unitID != "")
                                    @if(Property::check_property_unit($propertyID,$v->unitID) == 1)
                                       <br>
                                       <span class="font-bold badge badge-primary">{!! Property::property_unit($propertyID,$v->unitID)->serial !!}</span>
                                    @endif
                                 @endif
                              </td>
                              <td>
                                 {{ $v->invoice_prefix }}{{ $v->invoice_number }}
                              </td>
                              <td>{!! $property->code !!}{!! number_format($v->total) !!}</td>
                              <td>{!! $property->code !!}{!! number_format($v->paid) !!}</td>
                              <td class="v-align-middle">                       
                                 @if ( $v->statusID == 1 )
                                    <span class="label label-success">Paid</span>
                                 @else
                                    {!! $property->code !!} {{ number_format(round($v->total - $v->paid)) }} 
                                 @endif
                              </td>
                              <td>
                                 {!! date('M j, Y',strtotime($v->invoice_date)) !!} - <br>
                                 {!! date('M j, Y',strtotime($v->invoice_due)) !!}
                              </td>
                              <td><span class="label {!! $v->statusName !!}">{{ $v->statusName }}</span></td>
                              <td>
                                 <a href="{!! route('property.invoice.show',[$propertyID,$v->invoiceID]) !!}" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                 <a href="{!! route('property.invoice.edit',[$propertyID,$v->invoiceID]) !!}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                 <a href="{!! route('property.invoice.delete',[$propertyID,$v->invoiceID]) !!}" class="btn btn-danger btn-sm delete"><i class="far fa-trash"></i></a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
                  {!! $invoices->links() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
