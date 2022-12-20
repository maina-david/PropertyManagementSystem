<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\wingu\business;
use App\Models\wingu\User;
use App\Models\wingu\laratrust\Role_user;
use App\Mail\systemMail;
use Session;
use Helper;
use Mail;

class RegisterController extends Controller
{
   /*
   |--------------------------------------------------------------------------
   | Register Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles the registration of new users as well as their
   | validation and creation. By default this controller uses a trait to
   | provide this functionality without requiring any additional code.
   |
   */

   use RegistersUsers;

   /**
    * Where to redirect users after registration.
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
      $this->middleware('guest');
   }

   /**
    * Get a validator for an incoming registration request.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
   protected function validator(array $data)
   {
      return Validator::make($data, [
         'name' => ['required', 'string', 'max:255'],
         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
         'password' => ['required', 'string', 'min:8', 'confirmed'],
      ]);
   }

   /**
    * Create a new user instance after a valid registration.
    *
    * @param  array  $data
    * @return \App\User
    */
   protected function create(array $data)
   {
      return User::create([
         'name' => $data['name'],
         'email' => $data['email'],
         'password' => Hash::make($data['password']),
      ]);
   }


   /**
    * Create a new user instance after a valid registration.
    *
    *
   */
   public function signup_form(){
      return view('auth.register');
   }

   /**
    * Create a new user instance after a valid registration.
    *
    *
   */
   public function signup(Request $request){
      $this->validate($request, [
         'full_names' => 'required',
         'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
         'password' => ['required', 'string', 'min:12', 'confirmed'],
      ]);

      //token
      $token = Helper::generateRandomString(18);

      $checkEmail = User::where('email',$request->email)->count();
      if($checkEmail != 0){
         Session::flash('warning','The email your entered is already in use');

         return redirect()->back();
      }

      //add to user table
      $user = new User;
      $user->name = $request->full_names;
      $user->email = $request->email;
      $user->password = Hash::make($request->password);
      $user->remember_token = $token;
      $user->save();

      $trialDays = 30;
      $startDate = date('Y-m-d');
      $dateJoined = date('Y-m-d H:i:s');
      $billingStart = date('Y-m-d', strtotime($startDate. ' + '.$trialDays.' days'));

      //add the business
      $business = new business;
      $business->name = $request->full_names;
      $business->primary_email = $request->email;
      $business->industry = 1;
      $business->base_currency = 132;
      $business->country = 110;
      $business->company_size = 1;
      $business->businessID = Helper::generateRandomString(16);
      $business->userID = $user->id;
      $business->templateID = 3;
      $business->plan = 1;
      $business->due_date = $billingStart;
      $business->date_joined = $dateJoined;
      $business->ip =  request()->ip();
      $business->save();

      //add business ID to user account plus employeeID
      $update = User::find($user->id);
      $update->businessID = $business->id;
      $update->code = $business->businessID;
      $update->save();

      //add admin role to user
      $role = new Role_user;
      $role->role_id = 1;
      $role->user_id = $user->id;
      $role->user_type = 'App\Models\wingu\User';
      $role->save();

      //welcome email
      $subject = 'Welcome to Property wingu';
      $userContent = '<h4>Hello, '.$user->name.'</h4><p>Thank you for creating your account with us. Managing your Properties has never gotten easier.We have a powerful product suite to help you manage yourproperties with ease. <p><p>To activate your Property wingu account, please click the link below within the next 30 days.</p><table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary"><tbody><tr><td align="left"><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><center><a href="'.route('account.verify',$token).'" target="_blank">Confirm Account</a></center></td></tr></tbody></table></td></tr></tbody></table><p>If you have any questions regarding your Property wingu account, please contact us at propertywingu@wingusystems.com Our technical support team will assist you with anything you need.</p><p>Enjoy yourself, and welcome to Property wingu.</p><p><p>Regards<br>Property wingu Team<br><a href="https://propertywingu.com/">www.propertywingu.com</a></p><hr><small>If you’re having trouble clicking the "Confirm Account" button, copy and paste the URL below into your web browser: <a href="'.route('account.verify',$token).'">'.route('account.verify',$token).'</a></small>';
      $to = $request->email;
      Mail::to($to)->send(new systemMail($userContent,$subject));

      Session::flash('success','Your account has been created you can now login');

      return redirect()->route('login');
   }
}
