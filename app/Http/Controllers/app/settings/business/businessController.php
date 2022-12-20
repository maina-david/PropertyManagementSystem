<?php

namespace App\Http\Controllers\app\settings\business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\business;
use App\Models\wingu\User;
use App\Models\wingu\activity_log;
use App\Models\wingu\industry;
use App\Models\wingu\country;
use App\Models\finance\currency;
use Wingu;
use Auth;
use Session;
use Helper;
use File;


class businessController extends Controller
{
   public function index(){
      $business = business::find(Auth::user()->businessID);
      $logs = activity_log::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $industry = industry::orderby('id','desc')->pluck('name','id')->prepend('Choose industry','');
      $country = country::orderby('id','desc')->pluck('name','id')->prepend('Choose country','');
      $currency = currency::all();
      $staffs = User::where('businessID', Auth::user()->businessID)
               ->select('*','businessID as business','id as staffID')
               ->orderby('id','desc')
               ->get();

      return view('app.settings.business.index', compact('business','staffs','logs','industry','country','currency'));
   }

   public function update(Request $request,$id){

      $this->validate($request, [
         'name' => 'required',
         'primary_phonenumber' => 'required',
      ]);
      
      $business = business::find($id);
      $business->name = $request->name;
      $business->industry = $request->industry;
      $business->company_size = $request->company_size;
      $business->primary_phonenumber = $request->primary_phonenumber;
      $business->website = $request->website;
      $business->street = $request->street;
      $business->city = $request->city;
      $business->state_province = $request->state_province;
      $business->zip_code = $request->zip_code;
      $business->country = $request->country;
      $business->base_currency = $request->base_currency;

      //upload logo
      if(!empty($request->logo)){

         //directory
         $directory = base_path().'/public/businesses/'.$business->businessID.'/documents/images/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         //delete logo if exist
         if($business->logo != ""){
            $delete = $directory.$business->logo;
            if (File::exists($delete)) {
               unlink($delete);
            }
         }

         //upload estimate to system
         $file = $request->logo;

         // GET THE FILE EXTENSION
         $extension = $file->getClientOriginalExtension();

         // RENAME THE UPLOAD WITH RANDOM NUMBER
         $fileName = Helper::generateRandomString(9). '.' . $extension;

         // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
         $upload_success = $file->move($directory, $fileName);

         $business->logo = $fileName;
      }

      $business->save();

      //record activity
      $activities = Auth::user()->name.' has made an update to the business profile';
      $section = 'Settings';
      $type = 'Business Profile';
      $userID = Auth::user()->id;
      $activityID = $business->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$userID,$activityID,$businessID);

      Session::flash('success','Business profile successfully updated');

      return redirect()->back();
   }

   public function delete_logo($id){

      $business = business::find($id);
      //directory
      $directory = base_path().'/public/businesses/'.$business->businessID.'/documents/images/';

      //create directory if it doesn't exists
      $delete = $directory.$business->logo;
      if (File::exists($delete)) {
         unlink($delete);
      }

      $business->logo = "";
      $business->save();

      //record activity
      $activities = Auth::user()->name.' has deleted the business profile logo';
      $section = 'Settings';
      $type = 'Business Profile';
      $userID = Auth::user()->id;
      $activityID = $business->id;
      $businessID = Auth::user()->businessID;

      Wingu::activity($activities,$section,$type,$userID,$activityID,$businessID);

      Session::flash('success','Business profile successfully updated');

      return redirect()->back();

   }
}
