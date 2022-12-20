<?php
namespace App\Helpers;
use App\Models\wingu\languages;
use App\Models\wingu\country;
use App\Models\wingu\settings;
use App\Models\wingu\activity_log;
use App\Models\wingu\business;
use App\Models\finance\currency;
use App\Models\wingu\status;
use App\Models\wingu\User;
use App\Models\wingu\Sessions;
use App\Models\wingu\laratrust\Permission;
use App\Models\wingu\file_manager;
use App\Models\wingu\templates;
use App\Models\wingu\modules;
use App\Models\wingu\industry;
use App\Models\wingu\plan_module;
use App\Models\wingu\plan_functions;
use App\Models\wingu\rolesandpermissions\functions;
use App\Models\wingu\plan;
use App\Models\wingu\roles;
use App\Models\wingu\business_modules;
use Stevebauman\Location\Facades\Location;
use Auth;
use Helper;
class Wingu
{
   //get language
   public static function Language($id){
      $language = languages::find($id);
      return $language;
   }

   /**============= country =============**/
	public static function country($id){
		$country = country::find($id);
		return $country;
   }
   
   /**============= currency =============**/
   public static function currency(){
      $currency = currency::join('business','business.base_currency','=','currency.id')
                     ->where('business.id',Auth::user()->businessID)
                     ->first();

      return $currency;
   }

   /**============= settings =============**/
   public static function check_for_setting($name, $type){
      $check = settings::where('name',$name)->where('type',$type)->count();
      return $check;
   }

   public static function all_settings(){
      $settings = settings::groupby('section')->get();
      return $settings;
   }

   public static function settings_by_type($type){
      $types = settings::where('type',$type)->get();
      return $types;
   }

   public static function get_specific_setting($name, $type){
      $settings = settings::where('name',$name)->where('type',$type)->first()->value;
      return $settings;
   }

   /**============= Record Activity =============**/
   public static function activity($activities, $section, $type, $userID, $activityID, $businessID){
      $activity = new activity_log;
      $activity->activity = $activities;
      $activity->section  = $section;
      $activity->type     = $type;
      $activity->userID  = Auth::user()->id;
      $activity->activityID = $activityID;
      $activity->businessID = $businessID;
      $activity->ip_address = Helper::get_client_ip();
      $activity->save();

      return 'true';
   }

   /**============= check if admin is linked to a business =============**/
   public static function business(){
      $business = business::where('id',Auth::user()->businessID)->where('businessID',Auth::user()->code)->first();
      return $business;
   }

   public static function business_with_id($businessID){
      $business = business::where('businessID',$businessID)->select('name')->first();
      return $business;
   }

   public static function template($id){
      $template = templates::find($id);
      return $template;
   }

   /**============= status =============**/
   public static function status($id){
      $status = status::find($id);
      return $status;
   }

   public static function check_status($id){
      $check = status::where('id',$id)->count();
      return $check;
   }

   /**============= user info =============**/
   public static function user($id){
      $user = User::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      return $user;
   }

   //check user
   public static function check_user($id){
      $check = User::where('id',$id)->where('businessID',Auth::user()->businessID)->count();
      return $check;
   }

   //count users
   public static function count_user(){
      $count = User::where('businessID',Auth::user()->businessID)->count();
      return $count;
   }

  

   /**============= modules =============**/
   //module info
   public static function modules($id){
      $modules = modules::find($id);
      return $modules;
   }

   //check if module exits
   public static function check_modules($id){
      $check = modules::where('id',$id)->count();
      return $check;
   }

   //get all active modules
   public static function get_active_modules(){
      $modules = modules::where('status',15)->get();
      return $modules;
   }

   //check if plan is linked to module
   public static function check_plan_module_link($moduleID,$planID){
      $check = plan_module::where('moduleID',$moduleID)->where('planID',$planID)->count();
      return $check;
   } 

   /**============= general user info =============**/
   // user Session
   public static function sessions($id){
      $session = Sessions::where('user_id',$id)->orderby('id','desc')->limit(1)->first();
      return $session;
   }

   //check if user has account
   public static function employee_account_check($id){
      $check = User::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->count();
      return $check;
   }

   /**============= plan =============**/
   //get all plans
   public static function get_all_plan(){
      $plans = plan::where('status','Active')->orderby('id','asc')->get();
      return $plans;
   } 

   //plan details
   public static function plan(){
      $business = business::where('id',Auth::user()->businessID)->where('businessID',Auth::user()->code)->first();
      $plan = plan::where('id',$business->plan)->first();
      return $plan;
   }


   //plan modules
   public static function check_plan_module($planID,$moduleID){
      $check = plan_module::where('planID',$planID)->where('moduleID',$moduleID)->where('status',15)->count();
      return $check;
   }

   //plan functions
   public static function check_plan_function($functionID,$planID,$moduleID){
      $check = plan_functions::where('functionID',$functionID)
                     ->where('planID',$planID)
                     ->where('moduleID',$moduleID)
                     ->count(); 
      return $check;
   }

   //get plan details   
   public static function get_plan($id){
      $plan = plan::where('id',$id)->first();
      return $plan;
   }

   /**============= file manager =============**/
   public static function file_size(){
      $size = file_manager::where('businessID',Auth::user()->businessID)->get()->sum("file_size");
      return $size;
   }

   /**============= roles =============**/
   public static function count_roles(){
      $count = roles::where('businessID',Auth::user()->businessID)->count();
      return $count;
   }

   /**============= ipay =============**/
   public static function ipay($planID){
      $plan = business_modules::where('businessID',Auth::user()->businessID)->where('id',$planID)->first();

      $vendorID = 'treeb';
      $secretKey = 'Fun123XCVA121dgkL';
      $cbUrl = route('wingu.application.payment');

      $location = Location::get(request()->ip());

      if($location->countryName == 'Kenya'){
         $price = $plan->price * 100;
         $currency = 'KES'; 
         $mpesa = 1;
      }else{
         $price = $plan->price;
         $currency = 'USD'; 
         $mpesa = 0;
      }

      /*
      This is a sample PHP script of how you would ideally integrate with iPay Payments Gateway and also handling the 
      callback from iPay and doing the IPN check

      ----------------------------------------------------------------------------------------------------
               ************(A.) INTEGRATING WITH iPAY ***********************************************
      ----------------------------------------------------------------------------------------------------
      */
      //Data needed by iPay a fair share of it obtained from the user from a form e.g email, number etc...
      $fields = array("live"=> "1",
         "oid"=> $planID,
         "mpesa"=> $mpesa,
         "inv"=> Wingu::business()->businessID,
         "ttl"=> $price,
         "tel"=> "0700000000",
         "eml"=> Wingu::business()->primary_email,
         "vid"=> $vendorID,
         "curr"=> $currency,
         "p1"=> "Webpayment",
         "p2"=> Auth::user()->businessID,
         "p3"=> $currency,
         "p4"=> "",
         "cbk"=> $cbUrl,
         "cst"=> "1",
         "crl"=> "0"
      );

      /* 
      ----------------------------------------------------------------------------------------------------
      ************(b.) GENERATING THE HASH PARAMETER FROM THE DATASTRING *********************************
      ----------------------------------------------------------------------------------------------------

      The datastring IS concatenated from the data above
      */
      $datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['p1'].$fields['p2'].$fields['p3'].$fields['p4'].$fields['cbk'].$fields['cst'].$fields['crl'];
      $hashkey =  $secretKey;//use "demoCHANGED" for testing where vid is set to "demo"

      /********************************************************************************************************
      * Generating the HashString sample
      */
      $generated_hash = hash_hmac('sha1',$datastring , $hashkey);

      return $generated_hash;
   }

   /**============= ipay =============**/
   public static function check_account_payment(){
      $check = business::where('id',Auth::user()->businessID)->first();
      if(date('Y-m-d') > $check->due_date){
         return 'due';
      }else{
         return 'ok';
      }
   }

   /**============= industry =============**/
   public static function industry($id){
      $industry = industry::find($id);
      return $industry;
   }


   /**============= payment link =============**/
   public static function payment_link(){
      $link = 'https://payments.winguplus.com';
      return $link;
   }

   //============================================ business modules  ==================================
	//=============================================================================================---->
   // business modules
   public static function check_business_modules($id){
      $check = business_modules::where('businessID',Auth::user()->businessID)->where('moduleID',$id)->where('module_status','!=',22)->count();
      return $check;
   }

   //check if account has modules
   public static function check_if_account_has_modules(){
      $check = business_modules::where('businessID',Auth::user()->businessID)->count();
      return $check;
   }

   //check if account has modules
   public static function get_account_module_details($id){
      $info = business_modules::where('businessID',Auth::user()->businessID)->where('moduleID',$id)->first();
      return $info;
   }

   //check the number of active modules
   public static function count_payed_modules(){
      $check = business_modules::where('businessID',Auth::user()->businessID)->where('payment_status',1)->where('module_status',15)->count();
      return $check;
   }

   //======================================= roles and permissions  ==================================
	//=============================================================================================---->
   /**
   * get permissions by group
   **/
   public static function permissions_by_group($id){
      $permissions = Permission::where('groupID',$id)->get();
      return $permissions;
   }

   /**
   * get module functionalities
   **/
   public static function get_module_funations($id){
      $groups = functions::where('moduleID',$id)->where('status',15)->get();
      return $groups;
   }
   
}
