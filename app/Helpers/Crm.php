<?php
namespace App\Helpers;
use App\Models\crm\leads\leads;
use App\Models\finance\customer\customers;
use App\Models\crm\digital\medium;
use App\Models\crm\deals\pipeline;
use App\Models\crm\deals\stages;
use App\Models\crm\deals\deals;  
use App\Models\crm\leads\sources;
use App\Models\crm\leads\status;
use Auth;
class Crm
{
	public static function lead($id){
		$lead = customers::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		return $lead;
	}

	/*=== lead status ===*/
	public static function check_lead_status($id){
		$check = status::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
		return $check;
	}

	public static function lead_status($id){
		$status = status::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
		return $status;
	}

	/*=== mediums ===*/
	public static function medium($id){
		$medium = medium::find($id);
		return $medium;
	}

	/*=== pipeline ===*/
	//check pipeline 
	public static function check_pipeline($id){
		$check = pipeline::where('id',$id)->where('businessID',Auth::user()->businessID)->count();
		return $check;
	}

	//get pipeline
	public static function pipeline($id){
		$pipeline = pipeline::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $pipeline;
	}

	/*=== pipeline stage ===*/
	//check pipeline 
	public static function check_pipeline_stage($id){
		$check = stages::where('id',$id)->where('businessID',Auth::user()->businessID)->count();
		return $check;
	}

	//get stages
	public static function pipeline_stage($id){
		$pipeline = stages::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $pipeline;
	}

	//get all stages per pipeline
	public static function  all_pipeline_stages($id){
		$stages = stages::where('pipelineID',$id)->where('businessID',Auth::user()->businessID)->get();
		return $stages;
	}

	/*=== lead source ===*/
	//check source
	public static function check_sources($id){
		$check = sources::where('id',$id)->where('businessID',Auth::user()->businessID)->count();
		return $check;
	}

	//sources
	public static function source($id){
		$source = sources::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $source;
	}
	
}


