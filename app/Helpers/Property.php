<?php
namespace App\Helpers;
use App\Models\property\landlord\landlords;
use App\Models\property\landlord\landlord_group;
use App\Models\property\type;
use App\Models\property\unit_type;
use App\Models\property\property as props;
use App\Models\property\tenants\tenants;
use App\Models\property\invoice\invoices;
use App\Models\property\invoice\invoice_settings;
use App\Models\property\creditnote\creditnote_settings;
use App\Models\property\utilities;
use App\Models\property\lease_utility;
use App\Models\property\expense\expense;
use App\Models\wingu\file_manager; 
use App\Models\property\listings;
use App\Models\property\lease;
use Auth;
use Helper;
use Wingu;
class Property
{
	//======================================= landlord  =========================================
	//=============================================================================================---->

	// check if landlord exists
	public static function check_landlord($id){
		$check = landlords::where('id',$id)->count();
		return $check;
	}

	// landlord information
	public static function landlord($id){
		$landlord = landlords::find($id); 
		return $landlord;
	}

	//landlord category
	public static function landlord_category($id){
		$category = landlord_group::join('landlord_groups','landlord_groups.id','=','landlord_group.groupID')
						->where('landlordID',$id)
						->where('landlord_groups.businessID',Auth::user()->businessID)
						->get();
		return $category;
	}

	//landlord category
	public static function landlord_properties($id){
		$count = props::where('landlordID',$id)->where('businessID',Auth::user()->businessID)->count();
		return $count;
	}


	//======================================= property  =========================================
	//=============================================================================================---->
	//===count unit properties
	public static function total_units_per_property($id){
		$count = props::where('parentID',$id)->where('businessID',Auth::user()->businessID)->count();
		return $count;
	}

	//property information
	public static function property_info($id){
		$info = props::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $info;
	}

	//occupied units in a property
	public static function occupied_units($id){
		$count = props::where('parentID',$id)->where('tenantID','!=',"")->where('businessID',Auth::user()->businessID)->count();
		return $count;
	}

	//property type info
	public static function property_type($id){
		$info = type::find($id);
		return $info;
	}

	//property Unit check
	public static function check_property_unit($propertyID,$unitID){
		$count = props::where('parentID',$propertyID)->where('id',$unitID)->where('businessID',Auth::user()->businessID)->count();
		return $count;
	}

	//property unit info
	public static function property_unit($propertyID,$unitID){
		$unit = props::where('parentID',$propertyID)->where('id',$unitID)->where('businessID',Auth::user()->businessID)->first();
		return $unit;
	}

	//check property cover image 
	public static function check_cover_property_image($propertyID,$imageID){
		$check = file_manager::where('fileID',$propertyID)
								->where('id',$imageID)
								->where('cover',1)
								->where('businessID',Auth::user()->businessID)
								->where('section','property/images')
								->count();
		return $check;
	}


	//======================================= Tenants  =========================================
	//=============================================================================================---->
	//====check tenant
	public static function check_tenant($id){
		$check = tenants::where('id',$id)->where('businessID',Auth::user()->businessID)->count();
		return $check;
	}

	//====tenant info
	public static function tenant_info($id){
		$info = tenants::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $info;
	}

	//====count tenant leases
	public static function count_lease($id){
		$count = lease::where('tenantID',$id)->where('businessID',Auth::user()->businessID)->count();
		return $count;
	}


	//======================================= lease  =========================================
	//=============================================================================================---->
	public static function lease($id){
		$lease = lease::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $lease;
	}

	//======================================= invoice  =========================================
	//=============================================================================================---->
	//invoice settings
	public static function make_invoice_settings($id){
		$new = new invoice_settings;
		$new->propertyID = $id;
		$new->number = 0;
		$new->prefix = 'INV';
		$new->businessID = Auth::user()->businessID;
		$new->created_by = Auth::user()->id;
		$new->save();

		return;
	}

	//======================================= credit note  =========================================
	//=============================================================================================---->
	//credit note settings
	public static function make_creditnote_settings($id){
		$new = new creditnote_settings;
		$new->propertyID = $id;
		$new->number = 0;
		$new->prefix = 'CN';
		$new->businessID = Auth::user()->businessID;
		$new->created_by = Auth::user()->id;
		$new->save();

		return;
	}

	//======================================= Listing  =========================================
	//=============================================================================================---->
	public static function listing($id){
		$information = listings::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $information;
	}

	//======================================= reports   =========================================
	//=============================================================================================---->
	//check invoice income category within a period
	public static function check_invoice_in_category_by_period($propertyID,$id,$from,$to){
		$check = invoices::where('businessID',Auth::user()->businessID)
								->whereBetween('invoice_date',[$from,$to])
								->where('income_category',$id)
								->where('propertyID',$propertyID)
								->count();
		return $check;
	}

	//get invoices by income category
	public static function invoices_per_income_category($propertyID,$id,$from,$to){
		$invoices = invoices::where('businessID',Auth::user()->businessID)
									->whereBetween('invoice_date',[$from,$to])
									->where('income_category',$id)
									->where('propertyID',$propertyID)
									->groupby('income_category')
									->orderby('id','desc')
									->get();
		return $invoices;
	}
 
	//get invoices by income category
	public static function invoices_per_income_category_sum($propertyID,$id,$from,$to){
		$sum = invoices::where('businessID',Auth::user()->businessID)
							->whereBetween('invoice_date',[$from,$to])
							->where('propertyID',$propertyID)
							->where('income_category',$id)
							->sum('main_amount');
		return $sum;
	}

	//get expense by category within a period
	public static function check_expense_per_category_by_period($propertyID,$id,$from,$to){
		$check = expense::whereBetween('date',[$from,$to])->where('expense_category',$id)->where('propertyID',$propertyID)->count();
		return $check;
	}

	public static function expense_per_category($propertyID,$id,$from,$to){
		$expenses = expense::where('businessID',Auth::user()->businessID)
									->whereBetween('date',[$from,$to])
									->where('expense_category',$id)
									->where('propertyID',$propertyID)
									->groupby('expense_category')
									->orderby('id','desc')
									->get();
		return $expenses;
	}

	public static function expense_per_category_sum($propertyID,$id,$from,$to){
		$sum = expense::where('businessID',Auth::user()->businessID)	
							->whereBetween('date',[$from,$to])
							->where('expense_category',$id)
							->where('propertyID',$propertyID)
							->sum('amount');
		return $sum;
	}

	//======================================= Utility  =========================================
	//=============================================================================================---->
	public static function utility($id){
		$utility = utilities::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
		return $utility;
	} 
}
