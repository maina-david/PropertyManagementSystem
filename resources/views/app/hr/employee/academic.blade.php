@extends('layouts.app')
{{-- page header --}}
@section('title','Academic Information')
@section('sidebar')
	@include('app.hr.partials._menu')
@endsection

{{-- content section --}}
@section('content')
	<div id="content" class="content">
		<!-- begin breadcrumb -->
		<ol class="breadcrumb pull-right">
			<li class="breadcrumb-item"><a href="javascript:;">Human Resource</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Employee</a></li>
			<li class="breadcrumb-item active">Update</li>
		</ol>
		<!-- end breadcrumb -->
		<!-- begin page-header -->
		<h1 class="page-header">Academic Information</h1>
		<!-- end page-header -->
		<div class="row">
			<!-- employee side -->
			@include('app.hr.partials._hr_employee_menu')
			<div class="col-md-9">
				@include('partials._messages')
            <!-- end of shop menu -->
            {!! Form::model($edit, ['route' => ['hrm.employeeacademicinformation.update',$edit->empid], 'method'=>'post','data-parsley-validate' => '','enctype'=>'multipart/form-data']) !!}
               {{ csrf_field() }}
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <div class="panel-title"><span class="green">{!! $employee->names !!}</span> - Academic training Information</div>
                  </div>
                  <div class="panel-body">
                     <div class="row">
                        <div class="col-sm-6">
                           <p><b>Primary Education</b></p>
                           <div class="form-group form-group-default required">
                              {!! Form::label('pri_school_name', 'Primary School', array('class'=>'control-label')) !!}
                              {!! Form::text('pri_school_name', null, array('class' => 'form-control', 'placeholder' => 'Enter primary school')) !!}
                           </div>
                           <div class="form-group form-group-default required">
                              {!! Form::label('pri_year_of_study', 'Primary Year of study', array('class'=>'control-label')) !!}
                              {!! Form::text('pri_year_of_study', null, array('class' => 'form-control', 'placeholder' => 'Primary Year of study')) !!}
                           </div>
                           <div class="form-group form-group-default required">
                              {!! Form::label('pri_results', 'KCPE Result/Grade', array('class'=>'control-label')) !!}
                              {!! Form::text('pri_results', null, array('class' => 'form-control', 'placeholder' => 'KCPE Result/Grade')) !!}
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <p><b>Secondary Education</b></p>
                           <div class="form-group form-group-default">
                              {!! Form::label('sec_school_name', 'Secondary School', array('class'=>'control-label')) !!}
                              {!! Form::text('sec_school_name', null, array('class' => 'form-control', 'placeholder' => 'Secondary School')) !!}
                           </div>
                           <div class="form-group form-group-default">
                              {!! Form::label('sec_year_of_study', 'Secondary Year of study', array('class'=>'control-label')) !!}
                              {!! Form::text('sec_year_of_study', null, array('class' => 'form-control', 'placeholder' => 'Secondary Year of study')) !!}
                           </div>
                           <div class="form-group form-group-default">
                              {!! Form::label('sec_results', 'KCSE Result/Grade', array('class'=>'control-label')) !!}
                              {!! Form::text('sec_results', null, array('class' => 'form-control', 'placeholder' => 'KCSE Result/Grade')) !!}
                           </div>
                        </div>
                     </div> 
                     <div class="form-group"><br>
                        <center>
                           <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Update Information</button>
									<img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                        </center>
                     </div>
                  </div>
               </div>
            {!! Form::close() !!}
            <div class="panel panel-default">
               <div class="panel-heading">
                  <div class="panel-title">University/Collage/Institution</div>
                  <div class="panel-body">
                     <div class="row">
                        <table class="table table-bordered">
                           <tr>
                              <th>#</th>
                              <th>School Name</th>
                              <th>Degree/Diploma/Cert/PHD</th>
                              <th>Field(s) of Study</th>
                              <th>Result</th>
                              <th>Year of Study</th>
                              <th>Date of Completion</th>
                              <th>Action</th>
                           </tr>
                           @foreach($institution as $inst)
                           <tr>
                              <td>{!! $count++ !!}</td>
                              <td>{!! $inst->school_name !!}</td>
                              <td>{!! $inst->result_type !!}</td>
                              <td>{!! $inst->field_of_study !!}</td>
                              <td>{!! $inst->results !!}</td>
                              <td>{!! $inst->year_of_study !!}</td>
                              <td>{!! $inst->year_of_completion !!}</td>
                              <td colspan="" rowspan="" headers="">
                                 <div class="btn-group sm-m-t-10">
                                    {{-- <a  data-toggle='modal' data-target="#myModal" class="btn btn-info"><i class="fas fa-edit"></i></a> --}}
                                    <a class="btn btn-danger delete" href="{{ route('hrm.institution.delete',$inst->id) }}"><i class="fas fa-trash"></i>
                                    </a>
                                 </div>
                              </td>
                           </tr>
                           <!-- Modal -->
                           <div id="myModal" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                 <!-- Modal content-->
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                                       <p><b>Secondary Education</b></p>
                                    </div>
                                    <div class="modal-body">
                                       <form action="#" method="get" accept-charset="utf-8">
                                          <div class="col-sm-12">
                                             <div class="form-group form-group-default">
                                                {!! Form::label('Institution name', 'Institution name', array('class'=>'control-label')) !!}
                                                {!! Form::text('institution_name', null, array('class' => 'form-control', 'placeholder' => 'Institution name')) !!}
                                             </div>
                                             <div class="form-group form-group-default">
                                                {!! Form::label('Degree/Diploma/Cert/PHD', 'Degree/Diploma/Cert/PHD', array('class'=>'control-label')) !!}
                                                {!! Form::text('result_type', null, array('class' => 'form-control', 'placeholder' => 'Degree/Diploma/Cert/PHD')) !!}
                                             </div>
                                             <div class="form-group form-group-default">
                                                {!! Form::label('Field(s) of Study', 'Field(s) of Study', array('class'=>'control-label')) !!}
                                                {!! Form::text('field_of_study', null, array('class' => 'form-control', 'placeholder' => 'Field(s) of Study')) !!}
                                             </div>
                                             <div class="form-group form-group-default">
                                                {!! Form::label('Result', 'Result', array('class'=>'control-label')) !!}
                                                {!! Form::text('results', null, array('class' => 'form-control', 'placeholder' => 'Result')) !!}
                                             </div>
                                             <div class="form-group form-group-default">
                                                {!! Form::label('Year of Study', 'Year of Study', array('class'=>'control-label')) !!}
                                                {!! Form::text('year_of_study', null, array('class' => 'form-control', 'placeholder' => 'Year of Study')) !!}
                                             </div>
                                             <div class="form-group form-group-default">
                                                {!! Form::label('Date of Completion', 'Date of Completion', array('class'=>'control-label')) !!}
                                                {!! Form::text('year_of_completion', null, array('class' => 'form-control', 'placeholder' => 'Date of Completion')) !!}
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-success" data-dismiss="modal">Submit</button>
                                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @endforeach
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <div class="panel-title">Add University/Collage/Institution</div>
                  {!! Form::open(array('route' => 'hrm.institutioninformation.post','enctype'=>'multipart/form-data', 'method'=>'post')) !!}
                     <div class="panel-body">
                        <div class="row">
                           {{ csrf_field() }}
                           <table class="table table-bordered tplus">
                              <tr>
                                 <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                 <th>#</th>
                                 <th>School Name</th>
                                 <th>Degree/Diploma/Cert/PHD</th>
                                 <th>Field(s) of Study</th>
                                 <th>Result</th>
                                 <th>Year of Study</th>
                                 <th>Date of Completion</th>
                              </tr>
                              <tr>
                                 <td><input type='checkbox' class='case'/></td>
                                 <td><span id='snum'>1.</span></td>
                                 <td><input class="form-control" type='text' id='institution_name' name='institution_name[]' required=""></td>
                                 <td><input class="form-control" type='text' id='dip_degere' name='dip_degere[]' required=""></td>
                                 <td><input class="form-control" type='text' id='uni_field' name='uni_field[]' required=""></td>
                                 <td><input class="form-control" type='text' id='uni_result' name='uni_result[]' required=""></td>
                                 <td><input class="form-control" type='text' id='uni_date' name='uni_date[]' required=""> </td>
                                 <td><input class="form-control" type='date' id='date_of_competion' name='date_of_competion[]' required=""></td>
                                 <td style='display:none'><input class="form-control" type='text' id='employee_id' name='employeeID[]' value='{!! $employee->id !!}' required=""></td>
                              </tr>
                           </table>
                           <button type="button" class='btn btn-danger delete'>- Delete</button>
                           <button type="button" class='btn btn-success addmore'>+ Add More</button>
                        </div>
                        <div class="form-group">
                           <center>
                              <button type="submit" class="btn btn-pink submit"><i class="fas fa-save"></i> Add Institution</button>
                              <img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="15%">
                           </center>
                        </div>
                     </div>
                  {!! Form::close() !!}
               </div>
            </div>
			</div>
		</div>
	</div>

@endsection
{{-- page scripts --}}
@section('scripts')
	<script>
      $(".delete").on('click', function() {
         $('.case:checkbox:checked').parents("tr").remove();
         $('.check_all').prop("checked", false);
         check();
      });
      var i=$('.tplus tr').length;
      $(".addmore").on('click',function(){
         count=$('.tplus tr').length;
         var data="<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
         data +="<td><input class='form-control' type='text' id='institution_name_"+i+"' name='institution_name[]'/></td><td><input class='form-control' type='text' id='dip_degere_"+i+"' name='dip_degere[]'/></td><td><input class='form-control' type='text' id='uni_field_"+i+"' name='uni_field[]'/></td><td><input class='form-control' type='text' id='uni_result' name='uni_result[]' ></td><td><input class='form-control' type='text' id='uni_date_"+i+"' name='uni_date[]'/></td><td><input class='form-control' type='date' id='date_of_competion' name='date_of_competion[]'></td><td style='display:none'><input class='form-control' type='text' id='employee_id' name='employeeID[]' value='{!! $employee->id !!}'></td></tr>";
         $('.tplus').append(data);
      });
   </script>
@endsection
