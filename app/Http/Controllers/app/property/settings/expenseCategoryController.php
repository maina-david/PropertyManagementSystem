<?php

namespace App\Http\Controllers\app\property\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\finance\expense\expense_category;
use Session;
use Auth;
use Wingu;

class expenseCategoryController extends Controller
{
   /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $category = expense_category::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
      $count = 1;
      return view('app.property.settings.expense.index', compact('category','count'));
   }

   public function store(Request $request){
      $this->validate($request, array(
         'category_name'  => 'required'
      ));

      $category = new expense_category;
      $category->category_name = $request->category_name;
      $category->category_description = $request->category_description;
      $category->created_by = Auth::user()->id;
      $category->businessID = Auth::user()->businessID;
      $category->save();

      //records activity
      $activities = Auth::user()->name.' Has added an expense';
      $section = 'Settings';
      $type = 'Expense category';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
      $activityID = $category->id;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Category Successfully added');

      return redirect()->back();
   }

   public function edit($id){
      $category = expense_category::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
      $edit_cat = expense_category::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $count = 1;
      return view('app.finance.expense.settings.category.edit')->withCategory($category)->withCount($count)->withCatedit($edit_cat);
   }

   public function update(Request $request, $id){
      $this->validate($request, array(
         'category_name'  => 'required',
      ));

      $edit_cat = expense_category::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $edit_cat->category_name = $request->category_name;
      $edit_cat->category_description = $request->category_description;
      $edit_cat->updated_by = Auth::user()->id;
      $edit_cat->businessID = Auth::user()->businessID;
      $edit_cat->save();

      //records activity
      $activities = Auth::user()->name.' Has updated '.$edit_cat->category_name.' expense';
      $section = 'Settings';
      $type = 'Expense category';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
      $activityID = $id;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','category successfully updated');

      return redirect()->back();
   }

   public function destroy($id)
   {
      $delete = expense_category::where('id',$id)->where('businessID',Auth::user()->businessID)->first();
      $delete->delete();

      //records activity
      $activities = Auth::user()->name.' Has deleted '.$delete->category_name.' expense';
      $section = 'Settings';
      $type = 'Expense category';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
      $activityID = $id;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Category has been successfully deleted');

      return redirect()->back();
   }

   public function express(Request $request){
      $category = new expense_category;
      $category->category_name = $request->name;
      $category->created_by = Auth::user()->id;
      $category->businessID = Auth::user()->businessID;
      $category->save();

      //records activity
      $activities = Auth::user()->name.' Has added an expense category';
      $section = 'Settings';
      $type = 'Expense category';
      $adminID = Auth::user()->id;
      $businessID = Auth::user()->businessID;
      $activityID = $category->id;

      Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

      Session::flash('success','Category Successfully added');
   }

   public function list(Request $request)
   {
      $accounts = expense_category::where('businessID',Auth::user()->businessID)->orderby('id','desc')->get(['id', 'category_name as text']);
      return ['results' => $accounts];
   }
}

