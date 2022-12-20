<div class="row mt-3">
   <div class="panel panel-default">
      <div class="panel-heading">
         <h4 class="panel-title">All Plans</h4>
      </div>
      <div class="panel-body">
         <table id="data-table-default" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th width="1%">#</th>
                  <th> Created On</th>
                  <th> Activated On</th>
                  <th> Subscription#</th>
                  <th> Customer Name</th>
                  <th> Plan Name</th>
                  <th> Status</th>
                  <th> Amount</th>
                  <th> Last Billed On</th>
                  <th> Next Billing On</th>
                  <th width="9%">Action</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($subscriptions as $subscription)
                  <tr>
                     <td>{!! $count++ !!}</td>
                     <td>{!! date('d M, Y', strtotime($subscription->created_at)) !!}</td>
                     <td>
                        @if($subscription->starts_on != ""){!! date('d M, Y', strtotime($subscription->starts_on)) !!}@endif
                     </td>
                     <td>
                        <b>{!! $subscription->prefix !!}{!! $subscription->subscription_number !!}</b>
                     </td>
                     <td>{!! $subscription->customer_name !!}</td>
                     <td>{!! $subscription->product_name !!}</td>
                     <td>
                        @if($subscription->status != "")
                           <span class="badge {!! $subscription->statusName !!}">{!! $subscription->statusName !!}</span>
                        @endif
                     </td>
                     <td>
                        <b>{!! $subscription->code !!} {!! number_format($subscription->amount) !!}</b>
                     </td>
                     <td>
                        @if($subscription->last_billing)
                           {!! date('d M, Y', strtotime($subscription->last_billing)) !!}
                        @endif
                     </td>
                     <td>
                        @if($subscription->next_billing)
                           {!! date('d M, Y', strtotime($subscription->next_billing)) !!}
                        @endif
                     </td>
                     <td>
                        @permission('read-subscription')
                           <a href="{!! route('subscriptions.show',$subscription->subscriptionID) !!}" target="_blank" class="btn btn-sm btn-pink"><i class="fal fa-eye"></i></a>
                        @endpermission
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>