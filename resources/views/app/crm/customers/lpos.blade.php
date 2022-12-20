<div class="card">
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
            @foreach ($lpos as $crt => $v)
               <tr role="row" class="odd">
                  <td>{{ $crt+1 }}</td>
                  <td>
                     <b>{!! Finance::lpo()->prefix !!}00{!! $v->lpo_number !!}</b>
                  </td>
                  </td>
                  <td class="text-uppercase font-weight-bold">
                     {!! $v->reference_number !!}
                  </td>
                  <td>{!! number_format($v->total) !!} {!! Finance::currency($v->currencyID)->symbol !!}</td>
                  <td><span class="badge {!! Wingu::status($v->statusID)->name !!}">{!! ucfirst(Wingu::status($v->statusID)->name) !!}</span></td>
                  <td>
                     {!! date('F j, Y',strtotime($v->created_at)) !!}
                  </td>
                  <td>
                     <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action </button>
                        <ul class="dropdown-menu">
                           <li><a href="{{ route('finance.lpo.show', $v->id) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                           <li><a href="{!! route('finance.lpo.edit', $v->id) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                           <li><a href="{!! route('finance.lpo.delete', $v->id) !!}"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                        </ul>
                     </div>
                  </td>
               </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
