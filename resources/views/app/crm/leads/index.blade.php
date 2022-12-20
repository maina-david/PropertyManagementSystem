 @extends('layouts.app')
{{-- page header --}}
@section('title','Leads List')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="float-right">
         <a href="{!! route('crm.leads.create') !!}" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add Lead</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-phone-volume"></i> All Leads</h1>
      @include('partials._messages')
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Leads List</h4>
         </div>
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th>Lead Name</th>
                     <th>Email</th>
                     <th>Phone</th>
                     <th>Assigned</th>
                     <th>Status</th>
                     <th>Date Added</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <th width="1%">#</th>
                  <th>Lead Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Assigned</th>
                  <th>Status</th>
                  <th>Date Added</th>
                  <th width="10%">Action</th>
               </tfoot>
               <tbody>
                  @foreach ($leads as $lead)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>
                           @if($lead->title != "")
                              <b>{!! $lead->title !!}</b><br>
                           @endif
                           {!! $lead->customer_name !!}
                        </td>
                        <td>{!! $lead->email !!}</td>
                        <td>{!! $lead->primary_phone_number !!}</td>
                        <td>
                           @if(Wingu::check_user($lead->assignedID) == 1)
                              {!! Wingu::user($lead->assignedID)->name !!}
                           @endif
                        </td>
                        <td>
                           @if(Crm::check_lead_status($lead->statusID) > 0)
                              <span class="badge badge-pink">{!! Crm::lead_status($lead->statusID)->name !!}</span>
                           @endif
                        </td>
                        <td>
                           {!! date("F d, Y", strtotime($lead->created_at)) !!}
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="{{ route('crm.leads.show', $lead->leadID) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 <li><a href="{!! route('crm.leads.edit',$lead->leadID) !!}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 <li><a href="{!! route('crm.leads.delete', $lead->leadID) !!}" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
@endsection
{{-- page scripts --}}
@section('script')

@endsection
