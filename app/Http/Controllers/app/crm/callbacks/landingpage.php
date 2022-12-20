<?php

namespace App\Http\Controllers\app\crm\callbacks;

use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\finance\customer\address;
use App\Models\finance\customer\contact_persons;
use App\Models\wingu\business;
use Illuminate\Http\Request;
use App\Mail\systemMail;
use Mail;
use Helper;

class landingpage extends Controller
{
   //collect landing page details
   public function collect_data(Request $request){

      //get business
      $account = business::where('businessID',$request->token)->first();

      if($account != ""){
         if($request->inquiry != ""){
            $description = $request->inquiry;
         }else{
            $description = '<h4>'.$request->subject.'</h4><p>
                           <b>I need space for :</b>'.$request->space_count.'<br>
                           <b>Location :</b> '.$request->location.'<br>
                           <b>Reference Source :</b> '.$request->reference_source.'
                        </p>';
         }
         //create lead
         $code = Helper::generateRandomString(10);
         $leads = new customers;
         $leads->title = $request->subject;
         $leads->reference_number = $code;
         $leads->category = 'Lead';
         if($request->company_name != ""){
            $leads->customer_name = $request->company_name;
         }else{
            $leads->customer_name = $request->names;
         }
         $leads->email = $request->email;
         $leads->primary_phone_number = $request->phone_number;
         $leads->website = $request->website;
         $leads->sourceID = 2;
         $leads->remarks =  $description;
         $leads->created_by = $account->userID;
         $leads->assignedID = $account->userID;
         $leads->businessID = $account->id;
         $leads->save();

         //billing
         $address = new address;
         $address->customerID = $leads->id;
         $address->save();

         if($request->company_name != ""){
            $contact_persons = new contact_persons;
            $contact_persons->customerID = $leads->id;
            $contact_persons->names = $request->names;
            $contact_persons->contact_email = $request->email;
            $contact_persons->phone_number = $request->phone_number;
            $contact_persons->businessID = $account->id;
            $contact_persons->save();
         }

         //send remander
         $subject = 'Lead Notification';
         $userContent = '<h4>Hello, '.$account->name.'</h4><p>You have a new lead registration from your landing page, Login to <a href="https://cloud.propertywingu.com/">Property wingu</a> to see all the details of the lead</p>';
         $to = $account->primary_email;
         Mail::to($to)->send(new systemMail($userContent,$subject));

         $status = 'success';

      }else{
         $status = 'error';

         return redirect()->to($request->callback.'?status='.$status);
      }

      return redirect()->to($request->callback.'?status='.$status);
   }

}
