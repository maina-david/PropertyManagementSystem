@extends('layouts.app')
{{-- page header --}}
@section('title','Update Tenant Information')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb --> 
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.dashboard') !!}">Property Management</a></li>
         <li class="breadcrumb-item"><a href="#">Tenant</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header">Update Tenant Information </h1>
      @include('partials._messages')
      {!! Form::model($tenant, ['route' => ['pm.tenants.update',$tenant->tenantID], 'method'=>'post','enctype'=>'multipart/form-data']) !!}
         {!! csrf_field() !!}
         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                     </div>
                     <h4 class="panel-title">Details</h4>
                  </div>
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Client Type', 'Client Type', array('class'=>'control-label')) !!}
                        {{ Form::select('tenant_type',[''=>'Choose Client Type','Individual'=>'Individual','Organization'=>'Company/Organization'], null, ['class' => 'form-control','data-init-plugin' => 'select2', 'id' => 'tenant_type' ]) }}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('client_name', 'Tenant Name', array('class'=>'control-label')) !!}
                        {!! Form::text('tenant_name', null, array('class' => 'form-control', 'placeholder' => 'Tenant Names')) !!}
                     </div>
                     <div class="form-group form-group-default required ">
                        {!! Form::label('Referral', 'Referral', array('class'=>'control-label')) !!}
                        {!! Form::text('referral', null, ['class' => 'form-control']) !!}
                     </div>
                     <div class="form-group form-group-default required ">
                        {!! Form::label('designation', 'Designation', array('class'=>'control-label')) !!}
                        {!! Form::text('designation', null, array('class' => 'form-control', 'placeholder' => 'designation')) !!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                     </div>
                     <h4 class="panel-title">Details</h4>
                  </div>
                  <div class="panel-body">
                     <div class="form-group form-group-default">
                        {!! Form::label('contact_email', 'Primary Contact Email', array('class'=>'control-label')) !!}
                        {!! Form::email('contact_email', null, array('class' => 'form-control', 'placeholder' => 'Contact Email')) !!}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('email_cc', 'Email CC', array('class'=>'control-label')) !!}
                        {!! Form::email('email_cc', null, array('class' => 'form-control', 'placeholder' => 'Email CC')) !!}
                     </div>
                     <div class="form-group form-group-default required ">
                        {!! Form::label('website', 'Website', array('class'=>'control-label')) !!}
                        {!! Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')) !!}
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default required">
                              {!! Form::label('primary_phone_number', 'Primary Phone Number', array('class'=>'control-label')) !!}
                              {!! Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x 0700 000 000','required' => '')) !!}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
                              {!! Form::label('other_phone_number', 'Other Phone Number', array('class'=>'control-label')) !!}
                              {!! Form::text('other_phone_number', null, array('class' => 'form-control', 'placeholder' => 'e.x 0700 000 000')) !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <ul class="nav nav-pills">
						<li class="nav-items">
							<a href="#other_details" data-toggle="tab" class="nav-link active">
								<span class="d-sm-none">Other Details</span>
								<span class="d-sm-block d-none">Other Details</span>
							</a>
						</li>
						<li class="nav-items">
							<a href="#address" data-toggle="tab" class="nav-link">
								<span class="d-sm-none">Address</span>
								<span class="d-sm-block d-none">Address</span>
							</a>
						</li>
						<li class="nav-items">
							<a href="#contact-person" data-toggle="tab" class="nav-link  show">
								<span class="d-sm-none">Contact Persons</span>
								<span class="d-sm-block d-none">Contact Persons</span>
							</a>
						</li>
						<li class="nav-items">
							<a href="#remarks" data-toggle="tab" class="nav-link">
								<span class="d-sm-none">Remarks</span>
								<span class="d-sm-block d-none">Remarks</span>
							</a>
						</li>
					</ul>
               <div class="tab-content">
                  <div class="tab-pane active" id="other_details">
                     <div class="row ">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Default Currency</label>
                              {{ Form::select('currency', $currency, null, ['class' => 'form-control multiselect' ]) }}
                           </div>
                           {{-- <div class="form-group form-group-default">
                              {!! Form::label('payment_terms', 'Payment Terms', array('class'=>'control-label')) !!}
                              {{ Form::select('payment_terms', $terms, null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2', 'required' => '' ]) }}
                           </div> --}}
                           {{-- <div class="checkbox ">
                              <input type="checkbox" value="1" id="checkbox1" name="portal">
                              <label for="checkbox1">Allow portal access for this contact</label>
                           </div> --}}
                           {{-- <div class="form-group form-group-default required">
                              {!! Form::label('language', 'Language', array('class'=>'control-label')) !!}
                              {{ Form::select('language', $language, null, ['class' => 'form-control full-width', 'data-init-plugin' => 'select2', 'required' => '' ]) }}
                           </div> --}}
                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Facebook', 'Facebook', array('class'=>'control-label')) !!}
                                    {!! Form::text('facebook', null, array('class' => 'form-control', 'placeholder' => 'Facebook',)) !!}
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-group form-group-default">
                                    {!! Form::label('Twitter', 'Twitter', array('class'=>'control-label')) !!}
                                    {!! Form::text('twitter', null, array('class' => 'form-control', 'placeholder' => 'Twitter')) !!}
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label>Tenant Logo or Image</label>
                           </div>
                           <a href="#" id="set-post-thumbnail">Click here to choose an image</a><br>
                           <input type="file" name="image" id="thumbnail" class="file" style="display: none">
                           <div class="row">
                              <center><img src="{!! url('/') !!}/storage/files/business/{!! Wingu::business(Auth::user()->businessID)->primary_email !!}/tenant/{!! $tenant->tenant_code !!}/images/{!! $tenant->image !!}" alt="" style="width:50%"></center>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="address">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="panel-body">
                              <b>BILLING ADDRESS</b>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="panel-body">                              
                              <div class="form-group form-group-default required ">
                                    {!! Form::label('Attention', 'Attention', array('class'=>'control-label')) !!}
                                    {!! Form::text('bill_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')) !!}
                              </div>
                              <div class="form-group form-group-default required ">
                                    {!! Form::label('bill_street', 'Street', array('class'=>'control-label')) !!}
                                    {!! Form::text('bill_street', null, array('class' => 'form-control', 'placeholder' => 'Street')) !!}
                              </div>
                              <div class="form-group form-group-default required ">
                                    {!! Form::label('bill_city', 'City', array('class'=>'control-label')) !!}
                                    {!! Form::text('bill_city', null, array('class' => 'form-control', 'placeholder' => 'City')) !!}
                              </div>
                              <div class="form-group form-group-default required ">
                                    {!! Form::label('bill_state', 'State', array('class'=>'control-label')) !!}
                                    {!! Form::text('bill_state', null, array('class' => 'form-control', 'placeholder' => 'State')) !!}
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="panel-body">
                              <div class="form-group form-group-default required ">
                                 {!! Form::label('bill_address', 'Billing Address', array('class'=>'control-label')) !!}
                                 {!! Form::text('bill_address', null, array('class' => 'form-control', 'placeholder' => 'Address')) !!}
                           </div>
                           <div class="form-group form-group-default required ">
                                 {!! Form::label('bill_zip_code', 'Zip Code', array('class'=>'control-label')) !!}
                                 {!! Form::text('bill_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')) !!}
                           </div>
                           <div class="form-group form-group-default">
                                 {!! Form::label('bill_country', 'Country', array('class'=>'control-label')) !!}
                                 {{ Form::select('bill_country', $country, null, ['class' => 'form-control multiselect' ]) }}
                           </div>
                           <div class="form-group form-group-default required ">
                                 {!! Form::label('bill_fax', 'Fax', array('class'=>'control-label')) !!}
                                 {!! Form::text('bill_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')) !!}
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="contact-person">
                     <div class="row"><br>
                        <div class="col-md-12">
                           <table class="table table-bordered">
                              <tr>
                                 <th>#</th>
                                 <th>Names</th>
                                 <th>Email Address</th>
                                 <th>Work Phone</th>
                                 <th>Designation</th>
                                 <th>Action</th>
                              </tr>
                              @foreach($persons as $cp)
                                 <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>{!! $cp->names !!}</td>
                                    <td>{!! $cp->contact_email !!}</td>
                                    <td>{!! $cp->phone_number !!}</td>
                                    <td>{!! $cp->designation !!}</td> 
                                    <td colspan="" rowspan="" headers="">
                                       <div class="btn-group sm-m-t-10">
                                          <a class="btn btn-danger delete" href="{{ route('tenant.contactperson.delete',$cp->id) }}"><i class="fas fa-trash-alt"></i></a>
                                       </div>
                                    </td>
                                 </tr>
                              @endforeach
                           </table>
                           <br><br>
                           <p><b>Add Contact person</b></p>
                           <table class="table table-bordered contact_persons">
                              <tr>
                                 <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                 <th>#</th>
                                 <th>Salutation</th>
                                 <th>Names</th>
                                 <th>Email Address</th>
                                 <th>Phone number</th>
                                 <th>Designation</th>
                              </tr>
                           </table>
                           <button type="button" class='btn btn-danger delete_contact_persons'> - Delete</button>
                           <button type="button" class='btn btn-success addmore_contact_persons'> + Add More</button>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="remarks">
                     <div class="row"><br>
                        <div class="col-md-12">
                           <div class="form-group">
                              {!! Form::label('Remarks', 'Remarks', array('class'=>'control-label')) !!}
                              {!! Form::textarea('remarks',null,['class'=>'form-control ck4standard', 'id'=>'editor1', 'rows' => 5, 'placeholder'=>'content']) !!}
                           </div>
                           <br>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="panel-body">
               <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Tenant</button>
            </div>
         </div>
      {!! Form::close() !!}
	</div>
@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
      $(".delete_contact_persons").on('click', function() {
         $('.case:checkbox:checked').parents("tr").remove();
         $('.check_all').prop("checked", false);
         check();
      });

      var i=$('.contact_persons tr').length;
      var n = 1;
      $(".addmore_contact_persons").on('click', function() {
		count = $('.contact_persons tr').length;
		var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum" + i + "'>" + n++ + ".</span></td>";
		data +=
			"<td><select id='cn_salutation' class='form-control' name='cn_salutation[]'><option value='' selected='selected'>Choose Salutation</option><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option></select></td><td><input class='form-control' type='text' id='cn_names" +
			i + "' name='cn_names[]'></td><td><input class='form-control' type='text' id='email_address_" + i + "' name='email_address[]'></td><td><input class='form-control' type='text' id='phone_number" + i + "' name='phone_number[]'></td><td><input class='form-control' type='text' id='cn_desgination_" + i + "' name='cn_desgination[]'></td><tr>";
		$('.contact_persons').append(data);
	});

      $("#set-post-thumbnail").click(function() {
			$("input[id='thumbnail']").click();
		});
   </script>
@endsection
