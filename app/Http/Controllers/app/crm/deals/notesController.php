<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\deals;
use App\Models\crm\notes;
use Auth;
use Session;

class notesController extends Controller
{

   public function __construct(){
      $this->middleware('auth');
   }

   //index
   public function index($id){
      $deal = deals::join('business','business.id','=','deals.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->where('deals.id',$id)
                     ->where('deals.businessID',Auth::user()->businessID)
                     ->orderby('deals.id','desc')
                     ->select('*','deals.id as dealID','deals.created_at as create_date')                     
                     ->first();

      $stages = stages::where('pipelineID',$deal->pipeline)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->get();
      $notes = notes::where('parentID',$id)->where('businessID',Auth::user()->businessID)->where('section','Deal')->orderby('id','desc')->get();

      return view('app.crm.deals.deal.show', compact('deal','stages','notes'));
   }

   /**
   * store call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request, $id){
      $this->validate($request,[
         'subject' => 'required',
         'note' => 'required',
         'dealID' => 'required',
      ]);

      $notes = new notes;
      $notes->subject = $request->subject;
      $notes->note = $request->note;
      $notes->parentID = $id;
      $notes->created_by = Auth::user()->id;
      $notes->businessID = Auth::user()->businessID;
      $notes->section = 'Deal';
      $notes->save();

      Session::flash('success','Note successfully added');

      return redirect()->back();
   }


   /**
   * update call logs
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id){
      $this->validate($request,[
         'subject' => 'required',
         'note' => 'required',
         'dealID' => 'required',
      ]);

      $notes = notes::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $notes->subject = $request->subject;
      $notes->note = $request->note;
      $notes->parentID = $request->dealID;
      $notes->created_by = Auth::user()->id;
      $notes->businessID = Auth::user()->businessID;
      $notes->section = 'Deal';
      $notes->save();

      Session::flash('success','Note successfully updated');

      return redirect()->back();
   }

   /**
   * delete
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($id){
      notes::where('businessID',Auth::user()->businessID)->where('section','Deal')->where('id',$id)->delete();
      Session::flash('success','Call successfully deleted');
      return redirect()->back();
   }

}
