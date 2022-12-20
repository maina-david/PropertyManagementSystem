<div>
   <div class="col-md-12">
      <div class="row">
         <div class="col-md-12 mt-2 mb-2">
            <a href="#" data-toggle="modal" data-target="#bulk" class="btn btn-primary"><i class="fal fa-plus-circle"></i> Bulk utility billing</a>
            {{-- <a href="#" class="btn btn-warning"><i class="fal fa-plus-circle"></i> Single utility billing</a> --}}
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <input wire:model.debounce.300ms="search" type="text" class="form-control" placeholder="Enter Tenant Name">
            </div>
         </div> 
         <div class="col-md-4">
            <div class="form-group">
               <select wire:model="utility" class="form-control">
                  <option value="">Choose Utility</option>
                  @foreach ($utilities as $utility)
                     <option value="{!! $utility->id !!}">{!! $utility->name !!}</option>
                  @endforeach
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <select wire:model="perPage" class="form-control">                  
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                  <option value="75">75</option>
                  <option value="100">100</option>
               </select>
            </div>
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
                           <th>Prev</th>
                           <th>Curr</th>
                           <th>Cons</th>
                           <th>price</th>
                           <th>Amount</th>
                           <th>Paid</th>
                           <th>Balance</th>
                           <th>Status</th>
                           <th>Period</th>
                           <th width="12%">Action</th>
                        </tr>
                     </thead> 
                     <tbody>
                        @foreach($invoices as $invoice)
                           <input type="hidden" name="invoiceID" value="{!! $invoice->invoiceID !!}">
                           @csrf
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>
                                 {!! $invoice->tenant_name!!}<br>
                                 <span class="badge badge-warning">{!! $invoice->utility_No !!}</span>
                              </td>
                              <td>{!! $invoice->item_name!!}</td>
                              <td>
                                 @if($invoice->current_units == "" || $invoice->current_units == 0)
                                    {!! $invoice->last_reading!!}
                                 @else 
                                    {!! $invoice->previous_units!!}
                                 @endif
                              </td>
                              <td>{!! $invoice->current_units !!}</td>
                              <td>{!! $invoice->quantity !!}</td>
                              <td>{!! $invoice->unitPrice!!}</td>  
                              <td>{!! $invoice->code!!} {!! number_format($invoice->total_amount) !!}</td>
                              <td> 
                                 {!! $invoice->code !!}{!! number_format($invoice->paid) !!}  
                              </td>  
                              <td> 
                                 @if($invoice->statusID == 1 )
                                    <span class="label label-success">Paid</span>
                                 @else
                                    {!! $invoice->code !!} {{ number_format(round($invoice->invoice_total - $invoice->paid)) }} 
                                 @endif      
                              </td>  
                              <td> 
                                 <span class="label {!! $invoice->status_name !!}">{{ $invoice->status_name }}</span>  
                              </td>  
                              <td>
                                 <b>{!! date('d M, y', strtotime($invoice->invoice_date)) !!} - <br>{!! date('d M, y', strtotime($invoice->invoice_due)) !!}</b>   
                              </td>
                              <td>
                                 <a href="{!! route('property.utility.billing.show',[$propertyID,$invoice->invoiceID]) !!}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                                 @if($invoice->status_name == 'unpaid' )
                                    @if($invoice->current_units == "" || $invoice->current_units == 0)
                                       <a href="#" title="Add Current reading and calculate" data-toggle="modal" data-target="#editUtility{!! $invoice->invoiceID !!}" class="btn btn-sm btn-success"><i class="fad fa-calculator-alt"></i></a>
                                    @else 
                                       <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editUtility{!! $invoice->invoiceID !!}"><i class="fas fa-edit"></i></a>
                                    @endif
                                 @endif
                                 <a href="{!! route('property.utility.billing.delete',[$propertyID,$invoice->invoiceID]) !!}" class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></a>
                              </td>
                           </tr>
                           <!-- Modal -->
                           <div class="modal fade" id="editUtility{!! $invoice->invoiceID !!}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                 @if($invoice->current_units == "" || $invoice->current_units == 0)
                                    <form action="{!! route('property.calculate.utility.consumption',[$propertyID,$invoice->invoiceProductID]) !!}" method="post" autocomplete="off">
                                 @else 
                                    <form action="{!! route('property.update.utility.consumption',[$propertyID,$invoice->invoiceProductID]) !!}" method="POST">
                                 @endif
                                    @csrf
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          @if($invoice->current_units == "" || $invoice->current_units == 0)
                                             <h5 class="modal-title" id="exampleModalLongTitle">Calculate Utility Bill</h5>
                                          @else 
                                             <h5 class="modal-title" id="exampleModalLongTitle">Update Utility Bill</h5>
                                          @endif
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">                                       
                                          <div class="form-group">
                                             <label for="">Current Consumption</label>
                                             <input type="number" class="form-control" name="current" step="0.01" min="{!! $invoice->previous_units!!}" value="{!! $invoice->current_units!!}" required>
                                             <input type="hidden" class="form-control" name="invoiceID" value="{!! $invoice->invoiceID!!}" required>
                                          </div>
                                          <div class="form-group">
                                             <label for="">Current Price</label>
                                             <input type="number" class="form-control" step="0.01" name="price" value="{!! $invoice->unitPrice!!}" required>
                                          </div>
                                          {{-- <div class="form-group">
                                             <input type="checkbox" name="Email" id="">
                                             <label for="">Send Email After Calculation</label>                                        
                                          </div> --}}
                                          {{-- <div class="form-group">                                          
                                             <input type="checkbox" name="SMS" id="">
                                             <label for="">Send SMS After calculation</label>
                                          </div> --}}
                                       </div>
                                       <div class="modal-footer">         
                                          @if($invoice->current_units == "" || $invoice->current_units == 0)                              
                                             <button type="submit" class="btn btn-success submit">Calculating Utility Billing</button>
                                          @else 
                                             <button type="submit" class="btn btn-warning submit">Update Utility Billing</button>
                                          @endif
                                          <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="Loader" width="15%">
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        @endforeach
                     </tbody>
                  </table>
                  {!! $invoices->links() !!}
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal -->
   <div class="modal fade" id="bulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Billing Details</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="{!! route('property.prepare.utility.billing',$propertyID) !!}" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Issue Date</label>
                           {!! Form::date('issue_date',null,['class'=>'form-control','required'=>'']) !!}
                        </div>
                     </div> 
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="">Due Date</label>
                           {!! Form::date('due_date',null,['class'=>'form-control','required'=>'']) !!}
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Utility</label>
                           <select name="utility" class="form-control" required>
                              <option value="">Choose Utility</option>
                              @foreach ($utilities as $utility)
                                 <option value="{!! $utility->id !!}">{!! $utility->name !!}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="">Customer Note</label>
                           {!! Form::textarea('customer_note',null,['class'=>'form-control','size' => '9 x 9']) !!}
                        </div>
                     </div>  
                     <div class="col-md-12">
                        <button class="btn btn-success float-right submit" type="submit"><i class="fas fa-save"></i> Save and process billing</button>
                        <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load float-right none" alt="Loader" width="25%">
                     </div>                 
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div> 
