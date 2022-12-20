<?php
namespace App\Http\Controllers\app\finance\contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\customer\customers;
use App\Models\wingu\file_manager as documents; 
use App\Models\finance\customer\contact_persons;
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
      $customerID = $id;
      $client = customers::join('customer_address','customer_address.customerID','=','customers.id')
               ->join('business','business.id','=','customers.businessID')
               ->join('currency','currency.id','=','business.base_currency')
               ->where('customers.id',$id)
               ->where('customers.businessID',Auth::user()->businessID)
               ->select('*','customers.id as cid')
               ->first();

      $folder = 'customer/'.$client->customer_code.'/documents';
      $documents = documents::where('fileID',$id)
                  ->where('businessID',Auth::user()->businessID)
                  ->where('folder',$folder)
                  ->where('section','customer')
                  ->orderby('id','desc')
                  ->paginate(18);

      //contacts
      $contacts = contact_persons::where('customerID',$customerID)->where('businessID',Auth::user()->businessID)->get();

      return view('app.finance.contacts.view', compact('client','customerID','contacts','documents'));
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
         'leadID' => 'required',
      ]);
      
      $customer = customers::where('businessID',Auth::user()->businessID)->where('id',$request->leadID)->first();
      $folder = 'customer/'.$customer->customer_code.'/documents';

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
      $fileName = Helper::generateRandomString(15). '.' . $extension;

      // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
      $file->move($directory, $fileName);

      $upload->file_name = $fileName;
      $upload->file_mime = $file->getClientMimeType();
      $upload->file_size = $size;
      $upload->name = $request->document_name;
      $upload->fileID = $request->leadID;
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
         'leadID' => 'required',
      ]);

      $customer = customers::where('businessID',Auth::user()->businessID)->where('id',$request->leadID)->first();
      $folder = 'customer/'.$customer->customer_code.'/documents';

      $upload = documents::where('businessID',Auth::user()->businessID)->where('id',$id)->where('folder',$folder)->where('section','customer')->first();

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
      $fileName = Helper::generateRandomString(15). '.' . $extension;

      // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
      $file->move($directory, $fileName);

      $upload->file_name = $fileName;
      $upload->file_mime = $file->getClientMimeType();
      $upload->file_size = $size;
      $upload->name = $request->name;
      $upload->fileID = $request->leadID;
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
   public function delete($id,$leadID)
   {
      $customer = customers::where('businessID',Auth::user()->businessID)->where('id',$leadID)->first();
      $folder = 'customer/'.$customer->customer_code.'/documents';
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
