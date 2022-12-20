@extends('layouts.app')
{{-- page header --}}
@section('title','Quote Settings')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('finance.index') !!}">Finance</a></li>
         <li class="breadcrumb-item"><a href="{!! route('finance.settings.quote') !!}">Settings</a></li>
         <li class="breadcrumb-item">Quote</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="far fa-file-alt"></i> Quote Settings</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.finance.partials._settings_nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('finance.settings.quote') }}" href="{!! route('finance.settings.quote') !!}"><i class="fas fa-sort-numeric-up"></i> Generated Numbers</a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isResource('defaults') }}" href="{!! route('finance.settings.quote.defaults',$settings->id) !!}">
                           <i class="fas fa-file-invoice-dollar"></i> Defaults
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isResource('tabs') }}" href="{!! route('finance.settings.quote.tabs',$settings->id) !!}">
                           <i class="fas fa-table"></i> Quote Tabs
                        </a>
                     </li>
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
                     @if(Request::is('finance/settings/quote'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.quote.generated.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                              <div class="form-group">
                                 <label for="">Quote Number</label>
                                 {!! Form::number('number', null, array('class' => 'form-control', 'value' => '000')) !!}
                              </div>
                              <div class="form-group">
                                 <label for="">Quote Prefix</label>
                                 {!! Form::text('prefix', null, array('class' => 'form-control')) !!}
                              </div>
                              <p class="font-weight-bold"><i class="fas fa-info-circle text-primary"></i> Specify a prefix to dynamically set the Quote number.</p>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           {!! Form::close() !!}
                        </div>
                     @endif
                    @if(Request::is('finance/settings/quote/'.$settings->id.'/defaults'))
                    <div class="">
                        {!! Form::model($settings, ['route' => ['finance.settings.quote.defaults.update',$settings->id], 'method'=>'post',]) !!}
                           {!! csrf_field() !!}
                           <div class="form-group">
                              <h4 for="">Quote email bcc</h4>
                              {!! Form::text('bcc', null, array('class' => 'form-control')) !!}
                           </div>
                           <div class="form-group">
                              <h4 for="">Default Terms & Conditions</h4>
                              {!! Form::textarea('default_terms_conditions', null, array('class' => 'form-control ckeditor')) !!}
                           </div>
                           {{-- <div class="form-group">
                              <h4 for="">Default Quote Footer</h4>
                              {!! Form::textarea('default_footer', null, array('class' => 'form-control ckeditor')) !!}
                           </div> --}}
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
                     @if(Request::is('finance/settings/quote/'.$settings->id.'/tabs'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.quote.tabs.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                              <div class="form-check">
                                 <input type="checkbox" value="Yes" name="show_discount_tab" class="form-check-input" id="defaultCheckbox" @if($settings->show_discount_tab == 'Yes') Checked @endif/>
                                 <label class="form-check-label" for="defaultCheckbox">Show Discount tab on quote<label>
                              </div><br>
                              <div class="form-check">
                                 <input type="checkbox" value="Yes" name="show_tax_tab" class="form-check-input" id="defaultCheckbox" @if($settings->show_tax_tab == 'Yes') Checked @endif/>
                                 <label class="form-check-label" for="defaultCheckbox">Show Tax tab on quote<label>
                              </div>
                              <div class="form-group mt-5">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                </center>
                              </div>
                           {!! Form::close() !!}
                        </div>
                     @endif
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

