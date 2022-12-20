@extends('layouts.app')
@section('title') {!! $property->title !!} | Images @endsection
@section('sidebar')
	@include('app.property.partials._menu')  
@endsection 
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:void(0)">Property</a></li>
         <li class="breadcrumb-item active"><a href="javascript:void(0)">Images</a></li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fal fa-home"></i>  {!! $property->title !!} | Images</h1>
      <div class="row">
         @include('app.property.partials._property_menu')
         <div class="col-md-12">
            <div class="row row-space-10 m-b-20">
               <div class="col-md-12 mb-3">
                  <a href="" class="btn btn-warning" data-toggle="modal" data-target="#addImage"><i class="fal fa-images"></i> Add Images</a>
               </div>
               @foreach ($images as $image)
                  <div class="col-md-4">
                     <div class="card">
                        <div class="card-body">
                           <img src="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/images/'.$image->file_name) !!}" alt="" class="img-responsive">
                        </div>
                        <div class="card-footer">
                           <div class="row">
                              <div class="col-md-12">
                                 <h5 class="title">{!! $image->name !!}</h5>
                                 <a class="float-right btn-danger btn btn-sm delete" href="{!! route('property.images.delete',[$property->id,$image->id]) !!}">Delete</a>
                              </div>
                           </div>
                        </div>
                     </div>      
                  </div>                     
               @endforeach
            </div>
         </div>
         <!-- Modal -->
         <div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Upload Images</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="{!! route('property.images.upload',$property->id) !!}" class="dropzone" id="my-awesome-dropzone" method="post">
                     @csrf()
                     <input type="hidden" value="{!! $property->id !!}" name="propertyID">
                  </form>
               </div>
               <div class="modal-footer">
                  <a onClick="window.location.reload()" href="#" class="btn btn-success" onClick="refreshPage()">Save Images</a>
               </div>
            </div>
            </div>
         </div>
      </div>
   </div>
@endsection