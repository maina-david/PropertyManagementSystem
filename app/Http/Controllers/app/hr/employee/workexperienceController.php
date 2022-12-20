<?php
namespace App\Http\Controllers\app\hr\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\hr\jobs_experience;
use App\Models\hr\employees;
use Session;
use Auth;
class workexperienceController extends Controller
{
	public function __construct(){
	$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$experiences = jobs_experience::where('employeeID',$id)->where('businessID',Auth::user()->businessID)->get();
		$count = 1;
		$employee = employees::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

		return view('app.hr.employee.experience', compact('count','experiences','employee'));
	}

	public function store(Request $request){
		$size = count(collect($request->prev_company));
		if($size > 0){
			for($i=0; $i < count($request->prev_company); $i++ ) {
				$experience = new jobs_experience;
				$experience->previous_company_name = $request->prev_company[$i];
				$experience->job_title = $request->prev_job_title[$i];
				$experience->date_started = $request->prev_from[$i];
				$experience->date_stopped = $request->prev_to[$i];
				$experience->job_description = $request->prev_job_description[$i];
				$experience->employeeID = $request->employeeID[$i];
				$experience->businessID = Auth::user()->businessID;
				$experience->userID = Auth::user()->id;
				$experience->save();
			}

			Session::flash('success','Previous Work experience information has been successfully updated');
		}else{
			Session::flash('error','Please add a previous work experience');
		}

		return redirect()->back();
	}

	public function edit_institution($id){

	}

	public function delete($id){
		$experience = jobs_experience::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		$experience->delete();

		Session::flash('success', 'Delete was successful !');

		return redirect()->back();
	}
}
