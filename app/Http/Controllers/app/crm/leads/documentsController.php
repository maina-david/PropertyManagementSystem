<?php

namespace App\Http\Controllers\app\crm\leads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\wingu\file_manager as documents; 
use Mail;
use Session;
use Auth;
use Wingu; 
use Helper;
use File;

class documentsController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
	}

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($id)
   {
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $folder = 'customer/'.$lead->reference_number;
      $documents = documents::where('fileID',$id)
                  ->where('businessID',Auth::user()->businessID)
                  ->where('folder',$folder)
                  ->where('section','customer')
                  ->orderby('id','desc')
                  ->paginate(18);
      $customerID = $id;
      return view('app.crm.leads.show', compact('lead','customerID','documents'));
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
      $this->validate($request,[
         'document_name' => 'required',
         'document' => 'required|file|max:5024',
         'customerID' => 'required',
      ]);
      
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$request->customerID)->first();
      $folder = 'customer/'.$lead->reference_number;

      $upload = new documents;
      //directory
      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/'.$folder.'/';

      //create directory if it doesn't exists
      if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
      }

      //upload estimate to system
      $file = $request->document;

      $size =  $file->getSize();

      // GET THE FILE EXTENSION
      $extension = $file->getClientOriginalExtension();

      // RENAME THE UPLOAD WITH RANDOM NUMBER
      $fileName = Helper::generateRandomString(9). '.' . $extension;

      // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
      $file->move($directory, $fileName);

      $upload->file_name = $fileName;
      $upload->file_mime = $file->getClientMimeType();
      $upload->file_size = $size;
      $upload->name = $request->document_name;
      $upload->fileID = $request->customerID;
      $upload->folder = $folder;
      $upload->section = 'customer';
      $upload->description = $request->description;
      $upload->businessID = Auth::user()->businessID;
      $upload->created_by = Auth::user()->id;
      $upload->save();

      Session::flash('success','document uploaded successfully');

      return redirect()->back();
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
      $this->validate($request,[
         'name' => 'required',
         'document' => 'required|file|max:5024',
         'customerID' => 'required',
      ]);

      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$request->customerID)->first();
      $folder = 'customer/'.$lead->reference_number;

      $upload = documents::where('businessID',Auth::user()->businessID)->where('id',$id)->where('folder','crm')->where('section','customer')->first();

      //directory
      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/'.$folder.'/';

      //delete document if already exists
		if($upload->file_name != ""){
			$unlink = $directory.$upload->file_name;
			if (File::exists($unlink)) {
				unlink($unlink);
			}
		}

      //create directory if it doesn't exists
      if (!file_exists($directory)) {
         mkdir($directory, 0777,true);
      }

      //upload estimate to system
      $file = $request->document;

      $size =  $file->getSize();

      // GET THE FILE EXTENSION
      $extension = $file->getClientOriginalExtension();

      // RENAME THE UPLOAD WITH RANDOM NUMBER
      $fileName = Helper::generateRandomString(9). '.' . $extension;

      // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
      $file->move($directory, $fileName);

      $upload->file_name = $fileName;
      $upload->file_mime = $file->getClientMimeType();
      $upload->file_size = $size;
      $upload->name = $request->name;
      $upload->fileID = $request->customerID;
      $upload->folder = $folder;
      $upload->section = 'customer';
      $upload->description = $request->description;
      $upload->businessID = Auth::user()->businessID;
      $upload->updated_by = Auth::user()->id;
      $upload->save();

      Session::flash('success','document updated successfully');

      return redirect()->back();
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function delete($id,$customerID)
   {
      $lead = customers::where('businessID',Auth::user()->businessID)->where('id',$customerID)->first();
      $folder = 'customer/'.$lead->reference_number;
      $delete = documents::where('businessID',Auth::user()->businessID)->where('folder',$folder)->where('section','customer')->where('id',$id)->first();

      $directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/'.$folder.'/';
      
      //delete document if already exists
		if($delete->file_name != ""){
			$unlink = $directory.$delete->file_name;
			if (File::exists($unlink)) {
				unlink($unlink);
			}
		}
      $delete->delete();

      Session::flash('success','document deleted successfully');

      return redirect()->back();
   }
}
