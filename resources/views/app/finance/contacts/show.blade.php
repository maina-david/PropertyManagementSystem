<div class="contact-dashboard mt-3">
   <div class="row">
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-blue">
            <div class="stats-icon"><i class="fal fa-money-check-alt fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Outstanding Receivables</h4>
               <p>{!! $client->symbol !!}{!! number_format($outstanding) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-red">
            <div class="stats-icon"><i class="fal fa-file-invoice fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Unused Credits</h4>
               <p>{!! $client->symbol !!}{!! number_format($unusedCredits) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-green">
            <div class="stats-icon"><i class="fal fa-usd-circle fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Total Income</h4>
               <p>{!! $client->symbol !!}{!! number_format($totalIncome) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-yellow">
            <div class="stats-icon"><i class="fal fa-tasks fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Projects</h4>
               <p>{!! number_format($projectCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-pink">
            <div class="stats-icon"><i class="fal fa-file-invoice-dollar fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Invoices</h4>
               <p>{!! number_format($invoiceCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-purple">
            <div class="stats-icon"><i class="fal fa-file-alt fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Quotes</h4>
               <p>{!! number_format($quotesCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-black">
            <div class="stats-icon"><i class="fal fa-credit-card fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Payments Made</h4>
               <p>{!! number_format($paymentsCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-orange">
            <div class="stats-icon"><i class="fal fa-paper-plane fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Mails</h4>
               <p>{!! number_format($mailCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-indigo">
            <div class="stats-icon"><i class="fal fa-sms fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Sms</h4>
               <p>{!! number_format($smsCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-aqua">
            <div class="stats-icon"><i class="fal fa-check-square fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Tasks</h4>
               <p>{!! number_format($taskCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-teal">
            <div class="stats-icon"><i class="fal fa-sync-alt fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Subscriptions</h4>
               <p>{!! number_format($subscriptionsCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-grey">
            <div class="stats-icon"><i class="fal fa-warehouse-alt fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Assets</h4>
               <p>{!! number_format($assetsCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-red-darker">
            <div class="stats-icon"><i class="fal fa-phone-office fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Call logs</h4>
               <p>{!! number_format($quotesCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-purple-darker">
            <div class="stats-icon"><i class="fal fa-calendar-alt fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Meeting</h4>
               <p>{!! number_format($eventsCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-purple">
            <div class="stats-icon"><i class="fal fa-sticky-note fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Notes</h4>
               <p>{!! number_format($countNotes) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-yellow-darker">
            <div class="stats-icon"><i class="fal fa-folder fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Documents</h4>
               <p>{!! number_format($documentsCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-pink-darker">
            <div class="stats-icon"><i class="fal fa-funnel-dollar fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Sales orders</h4>
               <p>{!! number_format($salesOrderCount) !!}</p>
            </div>
         </div>
      </div>
      <div class="col-xl-4 col-md-6">
         <div class="widget widget-stats bg-aqua-darker">
            <div class="stats-icon"><i class="fal fa-comments fa-2x"></i></div>
            <div class="stats-info">
               <h4 class="text-white">Comments</h4>
               <p>{!! number_format($commentCount) !!}</p>
            </div>
         </div>
      </div>
   </div>
</div>