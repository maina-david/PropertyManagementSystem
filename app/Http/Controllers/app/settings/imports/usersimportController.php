<?php

namespace App\Http\Controllers\app\mtandao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Helper;
use Excel;
use App\Model\users\Users;
use App\Model\freelancer\freelancer;
use Session;
class usersimportController extends Controller
{
   public function user(){
      return view('Modules.mtandao.users.import');
   }

   public function import(Request $request){
      if($request->hasFile('users')){
         $path = $request->file('users')->getRealPath();
         $data = Excel::load($path)->get();

         $count = $data->count();

         //return $count;

         if($data->count()){
            //save options
            foreach($data as $key => $value){
               $user = new Users;
               $user->name = $value->name;
               $user->email = $value->email; 	
               $user->phone_number = $value->phone_number; 
               $user->username = '@'.$value->username;
               $user->gender = $value->gender;
               $user->password = bcrypt('password');
               $user->activation = 'Activated';
               $user->signup_ip = $value->signup_ip;
               $user->save();
            }
            Session::flash('success', 'File imported Successfully.');
         }
      }else{
         Session::flash('warning','There is no file to import');
      }

      return redirect()->route('mtandao.users');
   }
}
