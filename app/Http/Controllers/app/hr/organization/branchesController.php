<?php

namespace App\Http\Controllers\app\hr\organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\product_inventory;
use App\Models\finance\products\product_price;
use App\Models\hr\branches;
use App\Models\wingu\country;
use Auth;
use Session;
class branchesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $branches = branches::where('businessID',Auth::user()->businessID)
                  ->select('*','hr_branches.id as branchID')
                  ->orderby('hr_branches.id','desc')
                  ->get();
      $count = 1;
      return view('app.hr.organization.branches.index', compact('branches','count'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      $country = country::pluck('name','id')->prepend('Choose country','');
      return view('app.hr.organization.branches.create', compact('country'));
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
         'branch_name' => 'required',
         'phone_number' => 'required',
      ]);


      //check if is main branch
      if($request->main_branch == 'Yes'){
         branches::where('businessID',Auth::user()->businessID)
                  ->where('main_branch','Yes')
                  ->update(['main_branch' => 'No']);
      }

      
      $branches = new branches;
      $branches->branch_name = $request->branch_name;
      $branches->countryID = $request->countryID;
      $branches->city = $request->city;
      $branches->address = $request->address;
      $branches->phone_number = $request->phone_number;
      $branches->email = $request->email;
      $branches->main_branch = $request->main_branch;
      $branches->businessID = Auth::user()->businessID;
      $branches->userID = Auth::user()->id;
      $branches->save();

      //check if the account has a main branch, if it doesnt make the updated or added branch as main, this is usefull on the p.o.s inventroy section and item price section
      $checkMainBranch = branches::where('businessID',Auth::user()->businessID)->where('main_branch','Yes')->count();
      if($checkMainBranch == 0){
         //make the new branch main
         $update = branches::where('businessID',Auth::user()->businessID)->where('id',$branches->id)->first();
         $update->main_branch = 'Yes';
         $update->save();
      }

      Session::flash('success','branch successfully added');

      return redirect()->route('hrm.branches');
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
   public function edit($id)
   {
      $country = country::pluck('name','id')->prepend('Choose country','');
      $edit = branches::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      return view('app.hr.organization.branches.edit', compact('country','edit'));
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
         'branch_name' => 'required',
         'phone_number' => 'required',
      ]);

      if($request->main_branch == 'Yes'){
         branches::where('businessID',Auth::user()->businessID)
                  ->where('main_branch','Yes')
                  ->update(['main_branch' => 'No']);
      }

      $branches = branches::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $branches->branch_name = $request->branch_name;
      $branches->countryID = $request->countryID;
      $branches->city = $request->city;
      $branches->address = $request->address;
      $branches->phone_number = $request->phone_number;
      $branches->main_branch = $request->main_branch;
      $branches->email = $request->email;
      $branches->businessID = Auth::user()->businessID;
      $branches->userID = Auth::user()->id;
      $branches->save();

      //check if the account has a main branch, if it doesnt make the updated or added branch as main, this is usefull on the p.o.s inventroy section and item price section
      $checkMainBranch = branches::where('businessID',Auth::user()->businessID)->where('main_branch','Yes')->count();
      if($checkMainBranch == 0){
         //make the new branch main
         $update = branches::where('businessID',Auth::user()->businessID)->where('id',$branches->id)->first();
         $update->main_branch = 'Yes';
         $update->save();
      }

      Session::flash('success','branch successfully updated');

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
      //check if is linked to product inventory
      $checkInventryLink = product_inventory::where('branch_id',$id)->where('businessID',Auth::user()->businessID)->count();
      $checkPriceLink = product_price::where('branch_id',$id)->where('businessID',Auth::user()->businessID)->count();
      if($checkInventryLink == 0 && $checkPriceLink == 0){
         //delete branch
         $branches = branches::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
         $branches->delete();

         Session::flash('success','branch successfully updated');

         return redirect()->route('hrm.branches');
      }else{

         Session::flash('warning','This branch has inventory that are linked to it');

         return redirect()->back();
      }
      
   }
}
