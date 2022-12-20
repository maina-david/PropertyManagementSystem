@extends('layouts.app') 
{{-- page header --}} 
@section('title')Vacant units | {!! $property->title !!} @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('property.index') !!}">Property</a></li>
         <li class="breadcrumb-item"><a href="{!! route('property.units',$property->id) !!}">Units</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Vacant</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-building"></i> {!! $property->title !!} | Vacant Units</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Vacant units</h4>
               </div>
               <div class="panel-body">
                  <table id="data-table-default" class="table table-striped table-bordered table-hover">
                     <thead> 
                        <tr>
                           <th width="1%">#</th>
                           <th class="text-nowrap">UnitID</th>
                           <th class="text-nowrap">Unit Type</th>
                           <th class="text-nowrap">Rent (p/Mo)</th>
                           <th class="text-nowrap">Ownership Type</th>
                           <th class="text-nowrap"  width="8%">Status</th>
                           <th class="text-nowrap" width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($units as $unit)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td><b>{!! $unit->serial !!}</b></td>
                              <td> 
                                 @if($unit->property_type != "")
                                    {!! Property::property_type($unit->property_type)->name !!}
                                 @endif
                              </td>
                              <td><b>{!! $business->code !!}{!! number_format($unit->price) !!}</b></td>
                              <td>{!! $unit->ownwership_type !!}</td>
                              <td>
                                 @if($unit->listing_status == 49)
                                    <button class="btn btn-sm btn-success"><i class="fal fa-check-circle"></i> Listed</button>
                                 @else 
                                    <a href="{!! route('list.property',$unit->propID) !!}" class="btn btn-sm btn-warning"><i class="fal fa-cloud-upload-alt"></i> List</a>
                                 @endif
                              </td>
                              <td>
                                 <a href="{!! route('property.units.edit',[$property->id,$unit->propID]) !!}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                 <a href="{!! route('property.units.delete', [$unit->parentID,$unit->propID]) !!}" class="btn btn-danger delete"><i class="far fa-trash"></i></a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
