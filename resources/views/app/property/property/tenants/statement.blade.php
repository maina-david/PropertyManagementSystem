<div class="panel">
   <div class="panel-body">
      <div class="row">
         <div class="col-md-12">
            <ol class="breadcrumb pull-right">
               <a href="#" target="_blank" class="btn btn-pink"><i class="fas fa-print"></i> Export for Print</a>
               <a href="#" class="btn btn-pink ml-2"><i class="fas fa-file-pdf"></i> Export for PDF</a>
               <a href="#" class="btn btn-pink ml-2"><i class="fas fa-file-excel"></i> Export to Excel</a>
               {{-- <a href="#" class="btn btn-pink ml-2"><i class="fas fa-envelope-open-text"></i> Email Client</a> --}}
            </ol>
         </div>
      </div>
      <table class="table table-bordered mt-3">
         <thead>
            <th>Date</th>
            <th>Reference</th>
            <th>Description</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
         </thead>
         <tbody>
            @foreach ($invoices as $invoice)
               <tr>
                  <td>{!! date('d/m/Y',strtotime($invoice->created_at)) !!}</td>
                  <td>{!! $invoice->prefix !!}{!! $invoice->invoice_number !!}</td>
                  <td>Invoice {!! $invoice->description !!}</td>
                  <td>
                     @if ($invoice->transaction_type == "Debit")
                        ksh {!! number_format($invoice->total) !!}
                     @else
                        0
                     @endif
                  </td>
                  <td>
                     @if ($invoice->transaction_type == "Credit")
                        ksh {!! number_format($invoice->total) !!}
                     @else
                        0
                     @endif
                  </td>
                  <td>
                     <b>ksh {!! number_format($invoice->total) !!}</b></br>
                  </td>
               </tr>
               @if ($invoice->paid != "")
                  @foreach (Finance::all_invoice_payments($invoice->id) as $payments)
                     <tr class="table-active">
                        <td>{!! date('d/m/Y',strtotime($payments->created_at)) !!}</td>
                        <td>{!! $payments->reference_number !!}</td>
                        <td>Customer payment</td>
                        <td>ksh 0</td>
                        <td>ksh {!! number_format($payments->amount)!!}</td>
                        <b><td>ksh {!! number_format($payments->balance) !!}</td></b>
                     </tr>
                  @endforeach
               @endif
               @if($invoice->credited == 'Yes')
               @foreach(Finance::invoice_creditnote($invoice->id) as $credit)
                  <tr class="table-primary">
                     <td>{!! date('d/m/Y',strtotime($credit->creditnoteinvoicedate)) !!}</td>
                     <td>{!! $creditSettings->prefix !!}00{!! $credit->creditnote_number !!}</td>
                     <td>Credit Note</td>
                     <td>ksh {!! number_format($credit->credited_amount)!!}</td>
                     <td>ksh 0</td>
                     <b><td>ksh {!! number_format($credit->invoice_balance) !!}</td></b>
                  </tr>
               @endforeach
               @endif
            @endforeach
         </tbody>
      </table>
   </div>
</div>
