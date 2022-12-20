@extends('layouts.app')
{{-- page header --}}
@section('title','Credit Note Settings')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item">Credit note</li>
         <li class="breadcrumb-item active">General</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-credit-card"></i> Credit Note Settings</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.finance.partials._settings_nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('finance.settings.creditnote') }}" href="{!! route('finance.settings.creditnote') !!}"><i class="fal fa-sort-numeric-up"></i> Generated Numbers</a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isResource('defaults') }}" href="{!! route('finance.settings.creditnote.defaults',$settings->id) !!}">
                           <i class="fal fa-file-invoice-dollar"></i> Defaults
                        </a>
                     </li>
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isResource('tabs') }}" href="{!! route('finance.settings.creditnote.tabs',$settings->id) !!}">
                           <i class="fas fa-table"></i> Credit note Tabs
                        </a>
                     </li> --}}
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
                     @if(Request::is('finance/settings/creditnote'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.creditnote.generated.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                              <div class="form-group">
                                 <label for="">Credit Note Number</label>
                                 {!! Form::number('number', null, array('class' => 'form-control', 'value' => '000')) !!}
                              </div>
                              <div class="form-group">
                                 <label for="">Credit Note Prefix</label>
                                 {!! Form::text('prefix', null, array('class' => 'form-control')) !!}
                              </div>
                              <p class="font-weight-bold"><i class="fas fa-info-circle text-primary"></i> Specify a prefix to dynamically set the Credit Note number.</p>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           {!! Form::close() !!}
                        </div>
                     @endif
                     @if(Request::is('finance/settings/creditnote/'.$settings->id.'/defaults'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.creditnote.defaults.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                              <div class="form-group">
                                 <h4 for="">Default Terms & Conditions</h4>
                                 {!! Form::textarea('default_terms_conditions', null, array('class' => 'form-control ckeditor')) !!}
                              </div>
                              <div class="form-group">
                                 <h4 for="">Default Credit Note Footer</h4>
                                 {!! Form::textarea('default_footer', null, array('class' => 'form-control ckeditor')) !!}
                              </div>
                              <div class="form-group">
                                 <h4 for="">Customer Notes</h4>
                                 {!! Form::textarea('default_customer_notes', null, array('class' => 'form-control ckeditor')) !!}
                              </div>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           {!! Form::close() !!}
                        </div>
                     @endif
                     {{-- @if(Request::is('finance/settings/creditnote/'.$settings->id.'/tabs'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.creditnote.tabs.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                              <div class="form-check">
                                 <input type="checkbox" value="Yes" name="show_discount_tab" class="form-check-input" id="defaultCheckbox" @if($settings->show_discount_tab == 'Yes') Checked @endif/>
                                 <label class="form-check-label" for="defaultCheckbox">Show Discount tab on Credit Note<label>
                              </div><br>
                              <div class="form-check">
                                 <input type="checkbox" value="Yes" name="show_tax_tab" class="form-check-input" id="defaultCheckbox" @if($settings->show_tax_tab == 'Yes') Checked @endif/>
                                 <label class="form-check-label" for="defaultCheckbox">Show Tax tab on creditnote<label>
                              </div>
                              <div class="form-group mt-5">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           {!! Form::close() !!}
                        </div>
                     @endif --}}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')
<script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection

