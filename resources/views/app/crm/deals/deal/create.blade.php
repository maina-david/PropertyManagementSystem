@extends('layouts.app')
{{-- page header --}}
@section('title','Create Deals')

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.crm.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="{!! route('crm.dashboard') !!}">CRM</a></li>
         <li class="breadcrumb-item"><a href="{!! route('crm.deals.create') !!}">Deals</a></li>
         <li class="breadcrumb-item active">Create</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-bullseye"></i> Create a deals</h1>
      @include('partials._messages')
      <div class="row">
         <div class="col-md-8">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">Create a deal</h4>
               </div>
               <div class="panel-body">
                  <form action="{!! route('crm.deals.store') !!}" method="POST" autocomplete="off">
                     @csrf
                     <div class="form-group form-group-default required">
                        <label for="" class="text-danger">Title</label>
                        {!! Form::text('title',null,['class' => 'form-control', 'required' => '', 'placeholder' => 'Enter title']) !!}
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Deal Value</label>
                              {!! Form::number('value',null,['class' => 'form-control', 'step' => '0.01', 'placeholder' => 'Enter deal value']) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Expected close date</label>
                              {!! Form::text('close_date',null,['class' => 'form-control datepicker', 'placeholder' => 'Choose date']) !!}
                           </div>
                        </div> 
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Pipeline</label> 
                              {!! Form::select('pipeline',$pipelines,null,['class' => 'form-control multiselect','id'=>'pipeline']) !!}
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Pipeline Stage</label>
                              <select name="stage" id="stages" class="form-control multiselect">

                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">Sales owner</label>
                              {!! Form::select('owner',$employees,null,['class' => 'form-control multiselect']) !!}
                           </div> 
                        </div> 
                        <div class="col-md-6">
                           <div class="form-group form-group-default">
                              <label for="">
                                 Related Customer 
                                 <span class="pull-right" data-toggle="tooltip" data-placement="top" title="This list includes leads, You can link deals to leads">
                                    <i class="fas fa-info-circle"></i>
                                 </span>
                              </label>
                              {!! Form::select('contact',$customers,null,['class' => 'form-control multiselect']) !!}
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="">Description </label>
                              {!! Form::textarea('description',null,['class' => 'form-control ckeditor']) !!}
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Deal</button>
			               <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="10%">
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="col-md-4">

         </div>
      </div>     
   </div>
@endsection
{{-- page scripts --}}
@section('scripts')
   <script type="text/javascript">
      $('#pipeline').on('change',function(e){         
         console.log(e);
         var pipeline =  e.target.value;
         var url = "{{ url('/') }}"
         //ajax
         $.get(url+'/crm/deals/'+pipeline+'/stages', function(data){
            //success data
            //
            $('#stages').empty();
            $.each(data, function(stages, stage){
               $('#stages').append('<option value="'+ stage.id +'">'+stage.title+'</option>');
            });
         });
      });
   </script>
   <script src="{!! asset('assets/plugins/ckeditor/4/standard/ckeditor.js') !!}"></script>
   <script type="text/javascript">
      CKEDITOR.replaceClass="ckeditor";
   </script>
@endsection
