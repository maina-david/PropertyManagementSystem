@extends('layouts.app')
{{-- page header --}}
@section('title','Edit | Customers')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">CRM</a></li>
         <li class="breadcrumb-item"><a href="{!! route('crm.customers.index') !!}">Customers</a></li>
         <li class="breadcrumb-item active">Edit</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-user"></i> Update Customers </h1>
      @include('partials._messages')
      {!! Form::model($contact, ['route' => ['crm.customers.update',$contact->customerID], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
         {!! csrf_field() !!}
         <div class="row">
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
                     <div class="form-group form-group-default required">
                        {!! Form::label('Client Type', 'Customer Type', array('class'=>'control-label text-danger')) !!}
                        {{ Form::select('contact_type',[''=>'Choose Client Type','Individual'=>'Individual','Organization'=>'Company/Organization'], null, ['class' => 'form-control multiselect', 'id' => 'contact_type', 'required' => '']) }}
							</div>
							<div class="form-group form-group-default">
								{!! Form::label('customer_name', 'Customer Name', array('class'=>'control-label text-danger')) !!}
								{!! Form::text('customer_name', null, array('class' => 'form-control', 'placeholder' => 'Enter customer names')) !!}
							</div>
                     @if ($contact->contact_type == "Individual")
                        <div class="row">
                           <div class="col-sm-4">
                              <div class="form-group form-group-default">
                                 {!! Form::label('Salutation', 'Salutation', array('class'=>'control-label')) !!}
                                 {{ Form::select('salutation',[''=>'Choose Salutation','Mr'=>'Mr','Mrs'=>'Mrs','Ms' => 'Ms','Miss' => 'Miss','Dr' => 'Dr'], null, ['class' => 'form-control multiselect']) }}
                              </div>
                           </div>
                           <div class="col-md-8">
										<div class="form-group form-group-default">
											{!! Form::label('Designation', 'Job Designation', array('class'=>'control-label')) !!}
											{!! Form::text('designation', null, array('class' => 'form-control', 'placeholder' => 'Enter job designation')) !!}
										</div>
									</div>
                        </div>
							@endif
                     <div class="form-group form-group-default">
                        {!! Form::label('Referral', 'Referral', array('class'=>'control-label')) !!}
								{!! Form::text('referral', null, array('class' => 'form-control', 'placeholder' => 'Enter referral')) !!}
                     </div>
							<div class="form-group form-group-default">
								{!! Form::label('department', 'Department', array('class'=>'control-label')) !!}
								{!! Form::text('department', null, array('class' => 'form-control', 'placeholder' => 'Enter department')) !!}
							</div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Details</h4>
						</div>
                  <div class="panel-body">
                     <div class="form-group form-group-default">
                        {!! Form::label('email', 'Primary email', array('class'=>'control-label')) !!}
                        {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact email')) !!}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('email_cc', 'Email CC', array('class'=>'control-label')) !!}
                        {!! Form::email('email_cc', null, array('class' => 'form-control', 'placeholder' => 'Email CC')) !!}
                     </div>
                     <div class="form-group form-group-default">
                        {!! Form::label('website', 'Website', array('class'=>'control-label')) !!}
                        {!! Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')) !!}
                     </div>
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
										<label for="">
											Primary Phone Number
											<span class="pull-right" data-toggle="tooltip" data-placement="top" title="Make sure the number starts with the country code, this will be required if you want to send an sms to the contact">
												<i class="fas fa-info-circle"></i>
											</span>
										</label>
                              {!! Form::text('primary_phone_number', null, array('class' => 'form-control','placeholder' => 'e.x +254 700 000 000')) !!}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group form-group-default">
										<label for="">
											Other Phone Number
											<span class="pull-right" data-toggle="tooltip" data-placement="top" title="Make sure the number starts with the country code, this will be required if you want to send an sms to the contact">
												<i class="fas fa-info-circle"></i>
											</span>
										</label>
                              {!! Form::text('other_phone_number', null, array('class' => 'form-control', 'placeholder' => 'e.x +254 700 000 000')) !!}
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
										<label>Customer Category</label>
										{{ Form::select('groups[]', $joincat, null, ['class' => 'form-control multiple-select2','multiple' => 'multiple']) }}
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
												{!! Form::text('facebook', null, array('class' => 'form-control', 'placeholder' => 'Enter facebook link',)) !!}
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group form-group-default">
												{!! Form::label('Twitter', 'Twitter', array('class'=>'control-label')) !!}
												{!! Form::text('twitter', null, array('class' => 'form-control', 'placeholder' => 'Enter twitter link')) !!}
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group form-group-default">
												{!! Form::label('linkedin', 'Linkedin', array('class'=>'control-label')) !!}
												{!! Form::text('linkedin', null, array('class' => 'form-control', 'placeholder' => 'Enter linkedin link')) !!}
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group form-group-default">
												{!! Form::label('skypeID', 'Skype ID', array('class'=>'control-label')) !!}
												{!! Form::text('skypeID', null, array('class' => 'form-control', 'placeholder' => 'Enter Skype ID')) !!}
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-default">
										<label>Contact Logo or Image</label>
									</div>
									<a href="#" id="set-post-thumbnail">Click here to update image</a><br>
									<input type="file" name="image" id="thumbnail" class="file" style="display: none" accept="image/*">
									<div class="row">
										<div class="col-md-12">
											<center>
												<img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$contact->customer_code.'/images/'.$contact->image) !!}" alt="" style="width:30%">
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="address">
							<div class="row">
									<div class="col-md-6">
										<div class="panel-body">
											<p><b>BILLING ADDRESS</b></p>
											<div class="form-group form-group-default">
												{!! Form::label('Attention', 'Attention', array('class'=>'control-label')) !!}
												{!! Form::text('bill_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')) !!}
											</div>
											<div class="form-group form-group-default">
												{!! Form::label('bill_street', 'Street', array('class'=>'control-label')) !!}
												{!! Form::text('bill_street', null, array('class' => 'form-control', 'placeholder' => 'Street')) !!}
											</div>
											<div class="form-group form-group-default">
												{!! Form::label('bill_city', 'City', array('class'=>'control-label')) !!}
												{!! Form::text('bill_city', null, array('class' => 'form-control', 'placeholder' => 'City')) !!}
											</div>
											<div class="form-group form-group-default">
												{!! Form::label('bill_state', 'State', array('class'=>'control-label')) !!}
												{!! Form::text('bill_state', null, array('class' => 'form-control', 'placeholder' => 'State')) !!}
											</div>
											<div class="form-group form-group-default">
													{!! Form::label('bill_postal_address', 'Billing postal address', array('class'=>'control-label')) !!}
													{!! Form::text('bill_postal_address', null, array('class' => 'form-control', 'placeholder' => 'Address')) !!}
											</div>
											<div class="form-group form-group-default">
													{!! Form::label('bill_zip_code', 'Zip Code', array('class'=>'control-label')) !!}
													{!! Form::text('bill_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')) !!}
											</div>
											<div class="form-group form-group-default">
													{!! Form::label('bill_country', 'Country', array('class'=>'control-label')) !!}
													{{ Form::select('bill_country', $country, null, ['class' => 'form-control multiselect']) }}
											</div>
											<div class="form-group form-group-default">
													{!! Form::label('bill_fax', 'Fax', array('class'=>'control-label')) !!}
													{!! Form::text('bill_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')) !!}
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="panel-body">
											<p><b>SHIPPING ADDRESS</b></p>
											<div class="form-group form-group-default">
													{!! Form::label('Attention', 'Attention', array('class'=>'control-label')) !!}
													{!! Form::text('ship_attention', null, array('class' => 'form-control', 'placeholder' => 'Attention')) !!}
											</div>
											<div class="form-group form-group-default">
													{!! Form::label('ship_street', 'Street', array('class'=>'control-label')) !!}
													{!! Form::text('ship_street', null, array('class' => 'form-control', 'placeholder' => 'Street')) !!}
											</div>
											<div class="form-group form-group-default">
													{!! Form::label('ship_city', 'City', array('class'=>'control-label')) !!}
													{!! Form::text('ship_city', null, array('class' => 'form-control', 'placeholder' => 'City')) !!}
											</div>
											<div class="form-group form-group-default">
												{!! Form::label('postal_address', 'Shipping postal address', array('class'=>'control-label')) !!}
												{!! Form::text('ship_postal_address', null, array('class' => 'form-control', 'placeholder' => 'Address')) !!}
											</div>
											<div class="form-group form-group-default">
													{!! Form::label('ship_state', 'State', array('class'=>'control-label')) !!}
													{!! Form::text('ship_state', null, array('class' => 'form-control', 'placeholder' => 'State')) !!}
											</div>
											<div class="form-group form-group-default">
												{!! Form::label('ship_zip_code', 'Zip Code', array('class'=>'control-label')) !!}
												{!! Form::text('ship_zip_code', null, array('class' => 'form-control', 'placeholder' => 'Zip Code')) !!}
											</div>
											<div class="form-group form-group-default">
												{!! Form::label('ship_country', 'Country', array('class'=>'control-label')) !!}
												{{ Form::select('ship_country', $country, null, ['class' => 'form-control multiselect']) }}
											</div>
											<div class="form-group form-group-default">
													{!! Form::label('ship_fax', 'Fax', array('class'=>'control-label')) !!}
													{!! Form::text('ship_fax', null, array('class' => 'form-control', 'placeholder' => 'Fax')) !!}
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
											<th width="1%">#</th>
											<th>Names</th>
											<th>Email Address</th>
											<th>Phone number</th>
											<th>Designation</th>
											<th width="1%">Action</th>
										</tr>
										@foreach($persons as $cp)
											<tr>
												<td>{!! $count++ !!}</td>
												<td>
													{!! $cp->salutation !!} {!! $cp->names !!}
												</td>
												<td>{!! $cp->contact_email !!}</td>
												<td>{!! $cp->phone_number !!}</td>
												<td>{!! $cp->designation !!}</td>
												<td>
													<a class="btn btn-danger delete" href="{{ route('finance.contactperson.delete',$cp->id) }}"><i class="fas fa-trash-alt"></i> Delete</a>
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
										{!! Form::textarea('remarks',null,['class'=>'form-control ckeditor', 'id'=>'editor1', 'rows' => 5, 'placeholder'=>'content']) !!}
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
					<button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Contact</button>
					<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="20%">
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
				i + "' name='cn_names[]'></td><td><input class='form-control' type='text' id='email_address_" + i + "' name='email_address[]'></td><td><input class='form-control' type='text' id='phone_number_" + i +
				"' name='phone_number[]'></td><td><input class='form-control' type='text' id='cn_desgination_" + i + "' name='cn_desgination[]'></td><tr>";
			$('.contact_persons').append(data);
		});

      $("#set-post-thumbnail").click(function() {
			$("input[id='thumbnail']").click();
		});

		$(".multiple-select2").select2();
		$(".multiple-select2").select2().val({!! json_encode($jointcategories) !!}).trigger('change');
	</script>
	<script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
	<script type="text/javascript">
		CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
