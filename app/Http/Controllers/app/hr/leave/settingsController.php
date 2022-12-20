<?php
namespace App\Http\Controllers\app\hr\leave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\type;
use Session;
use Wingu;
use Auth;
class settingsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$types = type::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get();
		$count = 1;

		return view('app.hr.leave.settings.index', compact('types','count'));
	}

	/**
	 * store leave type
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store_type(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
		]);

		$store = new type;
		$store->name = $request->name;
		$store->created_by = Auth::user()->id;
		$store->businessID = Auth::user()->businessID;
		$store->save();

		Session::flash('success','Leave type successfully added');

		return redirect()->back();
	}

	/**
	 * holiday
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function holiday()
	{
		return view('app.hr.leave.settings.index');
	}

	/**
	 * workdays settings
	 *
	 */
	public function workdays()
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
		//
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$type = type::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		$type->delete();

		Session::flash('success','Leave type successfully deleted');

		return redirect()->back();
	}
}
