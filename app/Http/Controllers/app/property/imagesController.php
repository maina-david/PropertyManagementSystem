<?php
namespace App\Http\Controllers\app\property;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\property\property;
use App\Models\wingu\file_manager as documents;
use Auth;
use Session;
use Wingu;
use Helper;
use File;


class imagesController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   //image list
   public function index($id){

      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      if($property->property_code == ""){
         $code = Helper::generateRandomString(12);
         $property->property_code = $code;
         $property->save();
      }

      //get prioerty again
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $images = documents::where('fileID',$id)->where('businessID',Auth::user()->businessID)->where('section','Property/images')->orderby('id','desc')->get();
      $propertyID = $id;

      return view('app.property.property.images', compact('property','images','propertyID'));
   }

   //add images
   public function upload_image(Request $request,$id){
      //get property
      $checkProp = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      if($checkProp->parentID == 0){
         $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      }else{
         $property = property::where('businessID',Auth::user()->businessID)->where('id',$checkProp->parentID)->first();
      }

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/images/';

		//create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

		//get file name
		$file = $request->file('file');
		$size =  $file->getSize();

      //change file name
      $filename = Helper::generateRandomString().$file->getClientOriginalName();

      //move file
		$file->move($directory, $filename);

      //save the upload details into the database

		$upload = new documents;

      $upload->fileID      = $id;
		$upload->folder 	   = $property->property_code;
		$upload->section 	   = 'property/images';
		$upload->name 		   = $property->title;
		$upload->file_name   = $filename;
      $upload->file_size   = $size;
		$upload->attach 	   = 'No';
      $upload->file_mime   = $file->getClientMimeType();
		$upload->created_by  = Auth::user()->id;
		$upload->businessID  = Auth::user()->businessID;
      $upload->save();

		//recorord activity
		$activities = Auth::user()->name.' Has uploaded image(s) to property -'.$property->title;
		$section = 'Property';
		$type = 'Images';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
		$activityID = $id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);
   }

   //delete image
   public function delete($propertyID,$imageID){
      //image information
      $image = documents::where('fileID',$propertyID)->where('id',$imageID)->where('businessID',Auth::user()->businessID)->where('section','property/images')->first();

      $property = property::where('id','=',$propertyID)->where('businessID',Auth::user()->businessID)->first();

      $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->propertyID.'/property/'.$property->property_code.'/images/';

      //delete image from folder
      $oldimagename = documents::where('id','=',$imageID)->where('fileID',$propertyID)->where('businessID',Auth::user()->businessID)->select('file_name')->first();

      $delete = $path.$oldimagename->file_name;

      if (File::exists($delete)) {
         unlink($delete);
      }

      //update image
      $image->delete();

      Session::flash('success','Image successfully delete');

      return redirect()->back();
   }
}
