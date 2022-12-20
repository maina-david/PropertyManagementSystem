<?php

namespace App\Http\Controllers\app\property;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\property;
use App\Models\wingu\file_manager as documents; 
use Auth;
use Session;
use Wingu; 
use Helper;
use File;

class documentsController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }
   
   //document list
   public function index($id){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      if($property->property_code == ""){
         $code = Helper::generateRandomString(12);
         $property->property_code = $code;
         $property->save();
      }

      //get prioerty again
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $documents = documents::where('fileID',$id)->where('businessID',Auth::user()->businessID)->where('section','Property/documents')->orderby('id','desc')->get();
      $propertyID = $id;

      return view('app.property.property.documents', compact('property','documents','propertyID'));
   }

   //add document
   public function upload_document(Request $request,$id){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$request->propertyID)->first();

		//directory
		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/documents/';

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

      $upload->fileID      = $request->propertyID;
		$upload->folder 	   = $property->property_code;
		$upload->section 	   = 'property/documents';
		$upload->name 		   = $property->title;
		$upload->file_name   = $filename;
      $upload->file_size   = $size;
		$upload->attach 	   = 'No';
      $upload->file_mime   = $file->getClientMimeType();
		$upload->created_by  = Auth::user()->id;
		$upload->businessID  = Auth::user()->businessID;
      $upload->save();

		//recorord activity
		$activities = Auth::user()->name.' Has uploaded document(s) to property -'.$property->title;
		$section = 'Property';
		$type = 'Documents';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
		$activityID = $id;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);
   }

   //delete document
   public function delete($propertyID,$documentID){
      //document information 
      $document = documents::where('fileID',$propertyID)->where('id',$documentID)->where('businessID',Auth::user()->businessID)->where('section','Property/documents')->first();

      $property = property::where('id','=',$propertyID)->where('businessID',Auth::user()->businessID)->first();

      $path = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/documents/';

      //delete document from folder
      $oldimagename = documents::where('id','=',$documentID)->where('fileID',$propertyID)->where('businessID',Auth::user()->businessID)->select('file_name')->first();
      
      $delete = $path.$oldimagename->file_name;
      
      if (File::exists($delete)) {
         unlink($delete);
      }

      //update document        
      $document->delete();

      Session::flash('success','Document successfully delete');

      return redirect()->back();
   }

   //update documents
   public function update(Request $request,$propertyID,$documentID){
      $document = documents::where('fileID',$propertyID)->where('id',$documentID)->where('businessID',Auth::user()->businessID)->first();

      $document->name = $request->name;
      $document->description = $request->description;
      $document->save();

      Session::flash('success','Document successfully updated');

      return redirect()->back();
   }
}
