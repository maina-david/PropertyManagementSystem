@extends('layouts.app')
{{-- page header --}}
@section('title','Leave Calendar')
@section('stylesheet')
    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="{!! asset('asset/plugins/fullcalendar/fullcalendar.print.css') !!}" rel="stylesheet" media='print' />
	<link href="{!! asset('asset/plugins/fullcalendar/fullcalendar.min.css') !!}" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL STYLE ================== -->
@endsection
@section('sidebar')
@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content') 
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item active">Calendar</li>
      </ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Calendar</h1>
		@include('partials._messages')
      <!-- begin widget-list -->
      <div class="row">
         <div class="vertical-box">
            <!-- begin event-list -->
            {{-- <div class="vertical-box-column p-r-30 d-none d-lg-table-cell" style="width: 215px">
               <div id="external-events" class="fc-event-list">
                  <h5 class="m-t-0 m-b-15">Draggable Events</h5>
                  <div class="fc-event" data-color="#00acac">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-success"></i></div>
                     Meeting with Client
                  </div>
                  <div class="fc-event" data-color="#348fe2">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-primary"></i></div>
                     IOS App Development
                  </div>
                  <div class="fc-event" data-color="#f59c1a">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-warning"></i></div>
                     Group Discussion
                  </div>
                  <div class="fc-event" data-color="#ff5b57">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-danger"></i></div>
                     New System Briefing
                  </div>
                  <div class="fc-event">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-inverse"></i></div>
                     Brainstorming
                  </div>
                  <hr class="bg-grey-lighter m-b-15" />
                  <h5 class="m-t-0 m-b-15">Other Events</h5>
                  <div class="fc-event" data-color="#b6c2c9">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div>
                     Other Event 1
                  </div>
                  <div class="fc-event" data-color="#b6c2c9">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div>
                     Other Event 2
                  </div>
                  <div class="fc-event" data-color="#b6c2c9">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div>
                     Other Event 3
                  </div>
                  <div class="fc-event" data-color="#b6c2c9">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div>
                     Other Event 4
                  </div>
                  <div class="fc-event" data-color="#b6c2c9">
                     <div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div>
                     Other Event 5
                  </div>
               </div>
            </div> --}}
            <!-- end event-list -->
            <!-- begin calendar -->
            <div id="calendar" class="vertical-box-column calendar"></div>
            <!-- end calendar -->
         </div>
         <!-- end vertical-box -->
      </div>
	</div>
@endsection
@section('scripts')
   <!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{!! asset('assets/plugins/fullcalendar/lib/moment.min.js') !!}"></script>
	<script src="{!! asset('assets/plugins/fullcalendar/fullcalendar.min.js') !!}"></script>
	<script src="{!! asset('assets/js/demo/calendar.demo.min.js') !!}"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
			Calendar.init();
		});
	</script>
@endsection
