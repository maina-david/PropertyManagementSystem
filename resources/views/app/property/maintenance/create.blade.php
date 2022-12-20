@extends('layouts.app')
@section('title','Maintenance')
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('stylesheet')
   <link rel="stylesheet" href="{!! asset('assets/plugins/smartwizard/smart_wizard.css') !!}" />
@endsection

@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.agents') !!}">Maintenance</a></li>
         <li class="breadcrumb-item active"><a href="">Requests</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> Maintenance Request </h1>
      <div class="row">
         <form action="{!! route('property.maintenance.store') !!}" method="POST" class="form-control-with-bg col-md-12" enctype="multipart/form-data">
            <div id="wizard">         
               @csrf
               <!-- begin wizard -->
               <!-- begin wizard-step -->
               <ul>
                  <li>
                     <a href="#step-1">
                        <span class="number">1</span>
                        <span class="info">
                           Property Info
                           <small>Property unit, tenants</small>
                        </span>
                     </a>
                  </li>
                  <li>
                     <a href="#step-2">
                        <span class="number">2</span>
                        <span class="info">
                           Maintenance Issue
                           <small>Email and phone no. is required</small>
                        </span>
                     </a>
                  </li>
                  <li>
                     <a href="#step-3">
                        <span class="number">3</span>
                        <span class="info">
                           Maintenance Details
                           <small>Enter your username and password</small>
                        </span>
                     </a>
                  </li>
                  <li>
                     <a href="#step-4">
                        <span class="number">4</span>
                        <span class="info">
                           Supplier Feed back
                           <small>N/A</small>
                        </span>
                     </a>
                  </li>
                  <li>
                     <a href="#step-4">
                        <span class="number">5</span>
                        <span class="info">
                           Maintenance Report
                           <small>N/A</small>
                        </span>
                     </a>
                  </li>
               </ul>
               <!-- end wizard-step -->
               <!-- begin wizard-content -->
               <div>
                  <!-- begin step-1 -->
                  <div id="step-1">
                     <!-- begin fieldset -->
                     <fieldset>
                        <!-- begin row -->
                        <div class="row">
                           <!-- begin col-8 -->
                           <div class="col-xl-8 offset-xl-3">
                              <div class="col-lg-9 col-xl-9">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <h5>Location Information</h5>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default required">
                                          <label for="">Property</label>
                                          {!! Form::select('property',$properties, null, ['class' => 'form-control multiselect','id' => 'property_select'] ) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default">
                                          <label for="">Property Unit</label>
                                          <select class="form-control multiselect" id="units" name="unitID">
                                             <option value="">Choose unit</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default required">
                                          <label for="">Priority</label>
                                          {!! Form::select('priority',['' => 'Choose Priority','Low' => 'Low','Normal' => 'Normal','High' => 'High','Critical' => 'Critical'], null, ['class' => 'form-control multiselect'] ) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default required">
                                          <label for="">Maintainance Status</label>
                                          {!! Form::select('status',['' => 'Choose Status','Pending' => 'Pending','In Progress' => 'In Progress','Resolved'  => 'Resolved'], null, ['class' => 'form-control multiselect'] ) !!}
                                       </div>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <h5>Residents Information</h5>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default required">
                                          <label for="">Select tenants</label>
                                          <select class="form-control multiselect" id="tentants" name="tenant">

                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default required">
                                          <label for="">Available date & time</label>
                                          {!! Form::date('available_date',null, ['class' => 'form-control'] ) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" id="customRadio912" name="available_time" class="custom-control-input" value="9am - 12pm">
                                          <label class="custom-control-label" for="customRadio912">9am - 12pm</label>
                                       </div>
                                       <div class="custom-control custom-radio">
                                          <input type="radio" id="customRadio124" name="available_time" class="custom-control-input" value="12pm - 4pm">
                                          <label class="custom-control-label" for="customRadio124">12pm - 4pm</label>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="custom-control custom-radio">
                                          <input type="radio" id="customRadio48" name="available_time" class="custom-control-input" value="12pm - 4pm">
                                          <label class="custom-control-label" for="customRadio48">4pm - 8pm</label>
                                       </div>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="customRadioAuth" name="authorization_to_enter">
                                          <label class="custom-control-label" for="customRadioAuth">Authorization to enter</label>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="custom-control custom-checkbox">
                                          <input type="checkbox" class="custom-control-input" id="customRadioPetresidence" name="pet_in_residence">
                                          <label class="custom-control-label" for="customRadioPetresidence">Pet in residence</label>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div id="authorisation" style="display: none">
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" name="authorization_type[]" id="customCheckinres" value="In resident's absence">
                                             <label class="custom-control-label" for="customCheckinres">In resident's absence</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" name="authorization_type[]" value="Alarm code" id="customCheckAlarm">
                                             <label class="custom-control-label" for="customCheckAlarm">Alarm code</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div id="petinfo" style="display: none">
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" name="pet_secured" id="customCheckpetsecured" value="Yes">
                                             <label class="custom-control-label" for="customCheckpetsecured">Pet secured?</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" value="Cat" name="pet[]" id="customCheckcat">
                                             <label class="custom-control-label" for="customCheckcat">Cat</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" value="Dog" id="customCheckDog">
                                             <label class="custom-control-label" for="customCheckDog">Dog</label>
                                          </div>
                                          <div class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" value="Other" name="pet[]" id="customCheckother">
                                             <label class="custom-control-label" for="customCheckother">Other</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- end col-8 -->
                        </div>
                        <!-- end row -->
                     </fieldset>
                     <!-- end fieldset -->
                  </div>
                  <!-- end step-1 -->
                  <!-- begin step-2 -->
                  <div id="step-2">
                     <!-- begin fieldset -->
                     <fieldset>
                        <!-- begin row -->
                        <div class="row">
                           <!-- begin col-8 -->
                           <div class="col-xl-8 offset-xl-3">
                              <div class="col-lg-9 col-xl-9">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <h5>Maintenance Issues</h5>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="form-group form-group-default required">
                                          <label for="">Issue Titile</label>
                                          {!! Form::text('issue_title', null, ['class' => 'form-control', 'placeholder' => 'Enter issue title'] ) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default required">
                                          <label for="">Maintenance Category</label>
                                          {!! Form::select('category',$category, null, ['class' => 'form-control multiselect','id' => 'maintenance_category'] ) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default">
                                          <label for="">Maintenance Sub-category</label>
                                          <select class="form-control multiselect" id="category" name="sub_category">

                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="form-group required">
                                          <label for="">Issue Details</label>
                                          {!! Form::textarea('issue_details', null, ['class' => 'form-control ckeditor', 'placeholder' => 'Enter issue title'] ) !!}
                                       </div>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="info-panel"><h3 class="panel-label">Attachments</h3><p class="panel-description">Attach the files of the issue to help narrowing down the issue.</p></div>
                                    </div>
                                    <div class="col-md-12">
                                       <input type="file" name="images[]" multiple>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- end col-8 -->
                        </div>
                        <!-- end row -->
                     </fieldset>
                     <!-- end fieldset -->
                  </div>
                  <!-- end step-2 -->
                  <!-- begin step-3 -->
                  <div id="step-3">
                     <!-- begin fieldset -->
                     <fieldset>
                        <!-- begin row -->
                        <div class="row">
                           <!-- begin col-8 -->
                           <div class="col-xl-8 offset-xl-3">
                              <div class="col-lg-9 col-xl-9">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="info-panel">
                                          <h3 class="panel-label">Assignee Information</h3>
                                          <p class="panel-description">Assign yourself or select the Service Professional from the list. Connect and post the order to ServicePro Portal. Communicate, add materials, and create transactions within the order.
                                          </p>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="radio radio-css">
                                          <input type="radio" id="cssRadioSA" name="service_provider_type" value="Self assigned"/>
                                          <label for="cssRadioSA">Do it myself</label>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="radio radio-css">
                                          <input type="radio" id="cssRadioAS" name="service_provider_type" value="assigned to service provider"/>
                                          <label for="cssRadioAS">Assign to service provider</label>
                                       </div>
                                    </div>
                                    <div class="col-md-12 mt-3" id="service_provider" style="display: none">
                                       <div class="form-group form-group-default required">
                                          <label for="">Service Provider</label>
                                          {!! Form::select('service_provider',$suppliers, null, ['class' => 'form-control multiselect'] ) !!}
                                       </div>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="info-panel"><h3 class="panel-label">Dates &amp; labor</h3><p class="panel-description">Capture work and day hours for each request to keep track of labor time.</p></div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default">
                                          <label for="">Request initiated date</label>
                                          {!! Form::date('initiated_date',null,['class' => 'form-control']) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default">
                                          <label for="">Request due date</label>
                                          {!! Form::date('due_date',null,['class' => 'form-control datepicker']) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default">
                                          <label for="">Started to work date</label>
                                          {!! Form::date('started_to_work_date',null,['class' => 'form-control datepicker']) !!}
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group form-group-default">
                                          <label for="">Completed work date</label>
                                          {!! Form::date('completed_work_date',null,['class' => 'form-control datepicker']) !!}
                                       </div>
                                    </div>
                                 </div>
                                 <hr>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <center>
                                          <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Submit information</button>
                                          <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                       </center>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- end col-8 -->
                        </div>
                        <!-- end row -->
                     </fieldset>
                     <!-- end fieldset -->
                  </div>
                  <!-- end step-3 -->
                  <!-- begin step-4 -->
                  {{-- <div id="step-4">
                     <div class="jumbotron m-b-0 text-center">
                        <h2 class="display-4">Register Successfully</h2>
                        <p class="lead mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat commodo porttitor. <br />Vivamus eleifend, arcu in tincidunt semper, lorem odio molestie lacus, sed malesuada est lacus ac ligula. Aliquam bibendum felis id purus ullamcorper, quis luctus leo sollicitudin. </p>
                        <p><a href="javascript:;" class="btn btn-primary btn-lg">Proceed to User Profile</a></p>
                     </div>
                  </div> --}}
                  <!-- end step-4 -->
               </div>
               <!-- end wizard-content -->
            </div>
            <!-- end wizard -->  
         </form>
      </div>
   </div>
@endsection
@section('scripts')
   <script src="{!! asset('assets/plugins/smartwizard/jquery.smartWizard.js') !!}"></script>
   <script>
      var handleBootstrapWizards = function() {
         "use strict";
         $('#wizard').smartWizard({ 
            selected: 0, 
            theme: 'default',
            transitionEffect:'',
            transitionSpeed: 0,
            useURLhash: false,
            showStepURLhash: false,
            toolbarSettings: {
               toolbarPosition: 'bottom'
            }
         });
      };

      var FormWizard = function () {
         "use strict";
         return {
            //main function
            init: function () {
               handleBootstrapWizards();
            }
         };
      }();

      $(document).ready(function() {
         FormWizard.init();
      });
   </script>
   <script type="text/javascript">
      //get property
      $('#property_select').on('change',function(e){
         console.log(e);
         var propertyID =  e.target.value;
         var url = "{{ url('/') }}"

         //ajax
         $.get(url+'/property-management/maintenance/property/units/'+propertyID, function(data){
            //success data
            //
            $('#units').empty();
            $.each(data, function(units, info){
               $('#units').append('<option value="'+ info.id +'">'+ info.serial +'</option>');
            });
         });
      });

      //get units
      $('#units').on('change',function(e){
         console.log(e);
         var unitID =  e.target.value;
         var url = "{{ url('/') }}"

         //ajax
         $.get(url+'/property-management/maintenance/property/units/tenant/'+unitID, function(data){
            //success data
            $('#tentants').empty();
            $.each(data, function(tenant, ten){
               $('#tentants').append('<option value="'+ ten.id +'">'+ ten.tenant_name +'</option>');
            });
         });
      });

      //get maintenance category
      $('#maintenance_category').on('change',function(e){
         console.log(e);
         var unitID =  e.target.value;
         var url = "{{ url('/') }}"

         //ajax
         $.get(url+'/property-management/maintenance/get/category/'+unitID, function(data){
            //success data
            $('#category').empty();
            $.each(data, function(category, sub){
               $('#category').append('<option value="'+ sub.id +'">'+ sub.name +'</option>');
            });
         });
      });

      $(function () {
         $("#customRadioAuth").click(function () {
            if ($(this).is(":checked")) {
               $("#authorisation").show();
            } else {
               $("#authorisation").hide();
            }
         });
      });
      $(function () {
         $("#customRadioPetresidence").click(function () {
            if ($(this).is(":checked")) {
               $("#petinfo").show();
            } else {
               $("#petinfo").hide();
            }
         });
      });
      $(function () {
         $("#cssRadioAS").click(function () {
            if ($(this).is(":checked")) {
               $("#service_provider").show();
            }
         });
      });
      $(function () {
         $("#cssRadioSA").click(function () {
            if ($(this).is(":checked")) {
               $("#service_provider").hide();
            }
         });
      });
   </script>
@endsection