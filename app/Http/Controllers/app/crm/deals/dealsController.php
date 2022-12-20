<?php

namespace App\Http\Controllers\app\crm\deals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\hr\employees;
use App\Models\finance\customer\customers;
use App\Models\crm\deals\pipeline;
use App\Models\crm\deals\stages;
use App\Models\crm\notes;
use App\Models\crm\calllog;
use App\Models\crm\deals\deals;
use App\Models\crm\deals\appointments;
use App\Models\crm\deals\tasks;
use Auth;
use Session;
 
class dealsController extends Controller
{

   public function __construct(){
      $this->middleware('auth');
   }

   //list
   public function index(){
      $deals = deals::join('business','business.id','=','deals.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->where('deals.businessID',Auth::user()->businessID)
                     ->orderby('deals.id','desc')
                     ->select('*','deals.id as dealID')
                     ->get();
      $count = 1;
      return view('app.crm.deals.deal.index', compact('deals','count'));
   }

   //create deal
   public function create(){
      $pipelines = pipeline::where('businessID',Auth::user()->businessID)->orderby('id','desc')->pluck('title','id')->prepend('choose pipeline','');
      $employees = employees::where('businessID',Auth::user()->businessID)->where('statusID',25)->orderby('id','desc')->pluck('names','id')->prepend('choose employee','');
      $customers = customers::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->pluck('customer_name','id')->prepend('choose customers','');

      return view('app.crm.deals.deal.create', compact('pipelines','employees','customers'));
   }

   //get stages
   public function stages($id){
      $stages = stages::where('pipelineID',$id)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->get();
      return \Response::json($stages);
   }

   //store
   public function store(Request $request){
      $this->validate($request,[
         'title' => 'required',
      ]);

      $deals = new deals;
      $deals->title = $request->title; 
      $deals->pipeline = $request->pipeline; 
      $deals->stage = $request->stage;
      $deals->value = $request->value;
      $deals->contact = $request->contact;
      $deals->owner = $request->owner;
      $deals->account = $request->account;
      $deals->status = $request->status;
      $deals->close_date = $request->close_date;
      $deals->description = $request->description; 
      $deals->businessID = Auth::user()->businessID;
      $deals->created_by = Auth::user()->id;
      $deals->save();

      Session::flash('success','Deal successfully added');

      return redirect()->route('crm.deals.index');
   }

   //edit 
   public function edit($id){
      $edit = deals::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $pipelines = pipeline::where('businessID',Auth::user()->businessID)->orderby('id','desc')->pluck('title','id')->prepend('choose pipeline','');
      $employees = employees::where('businessID',Auth::user()->businessID)->where('statusID',25)->orderby('id','desc')->pluck('names','id')->prepend('choose employee','');
      $customers = customers::where('businessID',Auth::user()->businessID)->whereNull('category')->OrderBy('id','DESC')->pluck('customer_name','id')->prepend('choose customers','');

      return view('app.crm.deals.deal.edit', compact('pipelines','employees','customers','edit'));
   }

   //show 
   public function show($id){
      $deal = deals::join('business','business.id','=','deals.businessID')
                     ->join('currency','currency.id','=','business.base_currency')
                     ->where('deals.id',$id)
                     ->where('deals.businessID',Auth::user()->businessID)
                     ->orderby('deals.id','desc')
                     ->select('*','deals.id as dealID','deals.created_at as create_date')                     
                     ->first();

      $stages = stages::where('pipelineID',$deal->pipeline)->where('businessID',Auth::user()->businessID)->orderby('position','asc')->get();
      $Totalcalllogs = calllog::where('parentID',$id)->where('businessID',Auth::user()->businessID)->where('section','Deal')->orderby('id','desc')->count();
      $Totalnotes = notes::where('parentID',$id)->where('businessID',Auth::user()->businessID)->where('section','Deal')->count();
      $Totaltasks = tasks::where('businessID',Auth::user()->businessID)->where('dealID',$id)->count();
      $Totalappointments = appointments::where('dealID',$id)->where('businessID',Auth::user()->businessID)->count();

      return view('app.crm.deals.deal.show', compact('deal','stages','Totalcalllogs','Totalnotes','Totaltasks','Totalappointments'));
   }

   //update
   public function update(Request $request,$id){
      $this->validate($request,[
         'title' => 'required',
      ]);

      $deals = deals::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $deals->title = $request->title; 
      $deals->pipeline = $request->pipeline; 
      $deals->stage = $request->stage;
      $deals->value = $request->value;
      $deals->contact = $request->contact;
      $deals->owner = $request->owner;
      $deals->account = $request->account;
      $deals->status = $request->status;
      $deals->close_date = $request->close_date;
      $deals->description = $request->description; 
      $deals->businessID = Auth::user()->businessID;
      $deals->updated_by = Auth::user()->id;
      $deals->save();

      Session::flash('success','Deal successfully updated');

      return redirect()->back();
   }

   //delete
   public function delete($id){
      deals::where('businessID',Auth::user()->businessID)->where('id',$id)->delete();
      Session::flash('success','Deal successfully deleted');
      return redirect()->back();
   }


}
