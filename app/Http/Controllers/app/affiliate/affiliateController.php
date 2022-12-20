<?php

namespace App\Http\Controllers\app\affiliate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\affiliate\affiliate;
use Session;
use Input;
use Helper;


class affiliateController extends Controller
{
    public function index(){
        $affiliate = affiliate::OrderBy('id','DESC')->get();
        return view('app.cms.affiliate.index')->withAffiliates($affiliate);
    }

    public function create(){
        return view('app.cms.affiliate.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'website' => 'required',
            'status' => 'required',
        ]);

        $affiliate = new affiliate;

        if(!empty($request->avator)){
            $file = Input::file('avator');
            // SET UPLOAD PATH
            $destinationPath = base_path().'/public/media/affiliate/';
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(). '.' . $extension;
            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($destinationPath, $fileName);

            $affiliate->avator = $fileName;
        }

        $affiliate->name = $request->name;
        $affiliate->website = $request->website;
        $affiliate->status = $request->status;
        $affiliate->description = $request->description;

        $affiliate->save();

        Session::flash('Success','Affiliate Successfully Added');

        return redirect()->route('affiliate.edit',$affiliate->id);
    }

    public function edit($id){
        $affiliate = affiliate::find($id);
        return view('app.cms.affiliate.edit')->withAffiliate($affiliate);
    }

    public function update(Request $request,$id){
        $this->validate($request, [
            'name' => 'required',
            'website' => 'required',
            'status' => 'required',
        ]);

        $affiliate = affiliate::find($id);

        if(!empty($request->avator)){

            $check = affiliate::where('id','=',$id)->where('avator','=',"")->count();

            if ($check > 0){
                $oldimage = affiliate::where('id','=',$id)->select('avator')->first();

                $image_path = base_path().'/public/media/affiliate/'.$oldimage->avator;

                if (File::exists($image_path)) {
                    unlink($image_path);
                }
            }


            $file = Input::file('avator');
            // SET UPLOAD PATH
            $destinationPath = base_path().'/public/media/affiliate/';
            // GET THE FILE EXTENSION
            $extension = $file->getClientOriginalExtension();

            // RENAME THE UPLOAD WITH RANDOM NUMBER
            $fileName = Helper::generateRandomString(). '.' . $extension;
            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY
            $upload_success = $file->move($destinationPath, $fileName);

            $affiliate->avator = $fileName;
        }

        $affiliate->name = $request->input('name');
        $affiliate->website = $request->input('website');
        $affiliate->status = $request->input('status');
        $affiliate->description = $request->input('description');

        $affiliate->save();

        Session::flash('Success','Affiliate Successfully Added');

        return redirect()->route('affiliate.edit',$affiliate->id);
    }

    public function delete($id){
        //delete image from folder/directory
        $check = affiliate::where('id','=',$id)->where('avator','=',"")->count();

        if($check > 0){
            $oldimagename = affiliate::where('id','=',$id)->select('avator')->first();

            $image_path = base_path().'/public/media/affiliate/'.$oldimagename->avator;

            if (File::exists($image_path)) {
                unlink($image_path);
            }
        }

        $affiliate = affiliate::find($id);

        $affiliate->delete();

        Session::flash('Success', 'Affiliate was successfully deleted !');

        return redirect()->route('affiliate.index');
    }
}
