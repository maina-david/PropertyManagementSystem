@extends('layouts.app')
@section('title','Dashboard')
@section('sidebar')
	@include('app.property.partials._menu')
@endsection
@section('content')
   <div id="content" class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="row">
               <div class="col-xl-3 col-lg-6 col-sm-6">
                  <div class="widget widget-stats bg-blue">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-users"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Tenants</div>
                        <div class="stats-number">{!! number_format($tenants) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="{!! route('tenants.index') !!}" class="text-white">View Tenants</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-sm-6">
                  <div class="widget widget-stats bg-warning">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-users-crown"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Owners</div>
                        <div class="stats-number">{!! number_format($owners) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="{!! route('landlord.index') !!}" class="text-white">View Owners</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-sm-6">
                  <div class="widget widget-stats bg-success">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-door-open"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Vacant</div>
                        <div class="stats-number">{!! number_format($vacant) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="{!! route('property.index') !!}" class="text-white">View vacancies</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-3 col-lg-6 col-sm-6">
                  <div class="widget widget-stats bg-danger">
                     <div class="stats-icon stats-icon-lg"><i class="fal fa-door-closed"></i></div>
                     <div class="stats-content">
                        <div class="stats-title">Occupied</div>
                        <div class="stats-number">{!! number_format($occupied) !!}</div>
                        <div class="stats-progress progress">
                           <div class="progress-bar" style="width:100%;"></div>
                        </div>
                        <div class="stats-desc"><a href="{!! route('property.index') !!}" class="text-white">View Occupied</a></div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-4 col-xxl-4 col-lg-12 col-md-12">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Quick Links</h4>
                     </div>
                     <div class="panel-body">
                        <div id="DZ_W_TimeLine1" class="widget-timeline dz-scroll style-1" style="height:250px;">
                           <div class="row text-center">
                              <div class="col-4 pt-3 pb-3 border-right">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-users"></i></h3>
                                 <span><a href="{!! route('tenants.create') !!}">Tenant</a></span>
                              </div>
                              <div class="col-4 pt-3 pb-3 border-right">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-users-crown"></i></h3>
                                 <span><a href="{!! route('landlord.create') !!}">Owner</a></span>
                              </div>
                              <div class="col-4 pt-3 pb-3">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-building"></i> </h3>
                                 <span><a href="{!! route('property.index') !!}">Property</a></span>
                              </div>
                              <div class="col-12"><hr></div>
                              <div class="col-4 pt-3 pb-3 border-right">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-bullhorn"></i> </h3>
                                 <span><a href="{!! route('property.lisitng') !!}">Marketing</a></span>
                              </div>
                              <div class="col-4 pt-3 pb-3 border-right">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-users-cog"></i></h3>
                                 <span>Supplier</span>
                              </div>
                              <div class="col-4 pt-3 pb-3">
                                 <h3 class="mb-1 text-primary text-center"><i class="fal fa-tools"></i></h3>
                                 <span>Work order</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Current Leads</h4>
                     </div>
                     <div class="panel-body">
                        <div class="table-responsive">
                           <table class="table table-responsive-sm mb-0">
                              <thead>
                                 <tr>
                                    <th width="1%">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Listing</th>
                                    <th>Date</th>
                                    <th width="13%">Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($inquiries as $inquiry)
                                    <tr>
                                       <td>{!! $count++ !!}</td>
                                       <td>{!! $inquiry->names !!}</td>
                                       <td>{!! $inquiry->mail_from !!}</td>
                                       <td>{!! $inquiry->phone_number !!}</td>
                                       <td>
                                          @if($inquiry->listingID != "")
                                             {!! Property::listing($inquiry->listingID)->title !!}
                                          @endif
                                       </td>
                                       <td>{!! date('M jS, Y', strtotime($inquiry->created_at)) !!}</td>
                                       <td>
                                          <a href="" class="btn btn-success" data-toggle="modal" data-target="#inquirty{!! $inquiry->id !!}">View</a>
                                       </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="inquirty{!! $inquiry->id !!}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="exampleModalLabel">Inquiry Message</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             {!! $inquiry->message !!}
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          </div>
                                       </div>
                                       </div>
                                    </div>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>

               {{-- <div class="col-xl-6 col-xxl-6 col-lg-12 col-md-12">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Maintenance  Requests</h4>
                     </div>
                     <div class="panel-body">
                        <div class="table-responsive">
                           <table class="table table-responsive-sm mb-0">
                              <thead>
                                 <tr>
                                    <th width="1%">#</th>
                                    <th>Lease</th>
                                    <th>Tenant</th>
                                    <th>Property</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td>1</td>
                                    <td><b>qeqwejsa</b></td>
                                    <td>Dr. Jackson</td>
                                    <td>Property</td>
                                    <td>01 August 2020</td>
                                    <td>
                                       <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div> --}}
               {{-- <div class="col-xl-6 col-xxl-8 col-lg-12 col-md-12">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title">Leases expires in 0-30 days</h4>
                     </div>
                     <div class="panel-body">
                        <div class="table-responsive">
                           <table class="table table-responsive-sm mb-0">
                              <thead>
                                 <tr>
                                    <th width="1%">#</th>
                                    <th>Lease.</th>
                                    <th>Tenant</th>
                                    <th>Property</th>
                                    <th>Unit</th>
                                    <th>Expire date</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td>1</td>
                                    <td><b>qeqwejsa</b></td>
                                    <td>Dr. Jackson</td>
                                    <td>Property</td>
                                    <td>Property</td>
                                    <td>01 August 2020</td>
                                    <td>
                                       <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div> --}}
            </div>
         </div>
      </div>
   </div>
@endsection
