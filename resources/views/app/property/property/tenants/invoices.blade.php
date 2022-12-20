<div class="col-md-12 mt-3">   
   <div class="panel">
      <div class="panel-heading"><b>Tenant Invoices</b></div>
      <div class="panel-body">
         <table id="example5" class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th width="13%">Invoice #</th>
                  <th>Amount</th>
                  <th>Paid</th>
                  <th>Balance</th>
                  <th>Due Date</th>
                  <th>Status</th>
                  <th width="11%">Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($invoices as $crt => $v)
                  <tr role="row" class="odd"> 
                     <td>{{ $crt+1 }}</td>
                     <td>
                        {{ $v->invoice_prefix }}{{ $v->invoice_number }}
                     </td>
                     <td>{!! $business->code !!}{!! number_format($v->total) !!}</td>
                     <td>{!! $business->code !!}{!! number_format($v->paid) !!}</td>
                     <td class="v-align-middle">
                       
                           @if ( $v->statusID == 1 )
                              <span class="label label-success">Paid</span>
                           @else
                           {!! $business->code !!} {{ number_format(round($v->total - $v->paid)) }} 
                           @endif
                     </td>
                     <td>{!! date('F j, Y',strtotime($v->invoice_due)) !!}</td>
                     <td><span class="label {!! $v->statusName !!}">{{ $v->statusName }}</span></td>
                     <td>
                        <a href="{!! route('property.invoice.show',[$propertyID,$v->invoiceID]) !!}" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a href="{!! route('property.rental.billing.edit',[$propertyID,$v->invoiceID]) !!}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                        <a href="{!! route('property.invoice.delete',[$propertyID,$v->invoiceID]) !!}" class="btn btn-danger btn-sm delete"><i class="far fa-trash"></i></a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
