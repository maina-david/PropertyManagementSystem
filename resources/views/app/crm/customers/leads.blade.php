@extends('layouts.app')
{{-- page header --}}
@section('title','ContactList')
{{-- page styles --}}
@section('stylesheets')
	
@endsection

{{-- dashboad menu --}}
@section('main-menu')
	@include('app.crm.partials._main_menu')
@endsection

{{-- content section --}}
@section('content')
	<div class="normalheader ">
        <div class="hpanel">
            <div class="panel-body">
                <a class="small-header-action" href="">
                    <div class="clip-header">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                </a>
                <div id="hbreadcrumb" class="pull-right m-t-lg">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="{{ url('home') }}">Dashboard</a></li>
                        <li>
                            <span>Contacts</span>
                        </li>
                        <li class="active">
                            <span>Contact List</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Contacts
                </h2>
                <small>Quick way to view all your clients and how much they owe the company</small>
            </div>
        </div>
    </div>
	<div class="content"> 
        <div class="row p-b-20">                
            <a href="{{ url('crm/leads/create') }}" class="btn btn-info pull-right m-r-20"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Leads</a>            
        </div>
		<div class="row">
            @foreach ($leads as $cnt)
                <div class="col-lg-3">
                    <div class="hpanel @if ($cnt->contact_type == 'Individual') hgreen @elseif($cnt->contact_type == 'Organization') hred @else hblue @endif contact-panel">
                        <div class="panel-body">
                            @if ($cnt->contact_type == 'Individual')
                                <span class="label label-success pull-right"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Individual</span>
                            @elseif($cnt->contact_type == 'Organization')
                                <span class="label label-info pull-right"><i class="fa fa-building-o" aria-hidden="true"></i> Organization</span>
                            @else

                            @endif  
                            @if ($cnt->client_type == 'Lead')
                                <span class="label label-warning pull-right"><i class="fa fa-bullseye" aria-hidden="true"></i> Leads </span> 
                            @endif                          
                            <img alt="logo" class="img-circle m-b" src="{{ asset('resources/assets/images/profile_avatar.png') }}">
                            <h3><a href="{{ url('crm/contact/'.$cnt->id.'/view') }}">
                            @if ($cnt->company_name == "")
                                {!! $cnt->first_name !!} {!! $cnt->last_name !!}
                            @elseif($cnt->first_name == "")
                                {!! $cnt->company_name !!}
                            @endif.</a></h3>
                            <div class="text-muted font-bold m-b-xs">{!! $cnt->contact_email !!}</div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.
                            </p>
                        </div>
                        <div class="panel-footer contact-footer">
                            <div class="row">
                                <div class="col-md-6 border-right"> 
                                    <a href="{{ url('crm/contact/'.$cnt->id.'/view') }}" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="{{ url('crm/Contact/'.$cnt->id.'/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="{{ url('crm/Contact/'.$cnt->id.'/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
	</div>	

    <contact-quick-edit></contact-quick-edit>
@endsection
{{-- page scripts --}}
@section('script')
	
@endsection