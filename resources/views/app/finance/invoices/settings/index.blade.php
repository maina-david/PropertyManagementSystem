@extends('layouts.app')
{{-- page header --}}
@section('title','Invoice Settings')
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
         <li class="breadcrumb-item">Invoice</li>
         <li class="breadcrumb-item active">General</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-tools"></i>  Invoice Settings</h1>
      @include('partials._messages')
      <div class="row">
         @include('app.finance.partials._settings_nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('finance.settings.invoice') }}" href="{!! route('finance.settings.invoice') !!}"><i class="fas fa-sort-numeric-up"></i> Generated Numbers</a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isResource('defaults') }}" href="{!! route('finance.settings.invoice.defaults',$settings->id) !!}">
                           <i class="fas fa-file-invoice-dollar"></i> Defaults
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isResource('workflow') }}" href="{!! route('finance.settings.invoice.workflow',$settings->id) !!}">
                           <i class="fas fa-toolbox"></i> Workflow Settings
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isResource('payments') }}" href="{!! route('finance.settings.invoice.payments',$settings->id) !!}">
                           <i class="fas fa-sliders-h"></i> Payments Settings
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isResource('tabs') }}" href="{!! route('finance.settings.invoice.tabs',$settings->id) !!}">
                           <i class="fas fa-table"></i> Invoice Tabs
                        </a>
                     </li>
                  </ul>
               </div>

               <div class="card-block">
                  <div class="p-0 m-0">
                     @if(Request::is('finance/settings/invoice'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.invoice.generated.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                              <div class="form-group">
                                 <label for="">Invoice Number</label>
                                 {!! Form::number('number', null, array('class' => 'form-control', 'value' => '000')) !!}
                              </div>
                              <div class="form-group">
                                 <label for="">Invoice Prefix</label>
                                 {!! Form::text('prefix', null, array('class' => 'form-control')) !!}
                              </div>
                              <p class="font-weight-bold"><i class="fas fa-info-circle text-primary"></i> Specify a prefix to dynamically set the invoice number. The invoice number will have 2 extra zeros i.e 002.</p>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           {!! Form::close() !!}
                        </div>
                     @endif
                     @if(Request::is('finance/settings/invoice/'.$settings->id.'/defaults'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.invoice.defaults.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                              <div class="form-group">
                                 <h4 for="">Default Terms & Conditions</h4>
                                 {!! Form::textarea('default_terms_conditions', null, array('class' => 'form-control ckeditor')) !!}
                              </div>
                              <div class="form-group">
                                 <h4 for="">Default Invoice Footer</h4>
                                 {!! Form::textarea('default_invoice_footer', null, array('class' => 'form-control ckeditor')) !!}
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
                     @if(Request::is('finance/settings/invoice/'.$settings->id.'/workflow'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.invoice.workflow.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="editing_of_Sent" class="custom-control-input" id="customCheckSent"  @if($settings->editing_of_Sent == 'Yes') Checked @endif/>
                                 <label class="custom-control-label" for="customCheckSent">Allow editing of Sent Invoice?<label>
                              </div><br>
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="automatically_email_recurring" class="custom-control-input" id="customCheckAuto"  @if($settings->automatically_email_recurring == 'Yes') Checked @endif/>
                                 <label class="custom-control-label" for="customCheckAuto">Enable Auto Email<label>
                              </div>
                              <p>Automatically email recurring invoices when they are created.</p>
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="auto_archive" class="custom-control-input" id="customCheckArchive"  @if($settings->auto_archive == 'Yes') Checked @endif/>
                                 <label class="custom-control-label" for="customCheckArchive">Enable Auto Archive<label>
                              </div>
                              <p>Automatically archive invoices when they are paid.</p>
                              <div class="form-group">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i> Update Information</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           {!! Form::close() !!}
                        </div>
                     @endif
                     @if(Request::is('finance/settings/invoice/'.$settings->id.'/payments'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.invoice.payments.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="notify_on_payment" class="custom-control-input" id="customChecknotified"  @if($settings->notify_on_payment == 'Yes') Checked @endif/>
                                 <label class="custom-control-label" for="customChecknotified">Get notified when customers pay online<label>
                              </div><br>
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="automate_thank_you_note" class="custom-control-input" id="customCheckreceipt"  @if($settings->automate_thank_you_note == 'Yes') Checked @endif/>
                                 <label class="custom-control-label" for="customCheckreceipt">Do you want to include the payment receipt along with the Thank You Note?<label>
                              </div><br>
                               <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="auto_thank_you_payment_received" class="custom-control-input" id="customCheckthank"  @if($settings->auto_thank_you_payment_received == 'Yes') Checked @endif/>
                                 <label class="custom-control-label" for="customCheckthank">Automate thank you note to customer on receipt of online payment.<label>
                              </div>
                              <div class="form-group mt-5">
                                 <center>
                                    <button type="submit" class="btn pink submit"><i class="fas fa-save"></i>  Update Information</button>
                                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                                 </center>
                              </div>
                           {!! Form::close() !!}
                        </div>
                     @endif
                     @if(Request::is('finance/settings/invoice/'.$settings->id.'/tabs'))
                        <div class="">
                           {!! Form::model($settings, ['route' => ['finance.settings.invoice.tabs.update',$settings->id], 'method'=>'post',]) !!}
                              {!! csrf_field() !!}
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="custom-control-input" name="show_discount_tab" id="customCheckDiscounttab" value="Yes" @if($settings->show_discount_tab == 'Yes') Checked @endif>
                                 <label class="custom-control-label" for="customCheckDiscounttab">Show Discount tab on invoice</label>
                              </div>
                              <br>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" value="Yes" name="show_tax_tab" class="custom-control-input" id="customCheckTaxtab"  @if($settings->show_tax_tab == 'Yes') Checked @endif/>
                                 <label class="custom-control-label" for="customCheckTaxtab">Show Tax tab on invoice<label>
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
   <script src="{!! asset('/assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
