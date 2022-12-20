@extends('layouts.app')
{{-- page header --}}
@section('title','Currency Settings')
{{-- page styles --}}
@section('stylesheet')

@endsection

{{-- dashboad menu --}}
@section('sidebar')
	@include('app.finance.partials._menu')
@endsection

{{-- content section --}}
@section('content')
   <div id="content" class="content">
		<!-- begin breadcrumb -->
      <ol class="breadcrumb pull-right">
         <li class="breadcrumb-item"><a href="javascript:;">Finance</a></li>
         <li class="breadcrumb-item"><a href="#">Settings</a></li>
         <li class="breadcrumb-item active">Currency</li>
      </ol>
      <!-- end breadcrumb -->
      <!-- begin page-header -->
      <h1 class="page-header"><i class="fas fa-money-bill-wave"></i> Currency Settings</h1>
      @include('backend.partials._messages')
      <div class="row">
         @include('app.finance.settings._nav')
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        {{-- <a href="#add-currency" class="btn btn-primary mb-3" data-toggle="modal"><i class="fas fa-plus"></i> New Currency</a> --}}
                        <table id="data-table-default" class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Name</th>
                                 <th>Code</th>
                                 <th>symbol</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </thead>
                           <tfoot>
                              <tr>
                                 <th width="1%">#</th>
                                 <th>Name</th>
                                 <th>Code</th>
                                 <th>symbol</th>
                                 <th width="20%">Action</th>
                              </tr>
                           </tfoot>
                           <tbody>
                              @foreach ($currencies as $currency)
                                 <tr>
                                    <td>{!! $count++ !!}</td>
                                    <td>{!! $currency->currency_name !!}</td>
                                    <td>{!! $currency->code !!}</td>
                                    <td>{!! $currency->symbol !!}</td>
                                    <td>
                                       <a href="#modal-dialog{!! $currency->id !!}" class="btn btn-sm btn-primary" data-toggle="modal"><i class="fas fa-edit"></i> Edit</a>
                                       <a href="{!! route('finance.settings.currency.delete', $currency->id) !!}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a></td>
                                 </tr>
                                    <!-- #modal-dialog -->
                                    <div class="modal fade" id="modal-dialog{!! $currency->id !!}">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <h4 class="modal-title">Update Currency</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                             </div>
                                             <div class="modal-body">
                                                {!! Form::model($currency, ['route' => ['finance.settings.currency.update',$currency->id], 'method'=>'post',]) !!}
                                                   {!! csrf_field() !!}
                                                   <div class="form-group">
                                                      <label for="">Currency Name</label>
                                                      {!! Form::text('currency_name', null, array('class' => 'form-control', 'required' => '')) !!}
                                                   </div>
                                                   <div class="form-group">
                                                      <label for="">Currency Code</label>
                                                      {!! Form::text('code', null, array('class' => 'form-control', 'required' => '')) !!}
                                                   </div>
                                                   <div class="form-group">
                                                      <label for="">Currency Symbol</label>
                                                      {!! Form::text('symbol', null, array('class' => 'form-control', 'required' => '')) !!}
                                                   </div>
                                                   <div class="form-group">
                                                      <center><button type="submit" class="btn btn-primary submit">Update Currency</button></center>
                                                   </div>
                                                {!! Form::close() !!}
                                             </div>
                                             <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Close</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- #modal-without-animation -->
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="add-currency">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Update Status</h4>
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
               <form action="{!! route('finance.settings.currency.store') !!}" method="POST">
                  @csrf
                  <div class="form-group">
                     <label for="">Currency Name</label>
                     <input type="text" class="form-control" name="currency_name" required>
                  </div>
                  <div class="form-group">
                     <label for="">Currency Code</label>
                     <input type="text" class="form-control" name="code" required>
                  </div>
                  <div class="form-group">
                     <label for="">Currency Symbol</label>
                     <input type="text" class="form-control" name="symbol" required>
                  </div>
                  <div class="form-group">
                     <center><button type="submit" class="btn btn-primary submit">Submit</button>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>
               <a href="javascript:;" class="btn btn-success">Action</a>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('scripts')

@endsection
