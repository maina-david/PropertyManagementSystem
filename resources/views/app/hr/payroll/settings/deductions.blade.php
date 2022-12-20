@extends('layouts.app')
{{-- page header --}}
@section('title','Payroll settings')
{{-- page styles --}}

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
      <!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item">Human resource</li>
         <li class="breadcrumb-item">Payroll</li>
         <li class="breadcrumb-item active">Payroll settings</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-cog"></i> Payroll settings </h1>
      @include('partials._messages')
      <div class="row">
         @include('app.hr.payroll.settings._nav')
         <div class="col-md-9">
            <div class="card">
               <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.payroll.settings.payday') }}" href="{!! route('hrm.payroll.settings.payday') !!}">
                           Payday information
                        </a>
                     </li> --}}
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.payroll.settings.approval') }}" href="{!! route('hrm.payroll.settings.approval') !!}">
                           Approver setting
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.payroll.settings.deduction') }}" href="{!! route('hrm.payroll.settings.deduction') !!}">
                           Deductions
                        </a>
                     </li>
                     {{-- <li class="nav-item">
                        <a class="{{ Nav::isRoute('hrm.payroll.settings.benefits') }}" href="{!! route('hrm.payroll.settings.benefits') !!}">
                           Benefits
                        </a>
                     </li> --}}
                  </ul>
               </div>
               <div class="card-block">
                  <div class="row">
                     <div class="col-md-12">
                        <a href="#add-type" data-toggle="modal" class="btn btn-pink mb-2 float-right"> Add deduction</a>
                     </div>
                  </div>
                  <table id="data-table-default" class="table table-striped table-bordered">
                     <thead>
                        <tr>
                           <th width="5%">#</th>
                           <th class="text-nowrap">Name</th>
                           <th class="text-nowrap">Description</th>
                           <th class="text-nowrap" width="10%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($deductions as $deduction)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $deduction->title !!}</td>
                              <td>{!! $deduction->description !!}</td>
                              <td>
                                 {{-- <a href="#" class="btn btn-pink btn-sm edit-deduction" id="{!! $deduction->id !!}" ><i class="fas fa-edit"></i> Edit</a> --}}
                                 <a href="{!! route('hrm.payroll.settings.deduction.delete',$deduction->id) !!}" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div class="modal fade" id="add-type" tabindex="-1" role="dialog">
                     <div class="modal-dialog modal-lg">
                        {!! Form::open(array('route' => 'hrm.payroll.settings.deduction.store','method' =>'post','autocomplete'=>'off')) !!}
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h4 class="modal-title">Add deduction</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                 @csrf
                                 <div class="form-group form-group-default required">
                                    {!! Form::label('names', 'Deduction name', array('class'=>'control-label')) !!}
                                    {!! Form::text('title', null, array('class' => 'form-control', 'required' => '', 'placeholder' => 'Enter Name')) !!}
                                 </div>
                                 <div class="form-group">
                                    {!! Form::label('names', 'Description', array('class'=>'control-label')) !!}
                                    {!! Form::textarea('description', null, array('class' => 'form-control ckeditor', 'required' => '')) !!}
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add deduction</button>
                                 <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                              </div>
                           </div>
                        {!! Form::close() !!}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   {{-- <div class="modal fade" tabindex="-1" id="deduction_edit_form" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         {!! Form::open(array('route' => 'hrm.payroll.settings.deduction.update','method' =>'post','autocomplete'=>'off')) !!}
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Update deduction</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                  @csrf
                  <div class="form-group form-group-default required">
                     <input type="hidden" id="deductionID" name="deductionID">
                     {!! Form::label('names', 'Deduction name', array('class'=>'control-label')) !!}
                     {!! Form::text('title', null, array('class' => 'form-control', 'id' => 'title', 'required' => '', 'placeholder' => 'Enter Name')) !!}
                  </div>
                  <div class="form-group">
                     {!! Form::label('names', 'Description', array('class'=>'control-label')) !!}
                     {!! Form::textarea('description', null, array('class' => 'form-control ckeditor', 'id' => 'description', 'required' => '')) !!}
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update deduction</button>
                  <img src="{!! url('/') !!}/public/backend/img/btn-loader.gif" class="submit-load none" alt="" width="15%">
               </div>
            </div>
         {!! Form::close() !!}
      </div>
   </div> --}}
@endsection
@section('scripts')
   <script>
      $(document).on('click', '.edit-deduction', function(){
         var id = $(this).attr('id');
         var url = "{!! url('/') !!}"
         $('#deduction_edit_form').html();
         $.ajax({
            url:url+"/hrm/payroll/settings/deduction/"+id+"/edit",
            dataType:"json",
            success:function(html){
               $('#title').val(html.data.name);
					$('#description').val(html.data.priority);
					$('#deductionID').val(id);
               $('#deduction_edit_form').modal('show');
            }
         })
      });
   </script>
	<script src="{!! asset('assets/plugins/ckeditor/4/basic/ckeditor.js') !!}"></script>
	<script type="text/javascript">
	   CKEDITOR.replaceClass="ckeditor";
	</script>
@endsection
