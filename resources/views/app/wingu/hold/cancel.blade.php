@extends('layouts.frontend')
@section('title') Transactions @endsection
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
         <h2 class="mt-5 head-title">Transaction has been canceled</h2>
      </div>
      <!-- END container -->
   </div>
@endsection
@section('scripts')
@endsection