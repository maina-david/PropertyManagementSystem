<div class="card mt-3">
   <div class="card-header"><i class="fal fa-file-alt"></i> Credit notes</div>
   <div class="card-body">
      <table id="data-table-default" class="table table-striped table-bordered table-hover">
         <thead>
            <tr>
               <th width="1%">#</th>
               <th>Number</th>
               <th>Reference Number</th>
               <th>Amount</th>
               <th>Status</th>
               <th>Date</th>
               <th width="10%">Action</th>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th width="1%">#</th>
               <th>Number</th>
               <th>Reference Number</th>
               <th>Amount</th>
               <th>Status</th>
               <th>Date</th>
               <th width="10%">Action</th>
            </tr>
         </tfoot>
         <tbody>
            @foreach ($creditnotes as $crt => $v)
               <tr role="row" class="odd">
                  <td>{{ $crt+1 }}</td>
                  <td>
                     <b>{!! Finance::creditnote()->prefix !!}{!! $v->creditnote_number !!}</b>
                  </td>
                  <td class="text-uppercase font-weight-bold">
                     {!! $v->reference_number !!}
                  </td>
                  <td>{!! $client->code !!} {!! number_format($v->total) !!}</td>
                  <td><span class="badge {!! Limitless::status($v->statusID)->name !!}">{!! ucfirst(Limitless::status($v->statusID)->name) !!}</span></td>
                  <td>
                     {!! date('F j, Y',strtotime($v->created_at)) !!}
                  </td>
                  <td>
                     <a href="{{ route('finance.creditnote.show', $v->id) }}" class="btn btn-pink btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
