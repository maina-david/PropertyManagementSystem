<?php
namespace App\Http\Controllers\app\hr\travel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\finance\customer\customers;
use App\Models\hr\employees;
use App\Models\hr\department;
use App\Models\hr\travel;
use App\Models\hr\travel_employee;
use App\Models\hr\travel_departments;
use Session;
use Auth;
use Helper;
class travelController extends Controller
{
   public function __construct(){
      $this->middleware('auth');
   } 

   /**
   * Travel lsit requests
   *
   * @return \Illuminate\Http\Response
   */
   public function index(){
     
      $travels = travel::join('customers','customers.id','=','hr_travels.customerID')
                        ->join('status','status.id','=','hr_travels.status')
                        ->where('hr_travels.businessID',Auth::user()->businessID)
                        ->select('*','hr_travels.id as travID','status.name as statusName','hr_travels.travelID as travel_code')
                        ->orderby('hr_travels.id','desc')
                        ->get();
      $count = 1;

      return view('app.hr.travel.index', compact('travels','count'));
   }

    /**
   * Travel lsit requests
   *
   * @return \Illuminate\Http\Response
   */
  public function my_travels(){
     
   $travels = travel::join('hr_employees','hr_employees.id','=','hr_travels.employeeID')
                     ->join('hr_departments','hr_departments.id','=','hr_travels.departmentID')
                     ->join('customers','customers.id','=','hr_travels.customerID')
                     ->join('status','status.id','=','hr_travels.status')
                     ->where('hr_travels.businessID',Auth::user()->businessID)
                     ->where('hr_travels.employeeID',Auth::user()->employeeID)
                     ->select('*','hr_travels.id as travelID','hr_departments.title as department','status.name as statusName')
                     ->orderby('hr_travels.id','desc')
                     ->get();
   $count = 1;

   return view('app.hr.travel.mytravels', compact('travels','count'));
}

   /**
   * Create travel
   */
   public function create(){
      $employees = employees::where('businessID',Auth::user()->businessID)
                           ->where('statusID',25)
                           ->orderby('id','desc')
                           ->pluck('names','id')                           
                           ->prepend('Choose employee','');

      $customers = customers::where('businessID',Auth::user()->businessID)
                              ->orderby('id','desc')
                              ->pluck('customer_name','id')
                              ->prepend('Choose customer','');

      $departments = department::where('businessID',Auth::user()->businessID)->orderby('id','desc')->pluck('title','id')->prepend('Choose department','');

      return view('app.hr.travel.create', compact('employees','customers','departments'));
   }

   /**
   * store travel
   */
   public function store(Request $request){
      $this->validate($request, [
         'employee' => 'required',
         'place_of_visit' => 'required',
         'date_of_arrival' => 'required',
         'departure_date' => 'required',
         'purpose_of_visit' => 'required',
         'customer' => 'required',
         'bill_customer' => 'required',
         'duration' => 'required'     
      ]);

      $travel = new travel;
      $travel->travelID = Helper::generateRandomString(15);
      $travel->place_of_visit = $request->place_of_visit;
      $travel->date_of_arrival = $request->date_of_arrival;
      $travel->departure_date = $request->departure_date;
      $travel->duration = $request->duration;
      $travel->purpose_of_visit = $request->purpose_of_visit;
      $travel->customerID = $request->customer;
      $travel->bill_customer = $request->bill_customer;
      $travel->status =  7;
      $travel->businessID = Auth::user()->businessID;
      $travel->created_by = Auth::user()->id;
      $travel->save();
      
      $employees = count(collect($request->employee));
      if($employees > 0){
         //upload new category
         for($i=0; $i < count($request->employee); $i++ ) {
            $rep = new travel_employee;
            $rep->travelID = $travel->id;
            $rep->employeeID = $request->employee[$i];
            $rep->businessID = Auth::user()->businessID;
            $rep->save();
         }
      }      

      //department
      $department = count(collect($request->department));
      if($department > 0){
         //upload new category
         for($i=0; $i < count($request->department); $i++ ) {
            $depart = new travel_departments;
            $depart->travelID = $travel->id;
            $depart->departmentID = $request->department[$i];
            $depart->businessID = Auth::user()->businessID;
            $depart->save();
         }
      }

      Session::flash('success','Travel request added');

      return redirect()->route('hrm.travel.index');
   }


   /**
   * Edit travel
   */
   public function edit($id){
      $customers = customers::where('businessID',Auth::user()->businessID)->orderby('id','desc')->pluck('customer_name','id')->prepend('Choose customer','');      
      $travel = travel::join('customers','customers.id','=','hr_travels.customerID')
                        ->where('hr_travels.id',$id)
                        ->where('hr_travels.businessID',Auth::user()->businessID)
                        ->select('*','hr_travels.id as travelID','hr_travels.customerID as customer')
                        ->first();

      //departments
      $getDepartments = department::where('businessID',Auth::user()->businessID)
                                ->orderby('id','desc')
                                ->select('title','id')
                                ->get();
      
      $departments = array();
      foreach($getDepartments as $depart) {
         $departments[$depart->id] = $depart->title;
      }

      //join travel departments
      $getDepartmentJoint = travel_departments::join('hr_departments','hr_departments.id','=','hr_travel_departments.departmentID')
                                             ->where('travelID',$id)
                                             ->select('hr_departments.id as departmentID')
                                             ->get();

      $joinDepartments = array();
      foreach($getDepartmentJoint as $departJoin){
         $joinDepartments[] = $departJoin->departmentID;
      }

      //Employees
      $getEmployees = employees::where('businessID',Auth::user()->businessID)
                              ->where('statusID',25)
                              ->orderby('id','desc')
                              ->select('names','id')
                              ->get();
      $employees = array();
      foreach ($getEmployees as $emp) {
         $employees[$emp->id] = $emp->names;
      }
      
      //join travel employee
      $getjoint = travel_employee::join('hr_employees','hr_employees.id','=','hr_travel_employees.employeeID')
                  ->where('travelID',$id)
                  ->select('hr_employees.id as employeeID')
                  ->get();
      $joinEmployees = array();
      foreach($getjoint as $gj){
         $joinEmployees[] = $gj->employeeID;
      }

      return view('app.hr.travel.edit', compact('employees','customers','travel','departments','joinDepartments','employees','joinEmployees'));
   }

   /**
   * Update travel
   */
   public function update(Request $request, $id){
      $this->validate($request, [
         'employee' => 'required',
         'place_of_visit' => 'required',
         'date_of_arrival' => 'required',
         'departure_date' => 'required',
         'purpose_of_visit' => 'required',
         'customer' => 'required',
         'bill_customer' => 'required',
         'duration' => 'required'     
      ]);

      $travel = travel::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      $travel->place_of_visit = $request->place_of_visit;
      $travel->date_of_arrival = $request->date_of_arrival;
      $travel->departure_date = $request->departure_date;
      $travel->duration = $request->duration;
      $travel->purpose_of_visit = $request->purpose_of_visit;
      $travel->customerID = $request->customer;
      $travel->bill_customer = $request->bill_customer;
      $travel->businessID = Auth::user()->businessID;
      $travel->updated_by = Auth::user()->id;
      $travel->save();

      $employees = count(collect($request->employee));
      if($employees > 0){
         travel_employee::where('travelID',$id)->delete();
         //upload new category
         for($i=0; $i < count($request->employee); $i++ ) {
            $rep = new travel_employee;
            $rep->travelID = $travel->id;
            $rep->employeeID = $request->employee[$i];
            $rep->businessID = Auth::user()->businessID;
            $rep->save();
         }
      }

      //department
      $department = count(collect($request->department));
      if($department > 0){
         travel_departments::where('travelID',$id)->delete();
         //upload new category
         for($i=0; $i < count($request->department); $i++ ) {
            $depart = new travel_departments;
            $depart->travelID = $travel->id;
            $depart->departmentID = $request->department[$i];
            $depart->businessID = Auth::user()->businessID;
            $depart->save();
         }
      }

      Session::flash('success','Travel request updated');

      return redirect()->back();
   }

   /**
   * delete travel
   */
   public function delete($id){
      //check and see if the the travel linked to an expense
      travel::where('businessID',Auth::user()->businessID)->where('id',$id)->delete();

      Session::flash('success','Travel successfully deleted');

      return redirect()->route('hrm.travel.index');
   }
}
