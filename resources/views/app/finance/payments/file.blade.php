@extends('layouts.app')
{{-- page header --}}
@section('title','Update Payments')
{{-- page styles --}}
@section('stylesheet')
	<link rel="stylesheet" href="{!! asset('assets/resources/assets/css/custome-form.css') !!}" />
@endsection

{{-- dashboad menu --}}
@section('main-menu')
	@include('app.finance.partials._main_menu')
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
                  <li><a href="{{ url('home') }}">Expence</a></li>
                  <li>
                        <span>Paymnets Received</span>
                  </li>
                  <li class="active">
                        <span>Update Paymnets</span>
                  </li>
               </ol>
            </div>
            <h2 class="font-light m-b-xs">
               Update Payments Received
            </h2>
            <small>Update Payments Received</small>
         </div>
      </div>
    </div>
	<div class="content">
      <a class="btn btn-info" href="{!! url('finance/payments/'.$paymentid.'/edit') !!}"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Payments</a><br><br>
      <div class="row">
         {{-- menu --}}
         @include('Limitless.Finance.partials.gallery-menu')
         {{-- media --}}
         <div class="col-md-9">
               <div class="row">
                  @foreach($files as $file)
                     <div class="col-md-3">
                           @if( strpos($file->file_mime, 'image') !== false)
                              <div class="hpanel">
                                 <img src="{!! asset($file->file_path) !!}" alt="" width="100%" style="height:118px">
                                 <div class="panel-footer">
                                       <span class="label label-info" style="margin-right:2px;">
                                          {{-- <a href="" data-toggle="modal" data-target="#file-details" class="file-details" data-value="{{ $file->id }}"><i class="fa fa-eye white"></i></a> --}}
                                 <a href="" data-toggle="modal" data-target="#file-details" class="file-details" onclick="fun_edit('{{$file->id}}')"><i class="fa fa-eye white"></i></a>
                                       </span>
                                       <span class="label label-danger">
                                             <a href="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o white"></i></a>
                                       </span>
                                       <a href="#" class="pull-right">{!! $file->caption !!}</a>
                                 </div>
                              </div>
                           @endif
                           @if($file->file_mime == "application/pdf")
                              <div class="hpanel">
                                 <div class="panel-body file-body">
                                       <i class="fa fa-file-pdf-o text-info"></i>
                                 </div>
                                 <div class="panel-footer">
                                       <span class="label label-info" style="margin-right:2px;">
                                             <a href="" data-toggle="modal" data-target="#file-details"><i class="fa fa-eye white"></i></a>
                                       </span>
                                       <span class="label label-danger">
                                             <a href="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o white"></i></a>
                                       </span>
                                       <a href="#" class="pull-right">{!! $file->caption !!}</a>
                                 </div>
                              </div>
                           @endif
                           @if($file->file_mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
                              <div class="hpanel">
                                 <div class="panel-body file-body">
                                       <i class="fa  fa-file-word-o text-primary"></i>
                                 </div>
                                 <div class="panel-footer">
                                       <span class="label label-info" style="margin-right:2px;">
                                             <a href="" data-toggle="modal" data-target="#file-details"><i class="fa fa-eye white"></i></a>
                                       </span>
                                       <span class="label label-danger">
                                             <a href="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o white"></i></a>
                                       </span>
                                       <a href="#" class="pull-right">{!! $file->caption !!}</a>
                                 </div>
                              </div>
                           @endif
                           @if($file->file_mime == "application/octet-stream")
                              <div class="hpanel">
                                 <div class="panel-body file-body">
                                       <i class="fa  fa-file-code-o text-success"></i>
                                 </div>
                                 <div class="panel-footer">
                                       <span class="label label-info" style="margin-right:2px;">
                                             <a href="" data-toggle="modal" data-target="#file-details"><i class="fa fa-eye white"></i></a>
                                       </span>
                                       <span class="label label-danger">
                                             <a href="" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o white"></i></a>
                                       </span>
                                       <a href="#" class="pull-right">{!! $file->caption !!}</a>
                                 </div>
                              </div>
                           @endif
                     </div>
                  @endforeach
               <input type="hidden" name="hidden_view" id="hidden_view" value="{{url('fileview')}}">
               {{-- <input type="hidden" name="hidden_delete" id="hidden_delete" value="{{url('crud/delete')}}"> --}}
               </div>
         </div>
      </div>
   </div>
	<br>
	<div id="upload_media" class="modal fade" role="dialog">
	  	<div class="modal-dialog modal-lg">
	    	<!-- Modal content-->
		    <div class="modal-content">
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Upload Files</h4>
		      	</div>
		      	<div class="modal-body">
		        	{!! Form::open(array('url' => 'finance/paymentsfile/store','class'=>'dropzone','id'=>'my-awesome-dropzone','action' => 'post')) !!}
		        		<input type="hidden" name="parentid" value="{!! $paymentid !!}">
					{!! Form::close() !!}
		      	</div>
		      	<div class="modal-footer">
		       		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		       		<button type="button" class="btn btn-success" onClick="window.location.href=window.location.href">Save</button>
		      	</div>
		    </div>
	  	</div>
	</div>
    {{-- <div id="file-details" class="modal fade"  role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="color-line"></div>
                <div class="modal-header">
                    <h4 class="modal-title file-title"></h4>
                    <small class="font-bold">Lorem Ipsum is simply dummy text.</small>
                </div>
                <div class="modal-body clearfix">
					<div class="col-md-7">
						<center><img src="http://localhost/LimitlessERP2/resources/Limitless/media/payment/RAYFDQwordpress.jpg" alt="" class="image"></center>
					</div>
					<div class="col-md-5">
						<form action="" method="post">
							{!! csrf_token(); !!}
						  	<fieldset class="form-group">
							    <label for="exampleInputEmail1">Image Title</label>
								<input type="text" class="form-control" id="caption" name="caption">
						  	</fieldset>
						  	<fieldset class="form-group">
							    <label for="exampleInputPassword1">File Path</label>
							    <input type="text" class="form-control" id="file_path" name="file_path">
								<p class="green">Image Link:</p>
								<b><span>{!! url('/') !!} <span id="link">fgghjgh</span></span></b>
						  	</fieldset>
							<fieldset class="form-group">
							    <label for="exampleSelect1">Folder</label>
							    <select class="form-control" id="exampleSelect1">
								    <option>1</option>
								    <option>2</option>
								    <option>3</option>
								    <option>4</option>
								    <option>5</option>
							    </select>
							</fieldset>
							<div class="checkbox">
	  						    <label>
	  						      	<input type="checkbox" class="visibility"> <b>Public Visibility</b>
	  						    </label>
	  						</div>
							<input type="hidden" id="edit_id" name="edit_id">
						  	<button type="submit" class="btn btn-info">Update File</button>
						</form>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
{{-- page scripts --}}
@section('script')
	<script type="text/javascript">
		var view_url = $("#hidden_view").val();
		function fun_edit(id){
	      	var view_url = $("#hidden_view").val();
		      	$.ajax({
		        url: view_url,
		        type:"GET",
		        data: {"id":id},
		        success: function(result){
			        //console.log(result);
			        $("#edit_id").val(result.id);
			        $("#caption").val(result.caption);
			        $("#file_path").val(result.file_path);
			        $("#edit_email").val(result.email);
					$("#link").text(result.file_path);
					$("#image").src(result.file_path);
		        }
	      	});
	    }
    </script>
@endsection
