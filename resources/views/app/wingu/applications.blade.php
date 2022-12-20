@extends('layouts.app')
@section('title','winguPlus Applications')
@section('stylesheet')
   <link rel="stylesheet" href="{!! asset('assets/css/dashboard.css') !!}" />
@endsection
@section('content')
   <div class="container">
      <div class="py-5 text-center">
         <h2 class="text-center">Select the perfect applications for your business.<br><span class="text-pink font-weight-bold"> Free Trial</span></h2>
      </div>    
      <div class="row">
         <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
               <span class="text-muted">Selected Applications</span>
               <span class="badge badge-pink badge-pill">{!!  number_format($cart->sum('qty')) !!}</span>
            </h4>
            <form action="{!! route('application.install') !!}" method="post">
               @csrf
               <ul class="list-group mb-3">
                  @foreach($cart as $item)
                     <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                           <h6 class="my-0">{!! $item->module_name !!}</h6>
                           <small class="text-muted"><i>{!! $item->description !!}</i></small><br>
                           <a href="{!! route('application.remove.cart',$item->id) !!}" class="delete"><span class="badge badge-danger">Remove</span></a>
                        </div>
                        <span class="text-muted">${!! $item->price !!}/Mo</span>
                     </li>
                  @endforeach                  
                  {{-- <li class="list-group-item d-flex justify-content-between bg-light">
                     <div class="text-success">
                        <h6 class="my-0">Promo code</h6>
                        <small>EXAMPLECODE</small>
                     </div>
                     <span class="text-success">-$5</span>
                  </li> --}}
                  <li class="list-group-item d-flex justify-content-between">
                     <span>Amount (USD)</span>
                     <strong>${!!  number_format($cart->sum('total_amount')) !!}/Mo</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                     <span class="text-pink">Trial Discount (USD)</span>
                     <strong class="text-pink">${!!  number_format($cart->sum('total_amount')) !!}/Mo</strong>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                     <span>Total (USD)</span>
                     <strong>$0/Mo</strong>
                  </li>
               </ul>      
               {{-- <div class="card p-2">
                  <div class="input-group">
                     <input type="text" class="form-control" placeholder="Promo code">
                     <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
                     </div>
                  </div>
               </div> --}}
               <div class="card">
                  <div class="card-body">
                     <button class="btn btn-primary btn-lg btn-block mt-2 submit" type="submit">Install Applications</button>
                     <center><img src="{!! asset('assets/img/btn-loader.gif') !!}" class="submit-load none" alt="" width="45%"></center>
                  </div>
               </div>               
            </form>
         </div>
         <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Applications</h4>
            <div class="row">
               @foreach($applications as $app)
                  @if($app->id != 9)
                     @if($app->status == 15 || $app->status == 24)
                        @if(Wingu::check_business_modules($app->id) == 0)
                           <div class="col-md-4">
                              <div class="card">
                                 <div class="card-body text-center">
                                    {!! $app->icon !!}
                                    <p class="mt-1">{!! $app->name !!}</p>         
                                 </div>
                                 <div class="card-footer">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <h4 class="font-weight-bold text-pink">${!! number_format($app->price) !!}/Mo</h4>
                                       </div>
                                       <div class="col-md-6">
                                          @if($app->status == 15)
                                             <a href="{!! route('application.add.cart',$app->id) !!}" class="btn btn-sm btn-success float-right"><i class="fal fa-plus-circle"></i></a>
                                          @endif
                                          @if($app->status == 24)
                                             <a href="" class="badge badge-warning mt-1 float-right">Comming Soon!</a>
                                          @endif
                                       </div>                            
                                    </div>                          
                                 </div>
                              </div>
                           </div>
                        @endif
                     @endif
                  @endif
               @endforeach
            </div>           
         </div>
      </div>
   </div>
@endsection