<?php

namespace App\Http\Controllers\app\finance\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\products\attributes;
use Wingu;
use Session;
use Auth;

class attributeValueController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $attribute = attributes::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
        $values = attributes::where('parentID',$id)->where('businessID',Auth::user()->businessID)->get();
        $count = 1;

        return view('app.finance.products.attributes.values.index', compact('attribute','count','values'));
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
            'value' => 'required'
        ]);

        $value = new attributes;
        $value->value = $request->value;
        $value->parentID = $request->attributeID;
        $value->businessID = Auth::user()->businessID;
        $value->userID = Auth::user()->id;
        $value->save();

        Session::flash('success','value added successfully');

        return redirect()->back();
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
        $edit = attributes::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
        $attribute = attributes::where('businessID',Auth::user()->businessID)->where('id',$edit->parentID)->first();
        $values = attributes::where('parentID',$edit->parentID)->where('businessID',Auth::user()->businessID)->get();
        $count = 1;

        return view('app.finance.products.attributes.values.edit', compact('attribute','count','values','edit'));
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
            'value' => 'required'
        ]);

        $edit = attributes::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
        $edit->value = $request->value;
        $edit->parentID = $request->attributeID;
        $edit->businessID = Auth::user()->businessID;
        $edit->userID = Auth::user()->id;
        $edit->save();

        Session::flash('success','value updated successfully');

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

        $delete = attributes::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
        $delete->delete();

        Session::flash('success','value deleted successfully');

        return redirect()->route('finance.product.attributes.value.create',$delete->parentID);
    }
}
