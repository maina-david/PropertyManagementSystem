<div id="sidebar" class="sidebar">
   @php  
      $module = 'Account Settings';
      $property = Wingu::get_account_module_details(1);
   @endphp
   <!-- begin sidebar scrollbar -->
   <div data-scrollbar="true" data-height="100%">
      <!-- begin sidebar user -->
      @include('partials._nav-profile')
      <!-- end sidebar user -->
      <!-- begin sidebar nav -->
      <ul class="nav">
         <li class="nav-header">Navigation</li>
         <li class="{{ Nav::isResource('businessprofile') }}"> <a href="{!! route('settings.business.index') !!}"><i class="fal fa-globe"></i> Business Profile</a></li>
         {{-- <li><a href="#">Localization</a></li>                --}}
         {{-- <li><a href="#">Notifications</a></li> --}}
         {{-- <li><a href="#">Account Management</a></li> --}}
         {{-- <li><a href="#">Email Settings</a></li> --}}
         {{-- <li><a href="#">Templates & Reminders</a></li> --}}
         {{-- <li><a href="#">API Tokens</a></li> --}}
         @if(Wingu::count_payed_modules() > 0)
            <li class="{{ Nav::isResource('users') }}"><a href="{!! route('settings.users.index') !!}"><i class="fal fa-users-cog"></i> User Management</a></li>
            <li class="{{ Nav::isResource('roles') }}"><a href="{!! route('settings.roles.index') !!}"><i class="fal fa-shield-alt"></i> Roles & Permissions</a></li>  
         @endif       
         <li class="{{ Nav::isResource('integrations') }}"><a href="{!! route('settings.integrations.payments') !!}"><i class="fal fa-credit-card"></i> Payment Integration</a></li>
         {{-- <li class="{{ Nav::isResource('telephony') }}"><a href="{!! route('settings.integrations.telephony') !!}"><i class="fal fa-phone-volume"></i> Telephony</a></li> --}}
         <li class="{{ Nav::isRoute('settings.applications') }}"><a href="{!! route('settings.applications') !!}"><i class="fal fa-gem"></i> My Applications</a></li>
         {{-- <li class=""><a href="#"><i class="fal fa-usd-circle"></i> Billing</a></li> --}}
         <!-- begin sidebar minify button -->
         <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
         <!-- end sidebar minify button -->
      </ul>
      <!-- end sidebar nav -->
   </div>
   <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
