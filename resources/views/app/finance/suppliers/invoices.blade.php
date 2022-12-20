<div class="card">
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th width="13%">Invoice #</th>
               <th>Amount</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th>Invoice #</th>
               <th>Amount</th>
               <th>Paid</th>
               <th>Balance</th>
               <th>Due Date</th>
               <th>Status</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            @foreach ($invoices as $crt => $v)
               <tr role="row" class="odd">
                  <td>{{ $crt+1 }}</td>
                  <td>
                     {{ Finance::invoice_settings('finance')->code }}-{{ $v->number }}
                  </td>
                  <td><p>{!! number_format($v->amount) !!} {!! $v->currency !!}</p></td>
                  <td>{!! number_format($v->paidamount) !!} {!! $v->currency !!}</td>
                  <td class="v-align-middle">
                     <p>
                        @if ( $v->status == 'paid' )
                           <span class="label label-success">Paid</span>
                        @else
                           {{ number_format(round($v->amount - $v->paidamount)) }} {!! $v->currency !!}
                        @endif
                     </p>
                  </td>
                  <td><p>{!! date('F j, Y',strtotime($v->due_date)) !!}</p></td>
                  @if ($v->amount - $v->paidamount < 0)
                     <td><span class="label label-success">Paid</span></td>
                  @else
                     <td><span class="label label-{{ str_replace('', '-', $v->status) }} ">{{ $v->status }}</span></td>
                  @endif
                  <td>
                     <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                        <ul class="dropdown-menu">
                           <li><a href="{{ route('finance.invoice.product.show', $v->id) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                           @if ($v->type == 'Random')
                              <li><a href="{!! route('finance.invoice.random.edit', $v->id) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           @endif
                           @if($v->type == 'Product')
                              <li><a href="{!! route('finance.invoice.product.edit', $v->id) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           @endif
                           @if($v->type == 'Recurring')
                              <li><a href="{!! route('finance.invoice.recurring.edit', $v->id) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           @endif
                           <li><a href="{!! route('finance.invoice.product.delete', $v->id) !!}"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                           <li class="divider"></li>
                           <li><a href="#">The end</a></li>
                        </ul>
                     </div>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
