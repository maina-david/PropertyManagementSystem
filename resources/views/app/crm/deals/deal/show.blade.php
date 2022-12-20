@extends('layouts.app')
{{-- page header --}}
@section('title','Deal details')
@section('stylesheet')
   <style>
      .progressbar {
      counter-reset: step;
      }
      .progressbar li {
            list-style-type: none;
            width: 13%;
            float: left;
            font-size: 12px;
            position: relative;
            text-align: center;
            text-transform: uppercase;
            color: #7d7d7d;
      }
      .progressbar li:before {
            font-family: 'Font';
            width: 30px;
            height: 30px;
            content: counter(step);
            counter-increment: step;
            line-height: 30px;
            border: 2px solid #7d7d7d;
            display: block;
            text-align: center;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
      }
      .progressbar li:after {
            width: 100%;
            height: 2px;
            content: '';
            position: absolute;
            background-color: #7d7d7d;
            top: 15px;
            left: -50%;
            z-index: -1;
      }
      .progressbar li:first-child:after {
            content: none;
      }
      .progressbar li.active {
            color: green; 
      }
      .progressbar li.active:before {
            border-color: #55b776;
      }
      .progressbar li.active + li:after {
            background-color: #55b776;
      }   
   </style>    
@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         {{-- <a href="" class="btn btn-default btn-sm mr-2">Won</a> --}}
         {{-- <a href="" class="btn btn-sm btn-default mr-2">Lost</a> --}}
         <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true"> <i class="fal fa-ellipsis-h"></i></button>
            <ul class="dropdown-menu mr-5">
               <li><a href="{!! route('crm.deals.edit',$deal->dealID) !!}"><i class="fad fa-edit"></i> Edit</a></li>   
               <li><a href="#{!! route('crm.deals.delete',$deal->dealID) !!}" class="delete"><i class="fad fa-trash"></i> Delete</a></li>                           
            </ul>
         </div>   
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-bullseye"></i> {!! $deal->title !!}</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-12 mb-5">
            <ul class="progressbar">
               @foreach ($stages as $stage)
                  <li class="@if($stage->id == $deal->stage) active @endif">{!! $stage->title !!}</li>
               @endforeach
            </ul>
         </div>
      </div>  
      <div class="row">
         <div class="col-md-3">
            <div class="panel panel-default">
               <div class="panel-heading"><i class="fal fa-info-circle"></i> <b>About Deal</b></div>
               <div class="panel-body">
                  <p>
                     <b>Deal  :</b> <span class="text-primary">Age {!! number_format(Helper::date_difference($deal->close_date,$deal->create_date)) !!} Day(s)</span><br>
                     <b>Closure Date :</b> <span class="text-primary">@if($deal->close_date != ""){!! date('F jS Y', strtotime($deal->close_date)) !!}@endif</span><br>
                     <b>Assign to :</b> <span class="text-primary">@if(Hr::check_employee($deal->owner) != 0){!! Hr::employee($deal->owner)->names !!}@endif</span><br>
                     <b>Pipeline :</b> <span class="text-primary">@if(Crm::check_pipeline($deal->pipeline) != 0){!! Crm::pipeline($deal->pipeline)->title !!}@endif</span> <br>
                     <b>Stage :</b> <span class="text-primary">@if(Crm::check_pipeline_stage($deal->stage) != 0)  
                        {!! Crm::pipeline_stage($deal->stage)->title !!}
                     @endif</span> <br>
                     <b>Estimated worth :</b> <span class="text-primary">{!! $deal->code !!} {!! number_format($deal->value) !!}</span> <br>
                     <b>Created At :</b> <span class="text-primary">{!! date('F jS Y', strtotime($deal->create_date)) !!}</span>
                  </p>
               </div>
            </div>
            {{-- <div class="panel panel-default">
               <div class="panel-heading"><i class="fad fa-link"></i> Follower</div>
               <div class="panel-body">
                  
               </div>
            </div> --}}
            {{-- <div class="panel panel-default">
               <div class="panel-heading"><i class="fad fa-building"></i> Organization</div>
               <div class="panel-body">
                  
               </div>
            </div> --}}
            {{-- <div class="panel panel-default">
               <div class="panel-heading"><i class="fad fa-users"></i> Contact Person</div>
               <div class="panel-body">
                  
               </div>
            </div> --}}
         </div>
         <div class="col-md-9">
            <ul class="nav nav-tabs">
               <li class="nav-item">
                  <a class="nav-link {!! Nav::isRoute('crm.deals.show') !!}" href="{!! route('crm.deals.show',$deal->dealID) !!}"><i class="fas fa-globe"></i> Overview</a>
               </li>               
               <li class="nav-item">
                  <a class="nav-link {!! Nav::isRoute('crm.deals.calllog.index') !!}" href="{!! route('crm.deals.calllog.index',$deal->dealID) !!}"><i class="fad fa-phone-square-alt"></i> Call logs</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link {!! Nav::isRoute('crm.deals.notes.index') !!}" href="{!! route('crm.deals.notes.index',$deal->dealID) !!}"><i class="fad fa-sticky-note"></i> Notes</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link {!! Nav::isRoute('crm.deals.task.index') !!}" href="{!! route('crm.deals.task.index',$deal->dealID) !!}"><i class="fad fa-tasks"></i> Tasks</a>
               </li>
               {{-- <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fad fa-sms"></i> Sms</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fad fa-inbox-in"></i> Email</a>
               </li> --}}
               {{-- <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fad fa-file-invoice"></i> Quotes</a>
               </li> --}}
               {{-- <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fad fa-file-invoice-dollar"></i> Invoices</a>
               </li> --}}
               {{-- <li class="nav-item">
                 <a class="nav-link" href="#"><i class="fad fa-folders"></i> Documents</a>
               </li> --}}
               <li class="nav-item">
                  <a class="nav-link {!! Nav::isRoute('crm.deals.appointments.index') !!}" href="{!! route('crm.deals.appointments.index',$deal->dealID) !!}"><i class="fad fa-calendar-check"></i> Appointments</a>
               </li>               
            </ul>
            @if(Request::is('crm/deals/'.$deal->dealID.'/show'))
               @include('app.crm.deals.deal.dashboard')
            @endif  
            @if(Request::is('crm/deals/'.$deal->dealID.'/call_log'))
               @include('app.crm.deals.deal.call_log')
            @endif            
            @if(Request::is('crm/deals/'.$deal->dealID.'/notes'))
               @include('app.crm.deals.deal.notes')
            @endif   
            @if(Request::is('crm/deals/'.$deal->dealID.'/task'))
               @include('app.crm.deals.deal.task')
            @endif
            @if(Request::is('crm/deals/'.$deal->dealID.'/appointments'))
               @include('app.crm.deals.deal.appointments')
            @endif
         </div>
      </div>    
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
