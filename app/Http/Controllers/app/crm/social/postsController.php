<?php

namespace App\Http\Controllers\app\crm\social;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\social\accounts;
use App\Models\crm\social\posts; 
use App\Models\wingu\file_manager as docs;
use Session;
use Wingu;
use Helper;
use Auth;

class postsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   public function index(){
      $posts = posts::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
      $count = 1;
      return view('app.crm.social.post.index', compact('posts','count'));
   }

   public function create(){
      $accounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id');
      return view('app.crm.social.post.create', compact('accounts'));
   }

   public function store(Request $request){

      $this->validate($request,[
         'post' => 'required',
      ]);

      $post = new posts;
      $post->businessID = Auth::user()->businessID;
      $post->created_by = Auth::user()->id;
      $post->updated_by = Auth::user()->id;
      $post->code = Helper::generateRandomString(9);
      $post->post = $request->post;
      $post->link = $request->link;
      $post->link_description = $request->link_description;
      if($request->publish == 47){
         $post->status = 47;
      }else{
         $post->status = 10;
      }      
      $post->scheduled_upload_date_time = $request->scheduled_upload_date_time;
      $post->repeat = $request->repeat;
      $post->repeat_period = $request->repeat_period;
      $post->repeat_day_date = $request->repeat_day_date;
      $post->repeat_end_date = $request->repeat_end_date;
      $post->save();

      //save media
      if($request->hasFile('media')){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/crm/social/posts/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('media');

         foreach($files as $file) {
            $size =  $file->getSize();
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(3). '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $file->move($directory, $fileName);

            $upload = new docs;
            $upload->fileID      = $post->id;
            $upload->folder 	   = 'CRM';
            $upload->section 	   = 'social';
            $upload->name 		   = 'Images for digital marketing post #'.$post->id;
            $upload->file_name   = $fileName;
            $upload->file_size   = $size;
            $upload->attach 	   = 'No';
            $upload->file_mime   = $file->getClientMimeType();
            $upload->created_by  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->save();
         }
      }
      
      Session::flash('success','Post successfully saved');

      return redirect()->route('crm.social.post.index');
   }

   public function edit($id){
      $edit = posts::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $accounts = accounts::join('customers','customers.id','=','crm_marketing_accounts.customerID')
                  ->where('crm_marketing_accounts.businessID',Auth::user()->businessID)
                  ->orderby('crm_marketing_accounts.id','desc')
                  ->select('*','crm_marketing_accounts.id as accountID')
                  ->get();
      
      $currentAccounts = accounts::join('customers','customers.id','=','crm_marketing_accounts.customerID')
                  ->where('crm_marketing_accounts.businessID',Auth::user()->businessID)
                  ->where('crm_marketing_accounts.id',$edit->accountID)
                  ->orderby('crm_marketing_accounts.id','desc')
                  ->select('*','crm_marketing_accounts.id as accountID')
                  ->first();

      $channels = post_channel::join('crm_marketing_channels','crm_marketing_channels.id','=','crm_marketing_post_channel.channelID')
                  ->where('postID',$id)
                  ->get();

      return view('app.crm.socialmedia.publications.edit', compact('edit','accounts','currentAccounts','channels'));
   }

   public function update(Request $request, $id){

      $this->validate($request,[
         'account' => 'required',
         'title' => 'required',
         'channel' => 'required',
         'post' => 'required',
         'upload_time' => 'required'
      ]);

      $post =  posts::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $post->businessID = Auth::user()->businessID;
      $post->userID = Auth::user()->id;
      $post->accountID = $request->account;
      $post->title = $request->title;
      $post->post = $request->post;
      $post->link = $request->link;
      $post->link_description = $request->link_description;
      if($request->hasFile('media')){
         $post->media = 'Yes';
      }else{
         $post->media = 'No';
      }
      $post->upload_time = $request->upload_time;
      $post->save();

      //save media
      if($request->hasFile('media')){
         //directory
         $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/crm/marketing/posts/';

         //create directory if it doesn't exists
         if (!file_exists($directory)) {
            mkdir($directory, 0777,true);
         }

         $files = $request->file('media');

         foreach($files as $file) {
            $size =  $file->getSize();
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(3). '.' . $extension;

            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($directory, $fileName);

            $upload = new documents;
            $upload->parentid = $post->id;
            $upload->file_name = $fileName;
            $upload->folder    = 'Crm';
            $upload->section   = 'posts';
            $upload->file_mime = $file->getClientMimeType();
            $upload->userID  = Auth::user()->id;
            $upload->businessID  = Auth::user()->businessID;
            $upload->file_size = $size;
            $upload->name = 'Images for digital marketing post #'.$post->id;
            $upload->save();
         }
      }

      //save channels
      $channels = count(collect($request->channel));

      if($channels > 0){

         $delete = post_channel::where('postID',$id)->delete();
			if(isset($_POST['channel'])){
				for($i=0; $i < count($request->channel); $i++ ) {
					$channel = new post_channel;
					$channel->postID = $post->id;
					$channel->channelID = $request->channel[$i];
					$channel->save();
				}
			}
      }
      
      Session::flash('success','post updated successfully');

      return redirect()->back(); 

   }

   public function post_per_channel($postID,$channelID){
      $post = posts::where('businessID',Auth::user()->businessID)->where('id',$postID)->first();
      $channel = post_channel::join('crm_marketing_channels','crm_marketing_channels.id','=','crm_marketing_post_channel.channelID')
                  ->where('crm_marketing_channels.businessID', Auth::user()->businessID)
                  ->where('crm_marketing_channels.id',$channelID)
                  ->first();
      return view('app.crm.socialmedia.publications.show', compact('post','channel'));

   }

   public function publish($postID,$channelID){
      
   }
}
 