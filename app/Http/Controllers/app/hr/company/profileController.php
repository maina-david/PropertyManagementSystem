<?php

namespace App\Http\Controllers\Limitless\HumanResource\CompanyProfile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HumanResource\employee_primary_info;
use App\Model\HumanResource\employee_secondary_info;
use App\Model\HumanResource\employee_institution_info;
use App\Model\HumanResource\employee_basic_info;
use Session;

class CompanyProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	$get_employee = employee_basic_info::all();
    	return view('limitless.Human-resource.CompanyProfile.index')->withEmployees($get_employee);
    }

    public function create(){
    	$get_employee = employee_basic_info::all();
    	return view('limitless.Human-resource.CompanyProfile.Create')->withEmployees($get_employee);
    }

    public function edit($id){
    	$get_employee = employee_basic_info::all();
    	return view('limitless.Human-resource.CompanyProfile.edit')->withEmployees($get_employee);
    }
}
