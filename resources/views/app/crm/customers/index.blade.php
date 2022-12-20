@extends('layouts.app')
{{-- page header --}}
@section('title','Customer List')

{{-- dashboad menu --}}
@section('sidebar')
  @include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
      <div class="pull-right">
         <a href="{!! route('crm.customers.create') !!}" class="btn btn-pink"><i class="fal fa-user-plus"></i> Add a Customers</a>
         @permission('create-contact')
            <a href="{!! route('finance.contact.import') !!}" target="_blank" class="btn btn-primary"><i class="fal fa-file-upload"></i> Import Customer</a>
         @endpermission
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-users"></i> All Customers</h1>
		@include('partials._messages')
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Customer List</h4>
			</div>
			<div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr>
                     <th width="1%">#</th>
                     <th width="5">Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phonenumber</th>
                     <th>Category</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>#</th>
                     <th>Image</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phonenumber</th>
                     <th>Category</th>
                     <th>Action</th>
                  </tr>
               </tfoot>
               <tbody>
                  @foreach ($customers as $contact)
                     <tr {{-- class="success" --}}>
                        <td>{!! $count++ !!}</td>
                        <td>
                           @if($contact->image != "")
                              <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$contact->customer_code.'/images/'.$contact->image) !!}" alt="" style="width:40px;height:40px" class="rounded-circle">
                           @else
                              <img src="https://ui-avatars.com/api/?name={!! $contact->customer_name !!}&rounded=true&size=40" alt="">
                           @endif
                        </td>
                        <td>
                           @if($contact->contact_type == 'Individual')
                              {!! $contact->salutation !!} {!! $contact->customer_name !!}
                           @else
                              {!! $contact->customer_name !!}
                           @endif
                        </td>
                        <td>{!! $contact->email !!}</td>
                        <td>{!! $contact->primary_phone_number !!}</td>
                        <td>
									@foreach (Finance::client_category($contact->customerID) as $category)
										<span class="badge badge-primary">{!! $category->name !!}</span>
									@endforeach
                        </td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 @permission('read-crmcustomers')
                                    <li><a href="{{ route('crm.customers.show',$contact->customerID) }}"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp; View</a></li>
                                 @endpermission
                                 @permission('update-crmcustomers')
                                    <li><a href="{{ route('crm.customers.edit', $contact->customerID) }}"><i class="fas fa-edit"></i>&nbsp;&nbsp; Edit</a></li>
                                 @endpermission
                                 @permission('delete-crmcustomers')
                                    <li><a href="{!! route('crm.customers.delete', $contact->customerID) !!}" class="delete"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Delete</a></li>
                                 @endpermission
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
