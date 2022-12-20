<?php

namespace App\Http\Controllers\app\property\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\wingu\business;
use App\Models\property\property;
use App\Models\property\listings;
use App\Models\property\type;
use App\Models\wingu\file_manager as documents;
use Auth;
use Session;
use File;
use Wingu;
use Helper;

class listingController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
   * add to listing
   *
   * @return \Illuminate\Http\Response
   */
   public function add_to_list($propertyID){

      //check if property has an active listing
      $check = listings::where('status',15)->where('propertyID',$propertyID)->count();

      if($check == 0){
         $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->first();
         $property->listing_status = 49;
         $property->save();

         $listing = new listings;
         $listing->propertyID = $propertyID;
         $listing->title = $property->title;
         $listing->status = 15;
         if($property->title != ""){
            $url = Helper::seoUrl($property->title).'-'.Helper::generateRandomString(5);
         }else{
            $url = Helper::generateRandomString(10);
         }
         $listing->url = $url;
         $listing->type = $property->property_type;
         $listing->businessID = Auth::user()->businessID;
         $listing->listing_code = Helper::generateRandomString(10);
         $listing->created_by = Auth::user()->id;
         $listing->save();

         Session::flash('success','Property added to marketing list');

         return redirect()->route('property.lisitng');
      }

      Session::flash('warning','This property has an active listing');

      return redirect()->back();
   }

   /**
   * Listing
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){
      $business = business::join('currency','currency.id','=','business.base_currency')
                           ->where('business.id',Auth::user()->businessID)
                           ->first();

      $properties = listings::join('property','property.id','=','property_listings.propertyID')
                           ->join('status','status.id','=','property_listings.status')
                           ->where('property_listings.businessID',Auth::user()->businessID)
                           ->select('*','property_listings.id as listID','property_listings.propertyID as propertyID','property_listings.title as title','status.name as statusName','property_listings.price as price')
                           ->orderby('property_listings.id','desc')
                           ->get();
      $count = 1;
      return view('app.property.marketing.listing.index',compact('properties','count','business'));
   }

   /**
   * Edit list
   *
   * @return \Illuminate\Http\Response
   */
   public function edit($id){
      $property = listings::join('property','property.id','=','property_listings.propertyID')
                        ->where('property_listings.id',$id)
                        ->where('property_listings.businessID',Auth::user()->businessID)
                        ->select('*','property_listings.id as listID','property_listings.title as list_title','property.parentID as paro','property.id as propertyID','property_listings.price as price')
                        ->first();

      $images = documents::where('fileID',$property->propertyID)
                           ->where('businessID',Auth::user()->businessID)
                           ->where('section','property/images')
                           ->orderby('id','desc')
                           ->get();

      if($property->paro == 0){
         $parent = property::where('id',$property->propertyID)->where('businessID',Auth::user()->businessID)->first();
      }else{
         $parent = property::where('id',$property->paro)->where('businessID',Auth::user()->businessID)->first();
      }

      $types = type::where('status',15)->get();

      $unitType = type::find($property->property_type);
      $count = 1;

      return view('app.property.marketing.listing.edit',compact('property','types','unitType','unitType','images','parent'));
   }

   /**
   * Edit list
   *
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request){
      $this->validate($request, [
         'list_title' => 'required',
         'price' => 'required',
         'category' => 'required'
      ]);

      //validate the parent property to avoid users changing value via browser
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$request->propertyID)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');

         return redirect()->back();
      }

      $property = property::where('id',$request->propertyID)->where('businessID',Auth::user()->businessID)->first();
      $property->businessID = Auth::user()->businessID;
      $property->updated_by = Auth::user()->id;
      $property->year_built = $request->year_built;
      $property->bedrooms = $request->bedrooms;
      $property->ownwership_type = $request->ownwership_type;
      $property->bathrooms = $request->bathrooms;
      $property->parking_size = $request->parking_size;
      $property->size = $request->size;
      $property->geolocation = $request->geolocation;
      $property->latitude = $request->lat;
      $property->longitude = $request->lng;
      if($request->features != ""){
         $features = $request->features;
         $featimpload = implode(", ", $features);
         $property->features = substr($featimpload, 0);
      }
      if($request->amenities != ""){
         $amenities = $request->amenities;
         $amenimpload = implode(", ", $amenities);
         $property->amenities = substr($amenimpload, 0);
      }
      $property->smoking = $request->smoking;
      $property->laundry = $request->laundry;
      $property->furnished = $request->furnished;
      $property->description = $request->description;
      $property->save();

      //update listing
      $listing = listings::where('id',$request->listID)->where('businessID',Auth::user()->businessID)->first();
      if($listing->url == ""){
         if($listing->title != ""){
            $url = Helper::seoUrl($request->list_title).'-'.Helper::generateRandomString(5);
         }else{
            $url = Helper::generateRandomString(10);
         }
         $listing->url = $url;
      }
      if($listing->title != $request->list_title){
         $listing->url = Helper::seoUrl($request->list_title).'-'.Helper::generateRandomString(5);
      }
      if($listing->start_date == ""){
         $listing->start_date = date('Y-m-d');
      }else{
         $listing->start_date = $request->start_date;
      }
      $listing->end_date = $request->end_date;
      $listing->title = $request->list_title;
      $listing->category = $request->category;
      $listing->price = $request->price;
      $listing->updated_by = Auth::user()->businessID;
      $listing->save();

      Session::flash('success','The Listing has been successfully updated');

      return redirect()->back();
   }

   /**
   * Cancel Lisiting
   *
   * @return \Illuminate\Http\Response
   */
   public function cancel_listing($propertyID,$listID){
      $date = date('Y-m-d');
      $property = property::where('id',$propertyID)->where('businessID',Auth::user()->businessID)->where('listing_status',49)->first();
      $property->listing_status = NULL;
      $property->save();

      $listing = listings::where('id',$listID)->where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->first();
      $listing->status = 4;
      $listing->end_date = $date;
      $listing->updated_by = Auth::user()->id;
      $listing->save();

      Session::flash('success','Property Listing successfully stopped');

      return redirect()->route('property.lisitng');
   }

   /**
   * Show list
   *
   * @return \Illuminate\Http\Response
   */
   public function show($id){
      $property = property::where('id',$id)
                        ->where('businessID',Auth::user()->businessID)
                        ->where('listing_status',49)
                        ->first();
      $count = 1;
      return view('app.property.marketing.listing.show',compact('property'));
   }

   /**
   * Delete property image
   *
   * @return \Illuminate\Http\Response
   */
   public function delete_image($unitID,$imageID){
      $unit = property::where('id',$unitID)->where('businessID',Auth::user()->businessID)->first();

      if($unit->parentID == 0){
         $parentID = $unit->id;
      }else{
         $parentID = $unit->parentID;
      }
      //image information
      $image = documents::where('fileID',$unitID)->where('id',$imageID)->where('businessID',Auth::user()->businessID)->where('section','property/images')->first();

      $property = property::where('id','=',$parentID)->where('businessID',Auth::user()->businessID)->first();

      $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/images/';

      //delete image from folder
      $oldimagename = documents::where('id','=',$imageID)->where('fileID',$unitID)->where('businessID',Auth::user()->businessID)->select('file_name')->first();

      $delete = $path.$oldimagename->file_name;

      if (File::exists($delete)) {
         unlink($delete);
      }

      //update image
      $image->delete();

      Session::flash('success','Image successfully delete');

      return redirect()->back();
   }

   /**
   * Make image cover
   *
   * @return \Illuminate\Http\Response
   */
   public function image_cover($propertyID,$imageID){
      //reset all back to 0
      documents::where('fileID',$propertyID)
               ->where('businessID',Auth::user()->businessID)
               ->where('section','property/images')
               ->update(['cover' => 0]);

      $image = documents::where('fileID',$propertyID)->where('id',$imageID)->where('businessID',Auth::user()->businessID)->where('section','property/images')->first();
      $image->cover = 1;
      $image->save();

      Session::flash('success', 'Cover images has been selected');

      return redirect()->back();
   }


   /**
   * Cancel Lisiting
   *
   * @return \Illuminate\Http\Response
   */
   public function delete($listID){

      //delete listing
      listings::where('id',$listID)->where('businessID',Auth::user()->businessID)->delete();

      Session::flash('success','Listing successfully deleted');

      return redirect()->route('property.lisitng');
   }
}
