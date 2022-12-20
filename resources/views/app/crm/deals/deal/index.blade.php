@extends('layouts.app')
{{-- page header --}}
@section('title','Deals')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <div class="float-right">
         <a href="{!! route('crm.deals.create') !!}" class="btn btn-pink"><i class="fas fa-bullseye"></i> Add Deal</a>
      </div>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-bullseye"></i> Deals</h1>
      @include('partials._messages')
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">Deals List</h4>
         </div>
         <div class="panel-body">
            <table id="data-table-default" class="table table-striped table-bordered">
               <thead>
                  <tr role="row">
                     <th width="1%">#</th>
                     <th>Title</th>
                     <th>Value</th>
                     <th>Pipeline</th>
                     <th>Stage</th>
                     <th>Sale Owner</th>
                     <th>Closing</th>
                     <th>Status</th>
                     <th width="10%">Action</th>
                  </tr>
               </thead>
               <tfoot>
                  <th width="1%">#</th>
                  <th>Title</th>
                  <th>Value</th>
                  <th>Pipeline</th>
                  <th>Stage</th>
                  <th>Sale Owner</th>
                  <th>Closing</th>
                  <th>Status</th>
                  <th width="10%">Action</th>
               </tfoot>
               <tbody>
                  @foreach($deals as $deal)
                     <tr>
                        <td>{!! $count++ !!}</td>
                        <td>{!! $deal->title !!}</td>
                        <td>{!! $deal->code !!} {!! number_format($deal->value) !!}</td>
                        <td>
                           <span class="badge badge-warning">
                              @if(Crm::check_pipeline($deal->pipeline) != 0)  
                                 {!! Crm::pipeline($deal->pipeline)->title !!}
                              @endif
                           </span>
                        </td>
                        <td>
                           <span class="badge badge-primary">
                              @if(Crm::check_pipeline_stage($deal->stage) != 0)  
                                 {!! Crm::pipeline_stage($deal->stage)->title !!}
                              @endif
                           </span>
                        </td>
                        <td>
                           @if(Hr::check_employee($deal->owner) != 0)
                              {!! Hr::employee($deal->owner)->names !!}
                           @endif
                        </td>
                        <td>
                           @if($deal->close_date != "")
                              {!! date('F jS Y', strtotime($deal->close_date)) !!}
                           @endif
                        </td>
                        <td>{!! $deal->status !!}</td>
                        <td>
                           <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-pink btn-sm dropdown-toggle" aria-expanded="true">Choose Action</button>
                              <ul class="dropdown-menu">
                                 <li><a href="{!! route('crm.deals.show',$deal->dealID) !!}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                 <li><a href="{!! route('crm.deals.edit',$deal->dealID) !!}"><i class="fad fa-edit"></i> Edit</a></li>
                                 <li><a href="{!! route('crm.deals.delete',$deal->dealID) !!}" class="delete"><i class="fad fa-trash"></i> Delete</a></li>                                 
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
