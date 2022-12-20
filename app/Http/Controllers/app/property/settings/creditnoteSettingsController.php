<?php
namespace App\Http\Controllers\app\property\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\creditnote\creditnote_settings;
use App\Models\property\property as building;
use Auth;
use Session;
use Property;

class creditnoteSettingsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      //
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
      //
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
      $property = building::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      //check if property has settings
      $check = creditnote_settings::where('propertyID',$id)->where('businessID',Auth::user()->businessID)->count();
      if($check != 1){
         Property::make_creditnote_settings($id);
      }

      //get invoice settings information
      $settings = creditnote_settings::where('propertyID',$id)->where('businessID',Auth::user()->businessID)->first();
      $propertyID = $id;

      return view('app.property.accounting.creditnote.settings', compact('property','settings','propertyID'));
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
      $update = creditnote_settings::where('id',$id)->where('propertyID',$request->propertyID)->where('businessID',Auth::user()->businessID)->first();
      $update->number = $request->number;
      $update->prefix = $request->prefix;
      $update->default_terms_conditions = $request->default_terms_conditions;
      $update->default_customer_notes = $request->default_customer_notes;
      $update->default_footer = $request->default_footer;
      $update->updated_by = Auth::user()->id;
      $update->businessID = Auth::user()->businessID;
      $update->save();

      Session::flash('success','Creditnote settings successfully updates');

      return redirect()->back();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
