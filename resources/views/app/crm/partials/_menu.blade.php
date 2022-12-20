<div id="sidebar" class="sidebar">
   @php  $module = 'Customer relationship management' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="has-sub {!! Nav::isRoute('crm.dashboard') !!}">
            <a href="{!! route('crm.dashboard') !!}">
               <i class="fa fa-th-large"></i>
               <span>Dashboard</span>
            </a>
         </li>
         <li class="has-sub {{ Nav::isResource('customer') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-users"></i>
               <span>Customer</span>
            </a>
            <ul class="sub-menu">
               <li><a href="{!! route('crm.customers.index') !!}">Customer List</a></li>
               <li><a href="{!! route('crm.customers.create') !!}">Add Customer</a></li>
               <li class="{!! Nav::isRoute('crm.customers.groups.index') !!} {!! Nav::isRoute('crm.customers.groups.edit') !!}">
               <a href="{!! route('crm.customers.groups.index') !!}">Customer category</a>
               </li>
            </ul>
         </li>
         <li class="has-sub {{ Nav::isRoute('crm.leads.create') }} {{ Nav::isRoute('crm.leads.index') }} {!! Nav::isRoute('crm.leads.status') !!} {!! Nav::isRoute('crm.leads.sources') !!}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-phone-volume"></i>
               <span>Leads</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('crm.leads.index') }}"><a href="{!! route('crm.leads.index') !!}">Leads List</a></li>
               <li class="{{ Nav::isRoute('crm.leads.create') }}"><a href="{!! route('crm.leads.create') !!}">Add Lead</a></li>
               <li class="{!! Nav::isRoute('crm.leads.status') !!}"><a href="{!! route('crm.leads.status') !!}">Lead Status</a></li>
               <li class="{!! Nav::isRoute('crm.leads.sources') !!}"><a href="{!! route('crm.leads.sources') !!}">Lead Sources</a></li>
            </ul>
         </li>
         @if(Wingu::business()->id == 2)
            <li class="has-sub {!! Nav::isResource('deals') !!} {{ Nav::isResource('pipeline') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-bullseye"></i>
                  <span>Deals</span>
               </a>
               <ul class="sub-menu">
                  <li class="{!! Nav::isRoute('crm.deals.index') !!}"><a href="{!! route('crm.deals.index') !!}">All Deals</a></li>
                  <li class="{!! Nav::isRoute('crm.deals.create') !!}"><a href="{!! route('crm.deals.create') !!}">Add deals</a></li>
                  <li class="{!! Nav::isRoute('crm.pipeline.index') !!} {{ Nav::isResource('pipeline') }}"><a href="{!! route('crm.pipeline.index') !!}">Pipeline</a></li>
               </ul>
            </li>
         @endif
         {{-- <li class="has-sub {{ Nav::isResource('mail') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-calendar-edit"></i>
               <span>Appointments</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub {{ Nav::isResource('mail') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-phone-office"></i>
               <span>Call Logs</span>
            </a>
         </li> --}}
         {{-- <li class="has-sub {!! Nav::isRoute('crm.dashboard') !!}">
            <a href="{!! route('crm.dashboard') !!}">
               <i class="fal fa-calendar-alt"></i>
               <span>Calendar</span>
            </a>
         </li> --}}
         @if(Wingu::business()->id == 2)
            <li class="has-sub {{ Nav::isResource('social') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-share-alt"></i>
                  <span>Social</span>
               </a>
               <ul class="sub-menu">
                  <li class="{{ Nav::isRoute('crm.social.dashboard') }}">
                     <a href="{!! route('crm.social.dashboard') !!}">
                        Dashboard
                     </a>
                  </li>
                  <li class="has-sub {{ Nav::isResource('post') }}">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Posts
                     </a>
                     <ul class="sub-menu">
                        <li><a href="{!! route('crm.social.post.index') !!}">All Posts</a></li>
                        <li><a href="{!! route('crm.social.post.create') !!}">Add Post</a></li>
                        <li><a href="#">Drafted Post</a></li>
                        <li><a href="#">Schedules</a></li>
                     </ul>
                  </li>
                  <li class="has-sub {{ Nav::isResource('account') }}">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Account
                     </a>
                     <ul class="sub-menu">
                        <li><a href="#">All Accounts</a></li>
                        <li><a href="#">Add Account</a></li>
                     </ul>
                  </li>
                  <li class="has-sub {{ Nav::isResource('account') }}">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Feeds
                     </a>
                     <ul class="sub-menu">
                        <li><a href="#">Twitter Feeds</a></li>
                        <li><a href="#">Instagram Feeds</a></li>
                        <li><a href="#">Facebook Feeds</a></li>
                     </ul>
                  </li>
                  <li class="has-sub {{ Nav::isResource('account') }}">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Queues
                     </a>
                     <ul class="sub-menu">
                        <li><a href="#">All Queues</a></li>
                        <li><a href="#">Add Queues</a></li>
                     </ul>
                  </li>
                  <li class="has-sub {{ Nav::isResource('account') }}">
                     <a href="javascript:;">
                        Calendar
                     </a>
                  </li>
               </ul>
            </li>
         @endif
         {{-- <li class="has-sub {{ Nav::isResource('mail') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-paper-plane"></i>
               <span>Mail</span>
            </a>
            <ul class="sub-menu">
               <li><a href="{!! route('crm.mail.sent') !!}">Sent</a></li>
               <li><a href="{!! route('crm.mail.compose') !!}">Compose</a></li>
            </ul>
         </li> --}}
         {{-- <li class="has-sub {{ Nav::isResource('sms') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fas fa-sms"></i>
               <span>SMS</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isResource('sms') }}"><a href="{!! route('crm.sms.sent') !!}">Sent</a></li>
               <li><a href="#">SMS Templates</a></li>
               <li><a href="{{ Nav::isResource('telephony') }}">Settings</a></li>
            </ul>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fas fa-phone"></i>
               <span>Telephony</span>
            </a>
            <ul class="sub-menu">
               <li><a href="#">Top History</a></li>
               <li><a href="#">Top up</a></li>
            </ul>
         </li> --}}

         {{-- <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fas fa-headset"></i>
               <span>Support</span>
            </a>
            <ul class="sub-menu">
               <li><a href="#">All Tickets</a></li>
               <li><a href="#">New Ticket</a></li>
            </ul>
         </li> --}}
         <li class="has-sub {!! Nav::isResource('reports') !!}">
            <a href="{!! route('crm.reports') !!}">
               <i class="fas fa-chart-pie"></i>
               <span>Reports</span>
            </a>
         </li>
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
