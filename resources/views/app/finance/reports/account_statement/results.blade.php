@extends('layouts.app')
{{-- page header --}}
@section('title','Statement Of Account Results')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <a href="{!! route('finance.report.account.statement.export.print',[$clientID,$from,$to,$transaction]) !!}" target="_blank" class="btn btn-pink"><i class="fas fa-print"></i> Export for Print</a>
         <a href="{!! route('finance.report.account.statement.export.pdf',[$clientID,$from,$to,$transaction]) !!}" class="btn btn-pink ml-2"><i class="fas fa-file-pdf"></i> Export for PDF</a>
         <a href="{!! route('finance.report.account.statement.export.excel',[$clientID,$from,$to,$transaction]) !!}" class="btn btn-pink ml-2"><i class="fas fa-file-excel"></i> Export to Excel</a>
         <a href="#" class="btn btn-pink ml-2"><i class="fas fa-envelope-open-text"></i> Email Client</a>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Statement Of Account Results</h1>
      <!-- end page-header -->
      @include('partials._messages')
      <div class="col-md-12">
         <h4>Customer : {!! $client->customer_name !!} <br>Period : {!! date('d F, Y', strtotime($from)) !!} - {!! date('d F, Y', strtotime($to)) !!}</h4>

         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">Results</h4>
            </div>
            <div class="panel-body">
               <table class="table table-bordered">
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
                           <td>{!! Finance::invoice_settings()->prefix !!}{!! $invoice->invoice_number !!}</td>
                           <td>Invoice {!! $invoice->description !!}</td>
                           <td>
                              {!! $currency->code !!} {!! number_format($invoice->total) !!}
                           </td>
                           <td>
                              0
                           </td>
                           <td>
                              <b>{!! $currency->code !!} {!! number_format($invoice->total) !!}</b></br>
                           </td>
                        </tr>
                        @foreach(Finance::flow_per_invoice($invoice->id) as $flow)
                           @if($flow->section == 'Payment')
                              @foreach(Finance::flow_per_payment($invoice->id) as $payment)
                                 <tr class="table-primary">
                                    <td>{!! date('d/m/Y',strtotime($payment->payment_date)) !!}</td>
                                    <td>{!! $payment->reference_number !!}</td>
                                    <td>Customer payment</td>
                                    <td>{!! $currency->code !!} 0</td>
                                    <td>{!! $currency->code !!} {!! number_format($payment->amount)!!}</td>
                                    <td><b>{!! $currency->code !!} {!! number_format($payment->balance) !!}</b></td>
                                 </tr>
                              @endforeach
                           @endif
                           @if($flow->section == 'Credit')
                              @foreach(Finance::flow_per_credit($invoice->id) as $credit)
                                 <tr class="table-active">
                                    <td>{!! date('d/m/Y',strtotime($credit->credit_date)) !!}</td>
                                    <td>{!! $creditSettings->prefix !!}{!! $credit->creditnote_number !!}</td>
                                    <td>Credit Note</td>                             
                                    <td>{!! $currency->code !!} 0</td>
                                    <td>{!! $currency->code !!} {!! number_format($credit->credited_amount)!!}</td>
                                    <td><b>{!! $currency->code !!} {!! number_format($credit->invoice_balance) !!}</b></td>
                                 </tr>
                              @endforeach
                           @endif
                        @endforeach
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
@endsection