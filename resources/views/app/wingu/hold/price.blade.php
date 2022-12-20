@extends('layouts.frontend')
@section('title'){!! $page->title !!} @endsection
@section('description'){!! $page->meta_description !!}@endsection
@section('keywords'){!! $page->meta_tags !!}@endsection
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
         <center><h2><i class="fal fa-usd-circle fa-5x"></i></h2></center>
         <h2 class="mt-5 head-title">Simple Pricing.</h2>
      </div>
      <!-- END container -->
   </div>
   <div class="section-container">
      <div class="container">
         <ul class="pricing-table pricing-col-4">
            @foreach (Limitless::get_all_plan() as $plan)
               <li @if($plan->id == 4) class="highlight" @endif>
                  <div class="pricing-container">
                     <h3>{!! $plan->title !!}</h3>
                     <div class="price">
                        <div class="price-figure">
                           <span class="price-number">${!! number_format($plan->usd) !!}</span>
                           <span class="price-tenure">per month</span>
                        </div>
                     </div>
                     <ul class="features">
                        <li><b>{!! $plan->users !!}</b> Users</li>
                        @if($plan->id == 1 || $plan->id == 3)
                           <li>Up to <b>{!! $plan->projects !!}</b> Projects</li>
                           <li>Up to <b>{!! $plan->invoices !!}</b> Invoices</li>
                        @else 
                           <li>Unlimited Projects</li>
                           <li>Unlimited Invoices</li>
                        @endif
                        <li>Custom Roles <b>{!! $plan->roles !!}</b></li>
                     </ul>
                     <div class="footer">
                        <button type="button" class="btn btn-inverse btn-pink btn-block btn-primary" data-toggle="modal" data-target="#plan{!! $plan->id !!}">
                           Subscribe
                        </button>                     
                     </div>
                  </div>
               </li>
            @endforeach
         </ul>
      </div>
   </div>
   <div class="section-container bg-white">
      <div class="container">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th class="" style="padding-left: 10px !important;text-align: center;"></th>
                  <th class="bg-grey">Growth</th>
                  <th class="bg-grey">Starter</th>
                  <th class="bg-grey">Professional</th>
                  <th class="bg-grey">Enterprise</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>Users</td>
                  <td><b>Up to 2</b></td>
                  <td><b>Up to 3</b></td>
                  <td><b>Up to 5</b></td>
                  <td><b>Up to 8</b></td>
               </tr>               
               <tr>
                  <td>Contacts</td>
                  <td><b>Up to 100</b></td>
                  <td><b>Up to 200</b></td>
                  <td><b>Up to 300</b></td>
                  <td><b>Up to 400</b></td>
               </tr>
               <tr>
                  <td>Custom Roles </td>
                  <td><b>Up to 2</b></td>
                  <td><b>Up to 4</b></td>
                  <td><b>Up to 8</b></td>
                  <td><b>Up to 16</b></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Finance</span></th>
               </tr>
               <tr>
                  <td>Invoices</td>
                  <td><b>Up to 30</b></td>
                  <td><b>Up to 60</b></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Inventory Management</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>   
               <tr>
                  <td>Products</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Human resource management </span></th>
               </tr>
               <tr>
                  <td>Employees </td>
                  <td><b>Up to 7</b></td>
                  <td><b>Up to 15</b></td>
                  <td><b>Up to 25</b></td>
                  <td><b>Up to 50</b></td>
               </tr>
               <tr>
                  <td>Organizations</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr> 
               <tr>
                  <td>Leave Management</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Payroll</td>
                  <td><b></b></td>
                  <td><b>Coming Soon!</b></td>
                  <td><b>Coming Soon!</b></td>
                  <td><b>Coming Soon!</b></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Customer Relationship Management</span></th>
               </tr>
               <tr>
                  <td>Contact Management </td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Project Management</span></th>
               </tr>
               <tr>
                  <td>Projects</td>
                  <td><b>Up to 20</b></td>
                  <td><b>Up to 30</b></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Tasks</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Task Groups</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Lists & Tags</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Notes</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <td>Collaboration </td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Subscription Management</span></th>
               </tr>
               <tr>
                  <td>Products</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               <tr>
                  <th style="text-align: center; border: 0px !important;"><span class="txt-l" style="float: left;color:#f1628f">Asset  Management</span></th>
               </tr>
               <tr>
                  <td>Inventory Management</td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
                  <td class="tick" style="background-size: 25px !important;"></td>
               </tr>
               
            </tbody>
         </table>
      </div>
   </div>
@endsection
