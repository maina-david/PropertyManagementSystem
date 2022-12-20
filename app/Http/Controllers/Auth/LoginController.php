<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\wingu\User;
use Carbon\Carbon;
use Session;

class LoginController extends Controller 
{
   /*
   |--------------------------------------------------------------------------
   | Login Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles authenticating users for the application and
   | redirecting them to your home screen. The controller uses a trait
   | to conveniently provide its functionality to your applications.
   | 
   */

   use AuthenticatesUsers;

   /**
    * Where to redirect users after login.
    *
    * @var string
    */
   protected $redirectTo = RouteServiceProvider::HOME;

   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('guest')->except('logout');
   }

   public function verify_account($code){
      //get user
      $check = User::where('remember_token',$code)->count();

      if($check != 1){
         Session::flash('error','This Code Expired !!!');
         return redirect()->route('login');
      }

      $user = User::where('remember_token',$code)->first();

      $user->statusID = 15;
      $user->remember_token = '';
      $user->email_verified_at = date("Y-m-d H:i:s");
      $user->save();

      return redirect()->route('login'); 
   }

   function authenticated(Request $request, $user)
   {
      $user->last_login = Carbon::now();
      $user->last_login_ip = $request->getClientIp();
      $user->save();
   }

}
