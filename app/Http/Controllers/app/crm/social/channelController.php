<?php

namespace App\Http\Controllers\app\crm\digitalmarketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\crm\digital\medium;
use App\Models\crm\digital\channels;
use Session;
use Auth;
class channelController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($id)
   {
      $mediums = medium::pluck('name','id')->prepend('Choose medium','');
      $channels = channels::join('crm_marketing_medium','crm_marketing_medium.id','=','crm_marketing_channels.mediumID')
                  ->where('businessID',Auth::user()->businessID)
                  ->where('accountID',$id)
                  ->select('*','crm_marketing_channels.id as channelID','crm_marketing_channels.created_at as channel_date')
                  ->get();
      $count = 1;
      $accountID = $id;
      return view('app.crm.socialmedia.channels.index', compact('mediums','count','accountID','channels'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'medium' => 'required',
         'channel_name' => 'required',
         'accountID' => 'required',
      ]);

      $channel = new channels;
      $channel->accountID = $request->accountID;
      $channel->mediumID = $request->medium;
      $channel->channel_name = $request->channel_name;
      $channel->client_id = $request->client_id;
      $channel->client_secret = $request->client_secret;
      $channel->channel_name = $request->channel_name;
      $channel->businessID = Auth::user()->businessID;
      $channel->userID = Auth::user()->id;
      $channel->save();

      Session::flash('success','Channel successfully added');

      return redirect()->back();
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($accountID,$id)
   {
      $edit = channels::where('accountID',$accountID)->where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $mediums = medium::pluck('name','id')->prepend('Choose medium','');
      $channels = channels::join('crm_marketing_medium','crm_marketing_medium.id','=','crm_marketing_channels.mediumID')
                  ->where('businessID',Auth::user()->businessID)
                  ->select('*','crm_marketing_channels.id as channelID','crm_marketing_channels.created_at as channel_date')
                  ->get();
      $count = 1;
      $accountID = $id;

      return view('app.crm.socialmedia.channels.edit', compact('mediums','count','accountID','channels','edit'));

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      $this->validate($request, [
         'mediumID' => 'required',
         'channel_name' => 'required',
         'accountID' => 'required',
      ]);

      $channel = channels::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $channel->accountID = $request->accountID;
      $channel->mediumID = $request->mediumID;
      $channel->channel_name = $request->channel_name;
      $channel->client_id = $request->client_id;
      $channel->client_secret = $request->client_secret;
      $channel->channel_name = $request->channel_name;
      $channel->businessID = Auth::user()->businessID;
      $channel->userID = Auth::user()->id;
      $channel->save();

      Session::flash('success','Channel successfully updated');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function delete($id)
   {
      $channel = channels::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $channel->delete();

      Session::flash('success','Channel successfully deleted');

      return redirect()->route('crm.channel.index',$channel->accountID);
   }
}
