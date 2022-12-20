<a href="#add-document" class="btn btn-pink  mb-3" data-toggle="modal"><i class="fas fa-file-upload"></i> Add Document</a>
<div class="row">
   @foreach ($documents as $document)
      <div class="col-md-4">
         <!-- begin widget-list -->
         <div class="widget-list widget-list-rounded mb-2">
            <!-- begin widget-list-item -->
            <div class="widget-list-item">
               <div class="widget-list-media">
                  @if(Helper::like_match('%image%',$document->file_mime))
                     <i class="fas fa-file-image fa-3x"></i>
                  @elseif(Helper::like_match('%pdf%',$document->file_mime))
                     <i class="fas fa-file-pdf fa-3x"></i>
                  @elseif(Helper::like_match('%word%',$document->file_mime))
                     <i class="fas fa-file-word fa-3x"></i>
                  @elseif(Helper::like_match('%zip%',$document->file_mime))
                     <i class="fas fa-file-archive fa-3x"></i>
                  @elseif(Helper::like_match('%excel%',$document->file_mime))
                     <i class="fas fa-file-excel fa-3x"></i>
                  @elseif(Helper::like_match('%powerpoint%',$document->file_mime))
                     <i class="fas fa-file-powerpoint fa-3x"></i>
                  @elseif(Helper::like_match('%application%',$document->file_mime))
                     <i class="far fa-file-code fa-3x"></i>
                  @else
                     <i class="far fa-file fa-3x"></i> 
                  @endif
               </div>
               <div class="widget-list-content">
                  <h4 class="widget-list-title font-weight-bold">{!! $document->name !!}</h4>
                  <p class="widget-list-desc mt-1">
                     <b>File Type :</b> {!! $document->file_mime !!}<br>
                     <b>File Size :</b> {!! round($document->file_size / 1000000, 2) !!} mb<br>
                     <b>Created at :</b> {!! date('F d, Y', strtotime($document->created_at)) !!}<br>
                  </p>
               </div>
               <div class="widget-list-action">
                  <a href="#" data-toggle="dropdown" class="text-muted pull-right">
                  <i class="fa fa-ellipsis-h f-s-14"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right">
                     <li><a href="#update-document-{!! $document->id !!}" data-toggle="modal">Edit</a></li>
                     {{-- <li><a href="#">Send document as email</a></li> --}}
                     <li><a href="{!! asset('businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/customer/'.$client->customer_code.'/documents/'.$document->file_name) !!}" target="_blank">View document</a></li>
                     <li><a href="{!! route('finance.customer.documents.delete',[$document->id,$customerID]) !!}" class="delete">Delete</a></li>
                  </ul>
               </div>
            </div>
            <!-- end widget-list-item -->
         </div>
         <!-- end widget-list -->
      </div>
      {{-- create events --}}
      <div class="modal fade" id="update-document-{!! $document->id !!}" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-lg">
            {!! Form::model($document, ['route' => ['finance.customer.documents.update', $document->id], 'method'=>'post', 'autocomplete'=>'off','enctype' => 'multipart/form-data']) !!}
               <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title"> Add Document</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  @csrf
                  <div class="row">
                     <div class="col-sm-6">
      						<div class="form-group form-group-default required">
      							{!! Form::label('document title', 'Document title', array('class'=>'control-label text-danger')) !!}
      							{!! Form::text('name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter title')) !!}
                           <input type="hidden" name="leadID" value="{!! $customerID !!}" required>
      						</div>
      					</div>
                     <div class="col-sm-6">
      						<div class="form-group form-group-default required">
      							{!! Form::label('document', 'Document', array('class'=>'control-label')) !!}
      							<input type="file" name="document" class="form-control">
      						</div>
      					</div>
      				</div>
                  <div class="form-group">
                     {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
                     {{ Form::textarea('description', null, ['class' => 'form-control ckeditor']) }}
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Upload</button>
                  <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
               </div>
            </div>
            {!! Form::close() !!}
         </div>
      </div>
   @endforeach
</div>
<div class="row mt-2">
   <div class="col-md-12">
      @if($documents->lastPage() > 1)
         <nav aria-label="...">
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="{{ $documents->url(1) }}">Previous</a>
               </li>
               @for ($i = 1; $i <= $documents->lastPage(); $i++)
                  <li class="page-item {{ ($documents->currentPage() == $i) ? 'active' : '' }}">
                     <a class="page-link" href="{{ $documents->url($i) }}">
                           {{ $i }}
                        <span class="sr-only">(current)</span>
                     </a>
                  </li>
               @endfor
               <li class="page-item">
                  <a class="page-link" href="{{ $documents->url($documents->currentPage()+1) }}">Next</a>
               </li>
            </ul>
         </nav>
      @endif
   </div>
</div>
{{-- create events --}}
<div class="modal fade" id="add-document" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg">
      {!! Form::open(array('route' => 'finance.customer.documents.store','method' =>'post','autocomplete'=>'off','enctype' => 'multipart/form-data')) !!}
         <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"> Add Document</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            @csrf
            <div class="row">
               <div class="col-sm-6">
						<div class="form-group form-group-default required">
							{!! Form::label('document title', 'Document title', array('class'=>'control-label text-danger')) !!}
							{!! Form::text('document_name', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter title')) !!}
                     <input type="hidden" name="leadID" value="{!! $customerID !!}" required>
						</div>
					</div>
               <div class="col-sm-6">
						<div class="form-group form-group-default">
							{!! Form::label('document', 'Document', array('class'=>'control-label')) !!}
							<input type="file" name="document" class="form-control" required>
						</div>
					</div>
				</div>
            <div class="form-group">
               {!! Form::label('Description', 'Description', array('class'=>'control-label')) !!}
               {{ Form::textarea('description', null, ['class' => 'form-control ckeditor']) }}
            </div>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Upload</button>
            <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
         </div>
      </div>
      {!! Form::close() !!}
   </div>
</div>
