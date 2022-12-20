@extends('layouts.app')
@section('title') Plans @endsection
@section('url'){!! route('home.page') !!}@endsection
@section('stylesheet')
   <style>
      .section-container{
         min-height: 350px
      }
      .section-container-plain{
         background-image: none;
      }

      .icon-shape {
         display: -webkit-inline-box;
         display: inline-flex;
         -webkit-box-align: center;
         align-items: center;
         -webkit-box-pack: center;
         justify-content: center;
         text-align: center;
         vertical-align: middle;
      }

      .icon-xs {
         height: 20px;
         width: 20px;
         line-height: 20px;
      }
      .mr-2, .mx-2 {
         margin-right: .5rem!important;
      }

      .rounded-circle {
         border-radius: 50%!important;
      }
      .bg-lightpalegreen {
         background-color: #e4ffcf!important;
      }

      .bg-lightpeach {
         background-color: #ffd7de!important;
      }
   </style>    
@endsection
@section('content')  
   <div class="section-container head-section mb-5 bg-white">
      <div class="pageheader bg-shape mt-5">
         <div class="container">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="page-caption mt-5">
                     <div class="page-caption-para-text text-center mt-5">
                        <h2 class="mb-2"><i class="fal fa-credit-card-front fa-3x"></i></h2>
                        <h1>Upgrade today and get more!</h1>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="section-container-plain head-section mb-5">
      <div class="container">
         @include('partials._messages')
         <div class="row justify-content-center">
            @foreach(Wingu::get_all_plan() as $plan)
               <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                  <!--  pricing block start -->
                  <div class="card card-body py-5 px-4 mb-4 border-lightinfo aos-init aos-animate" data-aos="zoom-in">
                     <div class="mb-3 text-center">
                        <h3 class="font-14 textspace-lg text-info mb-3">{!! $plan->title !!}</h3>
                        <h4 class="font-weight-bold text-dark">${!! number_format($plan->usd) !!}/month.</h4>
                     </div>
                     <div class="text-center">
                        @foreach(Wingu::get_active_modules() as $activeModules)
                           <div class="d-flex mb-2">
                              @if(Wingu::check_plan_module_link($activeModules->id,$plan->id) == 1)
                                 <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                    <i class="fas fa-check text-success"></i>
                                 </div>
                              @else 
                                 <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                    <i class="fas fa-times text-danger"></i>
                                 </div>
                              @endif
                              <!-- Text -->
                              <p class="mb-0 font-14">
                                 <span>{!! $activeModules->name !!}</span>
                              </p>
                           </div>
                        @endforeach
                        @if($plan->invoices != "")
                           <div class="d-flex mb-2">
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                              <p class="mb-0 font-14">
                                 <span>@if($plan->invoices > 1000)Unlimited @else{!! $plan->invoices !!}@endif invoices/month</span>
                              </p>
                           </div>
                        @endif
                        <div class="d-flex mb-2">
                           @if($plan->employees == 0)
                              <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-times text-danger"></i>
                              </div>
                           @else                              
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                           @endif
                           <p class="mb-0 font-14">
                              <span>@if($plan->employees > 0)Unlimited @endif Employees</span>
                           </p>
                        </div>
                        <div class="d-flex mb-2">
                           @if($plan->users == 0)
                              <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-times text-danger"></i>
                              </div>
                           @else                              
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                           @endif
                           <p class="mb-0 font-14">
                              <span>{!! $plan->users !!} users included</span>
                           </p>
                        </div>
                        @if($plan->leads != "")
                           <div class="d-flex mb-2">
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                              <p class="mb-0 font-14">
                                 <span>@if($plan->leads > 1000)Unlimited @else{!! $plan->leads !!}@endif Leads/month</span>
                              </p>
                           </div>
                        @endif
                        @if($plan->customers != "")
                           <div class="d-flex mb-2">
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                              <p class="mb-0 font-14">
                                 <span>@if($plan->customers > 1000) Unlimited @else{!! $plan->customers !!}@endif Customers/mo</span>
                              </p>
                           </div>
                        @endif
                        <div class="d-flex mb-2">
                           @if($plan->suppliers == 0)
                              <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-times text-danger"></i>
                              </div>
                           @else                              
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                           @endif
                           <p class="mb-0 font-14">
                              <span>@if($plan->suppliers > 1000)Unlimited @else{!! $plan->suppliers !!}@endif Vendors/month</span>
                           </p>
                        </div>
                        <div class="d-flex mb-2">
                           <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                              <i class="fas fa-check text-success"></i>
                           </div>
                           <p class="mb-0 font-14">
                              <span>@if($plan->projects > 1000)Unlimited @else{!! $plan->projects !!}@endif Projects/month</span>
                           </p>
                        </div>
                        <div class="d-flex mb-2">
                           <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                              <i class="fas fa-check text-success"></i>
                           </div>
                           <p class="mb-0 font-14">
                              <span>@if($plan->products > 1000)Unlimited @else{!! $plan->products !!}@endif Items/month</span>
                           </p>
                        </div>
                        <div class="d-flex mb-2">
                           <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                              <i class="fas fa-check text-success"></i>
                           </div>
                           <p class="mb-0 font-14">
                              <span>{!! $plan->roles !!} Custom Roles</span>
                           </p>
                        </div>    
                        <div class="d-flex mb-2">
                           @if($plan->assets == 0)
                              <div class="bg-lightpeach mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-times text-danger"></i>
                              </div>
                           @else                              
                              <div class="bg-lightpalegreen mr-2 icon-shape icon-xs rounded-circle font-10 ">
                                 <i class="fas fa-check text-success"></i>
                              </div>
                           @endif
                           <p class="mb-0 font-14">
                              <span>{!! $plan->assets !!} Assets in Management</span>
                           </p>
                        </div>                        
                        @if($plan->id == Wingu::business()->plan)
                           <button type="button" class="btn btn-inverse btn-block btn-success mt-5">
                              <i class="fal fa-check-circle"></i> Selected
                           </button>
                        @else
                           @if($plan->id == 1)
                              <a href="#" class="btn btn-inverse btn-pink btn-block mt-5">
                                 Choose this
                              </a>
                           @else 
                              <button type="button" class="btn btn-inverse btn-pink btn-block btn-primary mt-5" data-toggle="modal" data-target="#plan{!! $plan->id !!}">
                                 Upgrade
                              </button>
                           @endif
                        @endif
                     </div>
                  </div>
                  <!--  pricing block close -->
               </div>
               {{-- payment list --}}
               <div class="modal fade" id="plan{!! $plan->id !!}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Choose method of payment</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <form action="https://payments.ipayafrica.com/v3/ke">
                                    <input name="hsh" type="hidden" value="{!! Wingu::ipay($plan->id) !!}">  
                                    <input type="hidden" name="live" value="1" class="form-control">
                                    <input type="hidden" name="oid" value="{!! $plan->id !!}" class="form-control">
                                    <input type="hidden" name="inv" value="{!! Wingu::business()->businessID !!}" class="form-control">
                                    <input type="hidden" name="ttl" value="{!! $plan->price !!}" class="form-control">
                                    <input type="hidden" name="tel" value="0700000000" class="form-control">
                                    <input type="hidden" name="eml" value="{!! Wingu::business()->primary_email !!}" class="form-control">
                                    <input type="hidden" name="vid" value="treeb" class="form-control">
                                    <input type="hidden" name="curr" value="KES" class="form-control">
                                    <input type="hidden" name="p1" value="Webpayment" class="form-control">
                                    <input type="hidden" name="p2" value="{!! Auth::user()->businessID !!}" class="form-control">
                                    <input type="hidden" name="p3" value="" class="form-control">
                                    <input type="hidden" name="p4" value="" class="form-control">
                                    <input type="hidden" name="cbk" value="https://cloud.winguplus.com/subscriptions/ipay/callback" class="form-control">
                                    <input type="hidden" name="cst" value="1" class="form-control">
                                    <input type="hidden" name="crl" value="0" class="form-control">
                                    <center><button type="submit" class="btn btn-lg btn-success btn-block"><i class="fas fa-credit-card"></i> Ipay</button></center>
                                 </form>
                              </div>
                              {{-- <div class="col-md-6">
                                 <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="frmTransaction" id="frmTransaction">
                                    <input type="hidden" name="business" value="wingumanagementsystems@gmail.com">                                 
                                    <input type="hidden" name="cmd" value="_xclick">                                 
                                     <input type="hidden" name="item_name" value="{!! $plan->title !!}">                                 
                                    <input type="hidden" name="item_number" value="{{ $plan->id }}">                                 
                                    <input type="hidden" name="amount" value="{{ $plan->usd }}">                                   
                                    <input type="hidden" name="currency_code" value="USD">       
                                    <input type="hidden" name="custom" value="{!! Auth::user()->businessID !!}"> 
                                    <input type="hidden" name="no_shipping" value="0">                       
                                    <input type="hidden" name="cancel_return" value="{!! route('wingu.subscription.paypal.cancel') !!}">                                 
                                    <input type="hidden" name="return" value="{!! route('wingu.subscription.paypal.callback') !!}">
                                    <button type="submit" class="btn btn-lg btn-warning btn-block"><i class="fab fa-paypal"></i> Paypal</button>                
                                 </form>                                 
                              </div> --}}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </div>
@endsection