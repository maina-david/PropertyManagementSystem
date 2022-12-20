<?php

namespace App\Http\Controllers\app\settings\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\wingu\User;
use App\Models\hr\employees;
use App\Models\hr\branches;
use App\Models\wingu\laratrust\Role;
use App\Mail\sendMessage;
use DB;
use Session;
use Wingu;
use Auth;
use Hash;
use Mail;
use Helper;
use Hr;
class UserController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      //check if account has no branches
      $checkBranches = branches::where('businessID',Auth::user()->businessID)->count();
      if($checkBranches == 0){
         $branches = new branches;
         $branches->branch_name = 'Main branch';
         $branches->main_branch = 'Yes';
         $branches->businessID = Auth::user()->businessID;
         $branches->userID = Auth::user()->id;
         $branches->save();
      }

      $users = User::OrderBy('id','DESC')->where('businessID',Auth::user()->businessID)->get();
      $count = 1;
      return view('app.settings.users.index', compact('users','count'));
   }

   public function create(){
      $roles = Role::where('businessID',Auth::user()->businessID)->get();
      $branches = branches::where('businessID',Auth::user()->businessID)->get();

      return view('app.settings.users.create', compact('roles','branches'));
   }

   public function store(Request $request){
      $this->validate($request,[
         'name' => 'required',
         'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
         'password' => 'required', 'string', 'min:8', 'confirmed',
         'roles' => 'required',
         'branch' => 'required',
      ]);

      $check = User::where('email',$request->email)->count();
      if($check != 0){
         Session::flash('error','The email you have provided is already in use');
         return redirect()->back();
      }

      //create employee
      $employee = new User;
      $employee->name = $request->name;
      $employee->email = $request->email;
      $employee->branch_id = $request->branch;
      $employee->businessID = Auth::user()->businessID;
      $employee->userID = Auth::user()->id;
      $employee->code = Wingu::business()->businessID;
      $employee->statusID = 7;
      $employee->remember_token = Helper::generateRandomString(9);
      $employee->password = Hash::make($request->password);
      $employee->save();

      //assign roles
      if(!empty($request->roles)){
         foreach ($request->roles as $key=>$value){
            $employee->attachRole($value);
         }
      }

      //send email to new employee
      $subject = 'Account Activation and verification';
      $to = $employee->email;
      $content = '<h3>Hi,'.$request->name.'</h3><h4>We are delighted to have you on board</h4><p>We have a powerful product suite to help you manage your properties with ease. You can check us out at www.propertywingu.com.</p><p>To activate your Property wingu account, please click the link below within the next 30 days.</p><table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary"><tbody><tr><td align="left"><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><center><a href="'.route('account.verify',$employee->remember_token).'" target="_blank">Confirm Account</a> </center></td></tr></tbody></table></td></tr></tbody></table> <p>If you have any questions regarding your Property wingu account, please contact us at propertywingu@wingusystems.com Our technical support team will assist you with anything you need.</p><p>Enjoy yourself, and welcome to Property wingu.</p>';
      Mail::to($to)->send(new sendMessage($content,$subject));

      Session::flash('success','User Added successfully');

      return redirect()->route('settings.users.index');
   }

   public function edit($id){
      $roles = Role::where('businessID',Auth::user()->businessID)->get();
      $user = User::where('id', $id)->where('businessID',Auth::user()->businessID)->select('*','branch_id as branch')->first();
      $branches = branches::where('businessID',Auth::user()->businessID)->pluck('branch_name','id')->prepend('choose branch','');
      return view('app.settings.users.edit', compact('user','user','roles','branches'));
   }

   public function update(Request $request,$id){
      $this->validate($request,[
         'name' => 'required',
         'branch' => 'required',
      ]);

      //ccheck if email is in use
      $user = User::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      if($user->email != $request->email){
         $checkEmail = User::where('email',$request->email)->count();
         if($checkEmail != 0){
            Session::flash('error','The email you have provided is already in use');
            return redirect()->back();
         }
      }

      $user->name = $request->name;
      if($user->id != Wingu::business()->userID){
         $user->email = $request->email;
      }
      $user->branch_id = $request->branch;
      $user->save();

      if($user->id != Wingu::business()->userID){
         if(!empty($request->roles)){
            DB::table('role_user')->where('user_id',$id)->delete();

            foreach ($request->roles as $key=>$value){
               $user->attachRole($value);
            }
         }
      }

      Session::flash('success', 'User Successfully updated!');

      return redirect()->back();
   }


}
