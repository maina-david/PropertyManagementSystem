<?php

namespace App\Http\Controllers\app\property\tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\property\tenants\tenants;
use App\Models\property\lease;
use App\Models\property\tenants\notes;
use App\Models\property\utilities;
use App\Models\property\lease_utility;
use App\Models\wingu\business;
use App\Models\finance\tax;
use Helper;
use Auth;
use Session;
use Response;

class notesController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   }
   
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index($propertyID,$tenantID)
   {
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->first();

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $tenant = tenants::join('tenant_address','tenant_address.tenantID','=','tenants.id')
								->where('tenants.id',$tenantID)
								->select('*','tenants.id as tenantID')
                        ->first();
                        
      $notes = notes::where('tenantID',$tenantID)->where('businessID',Auth::user()->businessID)->orderby('id','desc')->paginate(6);
      
      $count = 1;


      return view('app.property.tenants.view', compact('property','count','propertyID','tenantID','tenant','notes','business'));
   }

    /**
   * store note
   *
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request){
      $this->validate($request,[
         'subject' => 'required',
         'note' => 'required',
         'tenantID' => 'required',
      ]);

      $note = new notes;
      $note->subject = $request->subject;
      $note->note = $request->note;
      $note->tenantID = $request->tenantID;
      $note->created_by = Auth::user()->id;
      $note->businessID = Auth::user()->businessID;
      $note->save();

      Session::flash('success','Note successfully added');

      return redirect()->back();
   }

   /**
   * update note
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id){
      $this->validate($request,[
         'note' => 'required',
         'tenantID' => 'required',
      ]);

      $note = notes::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $note->subject = $request->subject;
      $note->note = $request->note;
      $note->tenantID = $request->tenantID;
      $note->updated_by = Auth::user()->id;
      $note->businessID = Auth::user()->businessID;
      $note->save();

      Session::flash('success','Note successfully updated');

      return redirect()->back();
   }

   /**
   * delete note
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($id){
      notes::where('businessID',Auth::user()->businessID)->where('id',$id)->delete();
      Session::flash('success','Note successfully deleted');
      return redirect()->back();
   }
}
