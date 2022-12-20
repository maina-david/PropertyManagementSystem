<?php

namespace App\Http\Controllers\Modules\HumanResource\ExitDetails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\modules\HumanResource\employee_primary_info;
use App\modules\HumanResource\employee_secondary_info;
use App\modules\HumanResource\employee_institution_info;
use App\modules\HumanResource\employee_basic_info;
use Session;

class ExitdetailsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	$get_employee = employee_basic_info::all();
    	return view('Limitless.Human-resource.ExitDetails.index')->withEmployees($get_employee);
    }

    public function create(){
    	$get_employee = employee_basic_info::all();
    	return view('Limitless.Human-resource.ExitDetails.Create')->withEmployees($get_employee);
    }

    public function edit($id){
    	$get_employee = employee_basic_info::all();
    	return view('Limitless.Human-resource.ExitDetails.edit')->withEmployees($get_employee);
    }
}
