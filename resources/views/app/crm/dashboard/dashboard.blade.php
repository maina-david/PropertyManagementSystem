@extends('layouts.app')
@section('title','CRM | Dashboard')
@section('stylesheet')
@endsection
@section('sidebar')
   @include('app.crm.partials._menu')
@endsection
@section('content')
   <!-- begin #content -->
   <div id="content" class="content">
      <!-- begin row -->
      <div class="row">
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-teal">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-phone-volume"></i></div>
               <div class="stats-content">
                  <div class="stats-title">Leads</div>
                  <div class="stats-number">{!! $leads !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width: 100%;"></div>
                  </div>
                  <div class="stats-desc">Total Leads</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-purple">
               <div class="stats-icon stats-icon-lg"><i class="fas fa-bullseye"></i></div>
               <div class="stats-content">
                  <div class="stats-title">Deals</div>
                  <div class="stats-number">{!! $dealsCount !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc">Total leads</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-green">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-thumbs-up"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Deals Won</div>
                  <div class="stats-number">{!! $won !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc text-white">Total deals won this month</div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-3">
            <div class="widget widget-stats bg-gradient-red">
               <div class="stats-icon stats-icon-lg"><i class="fal fa-thumbs-down"></i></div>
               <div class="stats-content">
                  <div class="stats-title text-white">Deals Lost</div>
                  <div class="stats-number">{!! $lost !!}</div>
                  <div class="stats-progress progress">
                     <div class="progress-bar" style="width:100%;"></div>
                  </div>
                  <div class="stats-desc text-white">Total deals lost</div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  Open, Won and Lost Deals
               </div>
               <div class="card-body">
                  {!! $dealReport->container() !!}
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="card">
               <div class="card-header">
                  Upcoming Meetings
               </div>
               <div class="card-body"  style="overflow-y:scroll; overflow-x:hidden; height:445px;">
                  @foreach ($appointments as $event) 
                     <div class="col-md-12">
                        <!-- begin widget-list -->
                        <div class="widget-list widget-list-rounded mb-2">
                           <!-- begin widget-list-item -->
                           <div class="widget-list-item">
                              <div class="widget-list-content">
                                 <h4 class="widget-list-title font-weight-bold text-pink">{!! $event->event_name !!}</h4>
                                 <p class="widget-list-desc mt-1">
                                    <b>Start Date :</b> <span class="text-pink">{!! date("F m, Y", strtotime($event->start_date)) !!}</span><br>
                                    <b>Start Time :</b>  <span class="text-pink">{!! $event->start_time !!}</span><br>
                                    <b>Added :</b> <span class="text-pink">{!! Helper::get_timeago(strtotime($event->created_at)) !!}</span><br>
                                    <b>Status :</b>  <span class="text-pink">{!! $event->status !!}</span><br>
                                    @if($event->owner != "")
                                       <b>Owner :</b>  <span class="text-pink">@if(Hr::check_employee($event->owner) > 0){!! Hr::employee($event->owner)->names !!}@endif
                                    @endif   </span>
                                 </p>
                              </div>
                           </div>
                           <!-- end widget-list-item -->
                        </div>
                        <!-- end widget-list -->
                     </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end #content -->
@endsection
@section('scripts')
   <script src="{!! asset('assets/plugins/chart.js/2.7.1/Chart.min.js') !!}" charset="utf-8"></script>
   {!! $dealReport->script() !!} 
@endsection
