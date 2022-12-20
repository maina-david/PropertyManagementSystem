@extends('layouts.frontend')
@section('title') Plans @endsection
@section('url'){!! route('home.page') !!}@endsection
@section('stylesheet')
   <style>
      td+td{
         text-align: center;
      }
   </style>
@endsection
@section('content')
   <div class="section-container head-section bg-white">
      <!-- BEGIN container -->
      <div class="container text-center mb-5">
         <center><h2><i class="fal fa-credit-card-front fa-5x"></i></h2></center>
         <h2 class="mt-5 head-title">Choose your preferred payment method.</h2>
      </div>
      <!-- END container -->
   </div>
   <div class="section-container" style="min-height: 300px">
      <div class="container">
         <div class="row">
            <div class="col-md-3">
               <center>
                  <a href="{!! route('limitless.payment.safaricom',1) !!}" class="btn btn-success btn-block">
                     Safaricom Lipa na Mpesa.
                  </a>
               </center>
            </div>
            <div class="col-md-3">
               <form action="https://payments.ipayafrica.com/v3/ke">
                  <input name="hsh" type="hidden" value="{!! Limitless::ipay($planID) !!}">  
                  <input type="hidden" name="live" value="1" class="form-control">
                  <input type="hidden" name="oid" value="{!! Limitless::business()->businessID !!}" class="form-control">
                  <input type="hidden" name="inv" value="{!! Limitless::business()->businessID !!}" class="form-control">
                  <input type="hidden" name="ttl" value="{!! Limitless::get_plan($planID)->price !!}" class="form-control">
                  <input type="hidden" name="tel" value="{!! Limitless::business()->primary_phonenumber !!}" class="form-control">
                  <input type="hidden" name="eml" value="{!! Limitless::business()->primary_email !!}" class="form-control">
                  <input type="hidden" name="vid" value="treeb" class="form-control">
                  <input type="hidden" name="curr" value="KES" class="form-control">
                  <input type="hidden" name="p1" value="Webpayment" class="form-control">
                  <input type="hidden" name="p2" value="" class="form-control">
                  <input type="hidden" name="p3" value="" class="form-control">
                  <input type="hidden" name="p4" value="" class="form-control">
                  <input type="hidden" name="cbk" value="https://limitlesserp.com/subscriptions/ipay/callback" class="form-control">
                  <input type="hidden" name="cst" value="1" class="form-control">
                  <input type="hidden" name="crl" value="0" class="form-control">
                  <center><button type="submit" class="btn btn-primary">  Make your payment with Ipay </button>     </center>
               </form>
            </div>
            <div class="col-md-3">
               <center>
                  <a href="{!! route('limitless.payment.safaricom',1) !!}" class="btn btn-success btn-block">
                     Paypal
                  </a>
               </center>
            </div>
            <div class="col-md-3">
               <center>
                  <a href="{!! route('limitless.payment.safaricom',1) !!}" class="btn btn-success btn-block">
                     Stripe
                  </a>
               </center>
            </div>
         </div>
      </div>
   </div> 
@endsection
