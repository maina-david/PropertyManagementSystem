<div id="sidebar" class="sidebar">
   @php  $module = 'Human Resource' @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         @permission('create-employee')
            <li class="has-sub {{ Nav::isRoute('hrm.dashboard') }}">
               <a href="{!! route('hrm.dashboard') !!}">
                  <i class="fa fa-th-large"></i>
                  <span>Dashboard</span>
               </a>
            </li>
         @endpermission
         @permission('read-employee')
            <li class="has-sub {{ Nav::isResource('employee') }}">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-users"></i>
                  <span>Employee</span>
               </a>
               <ul class="sub-menu">
                  <li><a href="{!! route('hrm.employee.index') !!}">All Employee</a></li>
                  @permission('create-employee')
                     <li><a href="{!! route('hrm.employee.create') !!}">Add Employee</a></li>
                  @endpermission
               </ul>
            </li>
         @endpermission
         <li class="has-sub {{ Nav::isResource('leave') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-calendar-day"></i>
               <span>Leave Request</span>
            </a>
            <ul class="sub-menu">
               <li class="{!! Nav::isRoute('hrm.leave.apply') !!} {!! Nav::isRoute('hrm.leave.apply.edit') !!}"><a href="{!! route('hrm.leave.apply') !!}">Apply</a></li>
               <li class="{!! Nav::isRoute('hrm.leave.apply.index') !!}"><a href="{!! route('hrm.leave.apply.index') !!}">My Leave List</a></li>
               @permission('read-leave')
                  <li class="{{ Nav::isRoute('hrm.leave.index') }}"><a href="{!! route('hrm.leave.index') !!}">All Requests</a></li>
                  <li class="{{ Nav::isRoute('hrm.leave.create') }} {!! Nav::isRoute('hrm.leave.edit') !!}"><a href="{!! route('hrm.leave.create') !!}">Assign Leave</a></li>
                  {{-- <li class="{{ Nav::isRoute('hrm.leave.balance') }}"><a href="{!! route('hrm.leave.balance') !!}">Balance</a></li> --}}
                  <li class="{{ Nav::isRoute('hrm.leave.calendar') }}"><a href="{!! route('hrm.leave.calendar') !!}">Leave Calendar</a></li>
                  <li class="{{ Nav::isRoute('hrm.leave.settings.type') }}"><a href="{!! route('hrm.leave.settings.type') !!}">Leave Types</a></li>
               @endpermission
            </ul>
         </li>
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-calendar"></i>
               <span>Calender</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">Leave</a></li>
               <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">Holiday</a></li>
               <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">Travel</a></li>
               <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">Birthday</a></li>
            </ul>
         </li> --}}
         <li class="has-sub {{ Nav::isResource('payroll') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-money-check-alt"></i>
               <span>Payroll</span>
            </a>
            <ul class="sub-menu">
               @permission('create-payroll')
                  <li class="{{ Nav::isRoute('hrm.payroll.people') }} {!! Nav::isRoute('hrm.payroll.people') !!}"><a href="{!! route('hrm.payroll.people') !!}">People</a></li>
                  <li class="{!! Nav::isRoute('hrm.payroll.index') !!}"><a href="{!! route('hrm.payroll.index') !!}">Payrolls</a></li>
                  <li class="{{ Nav::isRoute('hrm.payroll.process') }}"><a href="{!! route('hrm.payroll.process') !!}">Run payroll</a></li>
                  {{-- <li class="#"><a href="#">Advance Salary Requests</a></li> --}}
               @endpermission
               {{-- <li class="#"><a href="#">My Advance Salary </a></li>
               <li class="#"><a href="#">Request Advance </a></li> --}}
            </ul>
         </li>
         {{-- @if(Wingu::check_plan_function(123,Wingu::business()->plan,2) == 1)
            <li class="has-sub">
               <a href="#">
                  <i class="fas fa-user-plus"></i>
                  <span>Hiring</span>
               </a>
            </li>
         @endif --}}

         {{-- @if(Wingu::check_plan_function(124,Wingu::business()->plan,2) == 1)
            <li class="has-sub">
               <a href="#">
                  <i class="fab fa-leanpub"></i>
                  <span>Training</span>
               </a>
            </li>
         @endif --}}
         {{-- @if(Wingu::check_plan_function(125,Wingu::business()->plan,2) == 1)
            <li class="has-sub">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-folder"></i>
                  <span>Documents</span>
               </a>
               <ul class="sub-menu">
                  <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">All Documents</a></li>
                  <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">My Documents</a></li>
               </ul>
            </li>
         @endif --}}
         <li class="has-sub {{ Nav::isResource('organization') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-sitemap"></i>
               <span>Organization</span>
            </a>
            <ul class="sub-menu">
               <li class="has-sub {{ Nav::isResource('positions') }}">
                  <a href="javascript:;">
                     <b class="caret"></b>
                     Positions
                  </a>
                  <ul class="sub-menu">
                     <li><a href="{!! route('hrm.positions') !!}">All Positions</a></li>
                     <li><a href="{!! route('hrm.positions') !!}">Add Positions</a></li>
                  </ul>
               </li>
               @permission('read-departments')
                  <li class="has-sub {{ Nav::isResource('departments') }}">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Department
                     </a>
                     <ul class="sub-menu">
                        <li class="{{ Nav::isRoute('hrm.departments') }}"><a href="{!! route('hrm.departments') !!}">All Department</a></li>
                        <li class="{{ Nav::isRoute('hrm.departments.create') }}"><a href="{!! route('hrm.departments.create') !!}">Add Department</a></li>
                     </ul>
                  </li>
               @endpermission
               @permission('read-branches')
                  <li class="has-sub {{ Nav::isResource('branches') }}">
                     <a href="javascript:;">
                        <b class="caret"></b>
                        Branches
                     </a>
                     <ul class="sub-menu">
                        <li><a href="{!! route('hrm.branches') !!}">All Branches</a></li>
                        <li><a href="{!! route('hrm.branches.create') !!}">Add Branches</a></li>
                     </ul>
                  </li>
               @endpermission
            </ul>
         </li>
         {{-- @if(Wingu::check_plan_function(66,Wingu::business()->plan,2) == 1)
            <li class="has-sub">
               <a href="#">
                  <i class="fal fa-bullhorn"></i>
                  <span>Announcements</span>
               </a>
            </li>
         @endif
         @if(Wingu::check_plan_function(67,Wingu::business()->plan,2) == 1)
            <li class="has-sub">
               <a href="#">
                  <i class="fal fa-door-open"></i>
                  <span>Exit Details</span>
               </a>
            </li>
         @endif --}}
         <li class="has-sub {{ Nav::isResource('travel') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-plane"></i>
               <span>Travel</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('hrm.travel.index') }}"><a href="{!! route('hrm.travel.index') !!}">Travels</a></li>
               <li class="{{ Nav::isRoute('hrm.travel.expenses') }}"><a href="{!! route('hrm.travel.expenses') !!}">Travel Expenses</a></li>
               @if(Auth::user()->employeeID != "")
                  <li class="{{ Nav::isRoute('hrm.travel.my') }}"><a href="{!! route('hrm.travel.my') !!}">My Travels</a></li>
               @endif
            </ul>
         </li>
         {{-- @if(Wingu::check_plan_function(127,Wingu::business()->plan,2) == 1)
            <li class="has-sub">
               <a href="javascript:;">
                  <b class="caret"></b>
                  <i class="fal fa-hand-holding-usd"></i>
                  <span>Compensation</span>
               </a>
               <ul class="sub-menu">
                  <li class="#"><a href="#">Assets</a></li>
                  <li class="#"><a href="#">Benefits</a></li>
                  <li class="#"><a href="#">My Assets</a></li>
                  <li class="#"><a href="#">My Benefits</a></li>
               </ul>
            </li>
         @endif --}}
         {{-- <li class="has-sub">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-clipboard-list-check"></i>
               <span>Tasks</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">My Tasks</a></li>
               <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">All Tasks</a></li>
               <li class="{{ Nav::isRoute('hrm.jobTitle') }}"><a href="#">Allocate Tasks</a></li>
            </ul>
         </li> --}}
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fal fa-user-circle"></i>
               <span>My profile</span>
            </a>
         </li> --}}
         {{-- @if(Wingu::check_plan_function(68,Wingu::business()->plan,2) == 1)
            <li class="has-sub">
               <a href="#">
                  <i class="fas fa-info-circle"></i>
                  <span>Company policy</span>
               </a>
            </li>
         @endif --}}
         {{-- <li class="has-sub">
            <a href="#">
               <i class="fas fa-chart-pie"></i>
               <span>Report</span>
            </a>
         </li> --}}
         <li class="has-sub {{ Nav::isResource('settings') }}">
            <a href="javascript:;">
               <b class="caret"></b>
               <i class="fal fa-cogs"></i>
               <span>Settings</span>
            </a>
            <ul class="sub-menu">
               <li class="{{ Nav::isRoute('hrm.payroll.settings.deduction') }}"><a href="{!! route('hrm.payroll.settings.deduction') !!}">Payroll Deductions</a></li>
               <li class="{{ Nav::isRoute('hrm.payroll.settings.approval') }}"><a href="{!! route('hrm.payroll.settings.approval') !!}"> Approver setting</a></li>
            </ul>
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
