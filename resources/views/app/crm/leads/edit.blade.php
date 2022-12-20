@extends('layouts.app')
{{-- page header --}}
@section('title','Edit Lead')
{{-- page styles --}}
@section('stylesheet')
<script type="text/javascript">
    .nav > li {
        position: relative;
        display: block;
        /* width: 100%; */
    }
</script>
@endsection

{{-- dashboad menu --}}
@section('sidebar')
@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
<div class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li class="breadcrumb-item"><a href="{!! route('crm.dashboard') !!}">CRM</a></li>
        <li class="breadcrumb-item"><a href="{!! route('crm.leads.index') !!}">Leads</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <form action="" method="post"></form>
    <h1 class="page-header"><i class="fas fa-phone-volume"></i> Edit Lead </h1>
    @include('partials._messages')
   {!! Form::model($edit, ['route' => ['crm.leads.update', $edit->leadID], 'method'=>'post']) !!}
      @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Details</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group form-group-default required">
                           {!! Form::label('designation', 'Lead Owner', array('class'=>'control-label')) !!}
                           {!! Form::select('assignedID', $employees, null, array('class' => 'form-control multiselect')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('title', 'Title', array('class'=>'control-label')) !!}
                            {!! Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('Lead Type', 'Lead Type', array('class'=>'control-label')) !!}
                            {{ Form::select('lead_type',[''=>'Choose Lead Type','Individual'=>'Individual','Organization'=>'Company/Organization'], null, ['class' => 'form-control multiselect','id' => 'contact_type']) }}
                        </div>
                        @if($edit->contact_type == 'Individual')
                           <div class="row">
                              <div class="col-sm-4">
                                 <div class="form-group form-group-default">
                                       {!! Form::label('Salutation', 'Salutation', array('class'=>'control-label')) !!}
                                       {{ Form::select('salutation',[''=>'Choose Salutation','Mr'=>'Mr','Mrs'=>'Mrs','Ms' => 'Ms','Miss' => 'Miss','Dr' => 'Dr'], null, ['class' => 'form-control multiselect']) }}
                                 </div>
                              </div>
                              <div class="col-sm-8">
                                 <div class="form-group form-group-default ">
                                       {!! Form::label('Position', 'Position', array('class'=>'control-label')) !!}
                                       {!! Form::text('position', null, array('class' => 'form-control', 'placeholder' => 'Enter individuals position')) !!}
                                 </div>
                              </div>
                           </div>
                        @endif
                        <div class="form-group form-group-default required">
                            {!! Form::label('Leads name', 'Leads Name', array('class'=>'control-label text-danger')) !!}
                            {!! Form::text('leads_name', null, array('class' => 'form-control', 'placeholder' => 'Enter leads name', 'required' => '')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('email', 'Email Address', array('class'=>'control-label')) !!}
                            {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Contact Email')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('designation', 'Industry', array('class'=>'control-label')) !!}
                            {!! Form::select('industry', $industry, null, array('class' => 'form-control multiselect')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('status', 'Status', array('class'=>'control-label')) !!}
                            {!! Form::select('status', $status, null, array('class' => 'form-control multiselect')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('website', 'Website', array('class'=>'control-label')) !!}
                            {!! Form::text('website', null, array('class' => 'form-control', 'placeholder' => 'Website')) !!}
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
                            {!! Form::label('location', 'Location', array('class'=>'control-label')) !!}
                            {!! Form::text('location', null, array('class' => 'form-control', 'placeholder' => '')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('Source', 'Source', array('class'=>'control-label')) !!}
                            {!! Form::select('sourceID', $sources, null, array('class' => 'form-control multiselect')) !!}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    {!! Form::label('Phone number', 'Phone Number', array('class'=>'control-label text-danger')) !!}
                                    {!! Form::text('phone_number', null, array('class' => 'form-control','required' => '')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('Source', 'Postal address', array('class'=>'control-label')) !!}
                            {!! Form::text('postal_address', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('country', 'Country', array('class'=>'control-label')) !!}
                            {!! Form::select('country', $country, null, array('class' => 'form-control multiselect')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('City', 'City', array('class'=>'control-label')) !!}
                            {!! Form::text('city', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('state', 'State', array('class'=>'control-label')) !!}
                            {!! Form::text('state', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group form-group-default">
                            {!! Form::label('zip code', 'Zip Code', array('class'=>'control-label')) !!}
                            {!! Form::text('zip_code', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     All Contact persons
                  </div>
                  <div class="card-body">
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
                  </div>
               </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add Contact persons</div>
                    <div class="card-body">
                        <table class="table table-bordered contact_persons">
                            <tr>
                                <th><input class='check_all' type='checkbox' onclick="select_all()" /></th>
                                <th>#</th>
                                <th>Salutation</th>
                                <th>Full Names</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Designation</th>
                            </tr>
                        </table>
                        <button type="button" class='btn btn-danger delete_contact_persons'>- Delete</button>
                        <button type="button" class='btn btn-success addmore_contact_persons'>+ Add More</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Description</h4>
                    </div>
                    <div class="panel-body">
                        {!! Form::textarea('description', null, array('class' => 'form-control ckeditor')) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <center>
                    <button type="submit" class="btn btn-pink submit btn-lg"><i class="fas fa-save"></i> Update Lead</button>
                    <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="13%">
                </center>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection
{{-- page scripts --}}
@section('scripts')
<script>
    $(document).ready(function() {
        $('#contact_type').on('change', function() {
            if (this.value == 'Individual') {
                $('#individual').show();
            } else {
                $('#individual').hide();
            }

            if (this.value == 'Organization') {
                $('#company').show();
            } else {
                $('#company').hide();
            }
        });
    });

    $(".delete_contact_persons").on('click', function() {
        $('.case:checkbox:checked').parents("tr").remove();
        $('.check_all').prop("checked", false);
        check();
    });

    var i = $('.contact_persons tr').length;
    var n = 1;
    $(".addmore_contact_persons").on('click', function() {
        count = $('.contact_persons tr').length;
        var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum" + i + "'>" + n++ + ".</span></td>";
        data +=
            "<td><select id='cn_salutation' class='form-control' name='cn_salutation[]'><option value='' selected='selected'>Choose Salutation</option><option value='Mr'>Mr</option><option value='Mrs'>Mrs</option><option value='Ms'>Ms</option><option value='Miss'>Miss</option><option value='Dr'>Dr</option></select></td><td><input class='form-control' type='text' id='cn_names" +
            i + "' name='cn_names[]'></td><td><input class='form-control' type='text' id='email_address_" + i + "' name='email_address[]'></td><td><input class='form-control' type='text' id='phone_number_" + i +
            "' name='cp_phone_number[]'></td><td><input class='form-control' type='text' id='cn_desgination_" + i + "' name='cn_desgination[]'></td><tr>";
        $('.contact_persons').append(data);
    });


    $("#set-post-thumbnail").click(function() {
        $("input[id='thumbnail']").click();
    });
</script>
<script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
<script type="text/javascript">
    CKEDITOR.replaceClass="ckeditor";
</script>
@endsection
