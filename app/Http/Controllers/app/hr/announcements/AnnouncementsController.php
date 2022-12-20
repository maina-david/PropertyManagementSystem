<?php

namespace App\Http\Controllers\Limitless\HumanResource\Announcements;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\HumanResource\employee_primary_info;
use App\Model\HumanResource\employee_secondary_info;
use App\Model\HumanResource\employee_institution_info;
use App\Model\HumanResource\employee_basic_info;
use Session;

class AnnouncementsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function announcements_list(){
    	$get_employee = employee_basic_info::all();
    	return view('limitless.Human-resource.Announcements.index')->withEmployees($get_employee);
    }

    public function show($id){
    	$get_employee = employee_basic_info::all();
    	return view('limitless.Human-resource.Announcements.show')->withEmployees($get_employee);
    }
}
