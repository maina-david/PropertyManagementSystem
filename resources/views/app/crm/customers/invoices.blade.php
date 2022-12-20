<div class="card mt-3">
   <div class="card-header"><i class="fal fa-file-invoice-dollar"></i> Invoices</div>
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
                     <b>{{ Finance::invoice_settings()->prefix }}{{ $v->invoice_number }}</b>
                  </td>
                  <td><b>{!! $client->code !!} {!! number_format($v->total) !!}</b></td>
                  <td>{!! $client->code !!} {!! number_format($v->paid) !!}</td>
                  <td class="v-align-middle">

                     @if( $v->statusID == 1 )
                        <span class="badge {!! Wingu::status($v->statusID)->name !!}">{!! ucfirst(Wingu::status($v->statusID)->name) !!}</span>
                     @else

                        <b>
                     {!! $client->code !!} {{ number_format(round($v->total - $v->paid)) }}</b>
                     @endif
                  </td>
                  <td><p>{!! date('F j, Y',strtotime($v->invoice_due)) !!}</p></td>
                  @if ($v->total - $v->paid < 0)
                     <td><span class="badge {!! Wingu::status($v->statusID)->name !!}">{!! ucfirst(Wingu::status($v->statusID)->name) !!}</span></td>
                  @else
                     <td>
                        @if($v->statusID != "")
                           <span class="badge {!! Wingu::status($v->statusID)->name !!}">{!! ucfirst(Wingu::status($v->statusID)->name) !!}</span>
                        @endif
                     </td>
                  @endif
                  <td>
                     <a href="{{ route('finance.invoice.show', $v->id) }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> view</a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
