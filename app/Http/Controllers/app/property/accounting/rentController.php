<?php

namespace App\Http\Controllers\app\property\accounting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\property\property;
use App\Models\finance\invoice\invoices;
use App\Models\property\tenants\tenants;
use App\Models\property\lease;
use App\Models\finance\invoice\invoice_products;
use App\Models\finance\tax;
use Auth;
use Session;

class rentController extends Controller
{
   public function __construct(){
		$this->middleware('auth');
   }

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index($id)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();

      $nextmonth = date('F Y', strtotime('+1 months'));
      $pastmount = date('F Y', strtotime('-1 months'));
      $currentmount = date('F Y', strtotime('0 months'));

      //check past month billing
      $checkPastBilling = invoices::where('invoices.businessID',Auth::user()->businessID)
                        ->where('parent_property',$id)
                        ->where('payment_period', 'like', '%' . $pastmount . '%')
                        ->count();

      if($checkPastBilling == 0){
         Session::flash('error','Billing for '.$pastmount.' was not proccessed you can do it before processing billing for '.$nextmonth);
         $nextmonth = $pastmount;
         return view('app.property.property.payments.index', compact('property','nextmonth'));
      }

      //current month billing
      $checkCurrentBilling = invoices::where('invoices.businessID',Auth::user()->businessID)
                        ->where('parent_property',$id)
                        ->where('payment_period', 'like', '%' . $currentmount . '%')
                        ->count();

      if($checkCurrentBilling == 0){
         Session::flash('error','Billing for '.$currentmount.' was not proccessed you can do it before processing billing for '.$nextmonth);
         $nextmonth = $currentmount;
         return view('app.property.property.payments.index', compact('property','nextmonth'));
      }
      

      //next month billing
      $checkPeriod = invoices::where('invoices.businessID',Auth::user()->businessID)
                        ->where('parent_property',$id)
                        ->where('payment_period', 'like', '%' . $nextmonth . '%')
                        ->count();

      if($checkPeriod > 0){
         $type = 'Monthly';
         return redirect()->route('pm.property.billing.history',[$id,$nextmonth,$type]);
      }

      return view('app.property.property.payments.index', compact('property','nextmonth'));
   } 

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function bulk_process(Request $request)
   {
      $id = $request->propertyID;
      //validate the parent property to avoid users changing value via browser
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');
         return redirect()->back();
      }

      if($request->invoice_schedule == 'Monthly'){
         $nextmonth = date('F Y', strtotime('+1 months'));
         $qty = 1;
      }elseif($request->invoice_schedule == 'quarterly'){
         $nextmonth = date('F Y', strtotime('+3 months'));
         $qty = 3;
      }

      $invoiceSettings = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
      
      //get all the units
      $units = property::join('property_unit_type','property_unit_type.id','=','property.unit_type')
                        ->join('tenants','tenants.id','=','property.tenantID')
                        ->join('property_lease','property_lease.id','=','property.leaseID')
                        ->join('business','business.id','=','property.businessID') 
                        ->whereNull('property_lease.statusID')
                        ->where('property.businessID',Auth::user()->businessID)
                        ->where('property_lease.invoice_schedule','=',$request->invoice_schedule)
                        ->where('property.parentID',$id)
                        ->where('property.tenantID','!=', '')
                        ->orderby('property.id','desc')
                        ->select('*','property.id as propID','property.tenantID as tID','property_lease.service_charge as serviceCharge','property_lease.parking_price as parkingPrice','property_lease.id as leaseID')
                        ->get();

      $date = date('Y-m-d');

      //create the invoices
      foreach($units as $unit){

         $tax = $unit->tax_rate;

         if($tax > 0){
            $taxes = $tax / 100;
            $total = (($unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice))* $taxes ) +                             $unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice);
            $mainTotal = $total * $qty;
         }else{
            $taxes = 0;
            $total = $unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice);

            $mainTotal = $total * $qty;
         }

         //insert main invoice
         $invoice				= new invoices;
         $invoice->userID		= Auth::user()->id;
         $invoice->tenantID	 	= $unit->tID;
         $invoice->propertyID 	= $unit->propID;
         $invoice->leaseID	 	   = $unit->leaseID;
         $invoice->parent_property = $request->propertyID;
         $invoice->currencyID	   = $unit->base_currency;
         $invoice->invoice_number = $invoiceSettings->invoice_number + 1;
         $invoice->total		    = $mainTotal;
         $invoice->sub_total		= ($unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice)) * $qty;
         $invoice->balance	    = $mainTotal;
         $invoice->tax			   = $tax;
         $invoice->invoice_date	= $request->invoicing_date;
         $invoice->statusID	   = 2;
         $invoice->invoice_due	= $request->due_date;
         $invoice->customer_note	= $invoice->invoice_default_customer_notes;
         $invoice->terms			= $invoice->invoice_default_terms_conditions;
         $invoice->invoice_type	= 'Rent';
         $invoice->description	= 'Rent';
         $invoice->transaction_type	 = 'Debit';
         $invoice->payment_period = $nextmonth;
         $invoice->businessID 	 = Auth::user()->businessID;
         $invoice->save();

         //Rent
         $rent 				= new invoice_products;
         $rent->invoiceID	= $invoice->id;
         $rent->propertyID	= $unit->propID;
         $rent->quantity		= 1;
         $rent->tax		    = $tax;
         $rent->item_name    = 'Rent';
         $rent->price        = $unit->rent_amount;
         $rent->category     = 'Rent';
         $rent->save();

         if($unit->parkingPrice != "" && $unit->parking_spaces != ""){
               //store parking
               $parking 			 = new invoice_products;
               $parking->invoiceID	 = $invoice->id;
               $parking->propertyID = $unit->propID;
               $parking->tax		 = $tax;
               $parking->quantity	 = $unit->parking_spaces * $qty;
               $parking->item_name  = 'Parking';
               $parking->price      = $unit->parkingPrice * $qty;
               $parking->category   = 'Rent';
               $parking->save();
         }

         if($unit->serviceCharge != ""){
               //service charge
               $service 			 = new invoice_products;
               $service->invoiceID	 = $invoice->id;
               $service->propertyID = $unit->propID;
               $service->tax		 = $tax;
               $service->quantity	 = $qty;
               $service->item_name  = 'Service charge';
               $service->price      = $unit->serviceCharge * $qty;
               $service->category   = 'Rent';
               $service->save();
         }

         //invoice setting
         $invoiceNumber 	= $invoiceSettings->invoice_number + 1;
         $invoiceSettings->invoice_number	= $invoiceNumber;
         $invoiceSettings->save();
      }

      Session::flash('success', 'Payment invoices processed successfully !!!');

      return redirect()->back();
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function single_payment(Request $request)
   {
      $id = $request->propertyID;
      //validate the parent property to avoid users changing value via browser
      $check = property::where('businessID',Auth::user()->businessID)->where('id',$id)->count();
      if($check == 0){
         Session::flash('error', 'The is an issue with the submitted data, You need to start over again !!!');

         return redirect()->back();
      }

      $nextmonth = date('F Y', strtotime('+1 months'));

      //get all the units
      $units = property::join('property_unit_type','property_unit_type.id','=','property.unit_type')
               ->join('tenants','tenants.id','=','property.tenantID')
               ->join('property_lease','property_lease.id','=','property.leaseID')
               ->where('property_lease.statusID','!=',25)
               ->where('property.businessID',Auth::user()->businessID)
               ->where('property.parentID',$id)
               ->where('property.tenantID','!=', '')
               ->orderby('property.id','desc')
               ->select('*','property.id as propID','property.tenantID as tID','property_lease.service_charge as serviceCharge','property_lease.parking_price as parkingPrice')
               ->first();

      $tax = tax::where('id',$request->tax)->where('businessID',Auth::user()->businessID)->first();

      if($tax->rate > 0){
         $taxes = $tax->rate / 100;
      }

      $date = date('Y-m-d');
      //create the invoices

      //insert main invoice
      $invoice					     = new invoices;
      $invoice->userID		     = Auth::user()->id;
      $invoice->tenantID	 	  = $unit->tID;
      $invoice->propertyID	 	  = $unit->propID;
      $invoice->parent_property = $request->propertyID;
      $invoice->currencyID	     = $unit->base_currency;
      $invoice->invoice_number  = $invoice->invoice_number + 1;
      $invoice->total		     = (($unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice))*$taxes) +                                           $unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice);
      $invoice->sub_total		  = $unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice);
      $invoice->balance	        = (($unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice))*$taxes) +                                           $unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice);
      $invoice->tax			  = $tax;
      $invoice->invoice_date	  = $date;
      $invoice->statusID	     = 2;
      $invoice->invoice_due	  = date('Y-m-d', strtotime($date. ' + 7 days'));
      $invoice->customer_note	  = $invoice->default_customer_notes;
      $invoice->terms			  = $invoice->default_terms_conditions;
      $invoice->invoice_type	  = 'Rent';
      $invoice->description	  = 'Rent';
      $invoice->transaction_type	 = 'Debit';
      $invoice->payment_period	 = $nextmonth;
      $invoice->businessID 	  = Auth::user()->businessID;
      $invoice->save();

      //Rent
      $rent 					= new invoice_products;
            $rent->invoiceID		= $invoice->id;
            $rent->propertyID	   = $unit->propID;
      $rent->quantity		= 1;
      $rent->tax		   = $tax;
            $rent->item_name     = 'Rent';
            $rent->price         = $unit->rent_amount;
            $rent->category      = 'Rent';
            $rent->save();

      if($unit->parkingPrice != "" && $unit->parking_spaces != ""){
            //store parking
            $parking 					= new invoice_products;
            $parking->invoiceID		= $invoice->id;
            $parking->propertyID	   = $unit->propID;
            $parking->tax		   = $tax;
            $parking->quantity		= $unit->parking_spaces;
            $parking->item_name     = 'Parking';
            $parking->price         = $unit->parkingPrice;
            $parking->category      = 'Rent';
            $parking->save();
      }

      if($unit->serviceCharge != ""){
            //service charge
            $service 					= new invoice_products;
            $service->invoiceID		= $invoice->id;
            $service->propertyID	   = $unit->propID;
            $service->tax		   = $tax;
            $service->quantity		= 1;
            $service->item_name     = 'Service charge';
            $service->price         = $unit->serviceCharge;
            $service->category      = 'Rent';
            $service->save();
      }

      //invoice setting
      $invoiceNumber = $invoice->invoice_number + 1;
      $invoice->invoice_number = $invoiceNumber;
      $invoice->save();

      Session::flash('success', 'Payment invoices processed successfully !!!');

      return redirect()->back();
   }

   /**
   * Missing payments
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function missing_billings(Request $request){
      $this->validate($request, [
         'lease' => 'required',
         'due_date' => 'required',
         'invoicing_date' => 'required',
         'propertyID' => 'required',
         'period' => 'required',
      ]);

      $unit = property::join('property_lease','property_lease.id','=','property.leaseID')
               ->join('business','business.id','=','property.businessID') 
               ->whereNull('property_lease.statusID')
               ->where('property.businessID',Auth::user()->businessID)
               ->where('property_lease.invoice_schedule','=',$request->invoice_schedule)
               ->where('property.parentID',$request->propertyID)
               ->where('property_lease.id',$request->lease)
               ->orderby('property.id','desc')
               ->select('*','property.id as propID','property.tenantID as tID','property_lease.service_charge as serviceCharge','property_lease.parking_price as parkingPrice','property_lease.id as leaseID')
               ->first();

      $invoiceSettings = property::where('businessID',Auth::user()->businessID)->where('id',$request->propertyID)->first();


      if($request->invoice_schedule == 'Monthly'){
         $nextmonth = date('F Y', strtotime('0 months'));
         $qty = 1;
      }elseif($request->invoice_schedule == 'quarterly'){
         $nextmonth = date('F Y', strtotime('+3 months'));
         $qty = 3;
      }         
      
      $tax = $unit->tax_rate;

      if($tax > 0){
         $taxes = $tax / 100;
         $total = (($unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice))* $taxes ) + $unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice);
         $mainTotal = $total * $qty;
      }else{
         $taxes = 0;
         $total = $unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice);

         $mainTotal = $total * $qty;
      }

      //insert main invoice
      $invoice				         = new invoices;
      $invoice->userID		      = Auth::user()->id;
      $invoice->tenantID	 	   = $unit->tID;
      $invoice->propertyID	      = $unit->propID;
      $invoice->leaseID	 	      = $unit->leaseID;
      $invoice->parent_property  = $request->propertyID;
      $invoice->currencyID	      = $unit->base_currency;
      $invoice->invoice_number   = $invoiceSettings->invoice_number + 1;
      $invoice->total		      = $mainTotal;
      $invoice->sub_total		   = ($unit->rent_amount + $unit->serviceCharge + ($unit->parking_spaces * $unit->parkingPrice)) * $qty;
      $invoice->balance	         = $mainTotal;
      $invoice->tax			      = $tax;
      $invoice->invoice_date	   = $request->invoicing_date;
      $invoice->statusID	      = 2;
      $invoice->invoice_due	   = $request->due_date;
      $invoice->customer_note	   = $invoice->invoice_default_customer_notes;
      $invoice->terms			   = $invoice->invoice_default_terms_conditions;
      $invoice->invoice_type	   = 'Rent';
      $invoice->description	   = 'Rent';
      $invoice->transaction_type	= 'Debit';
      $invoice->payment_period   = $request->period;
      $invoice->businessID 	   = Auth::user()->businessID;
      $invoice->save();

      //Rent
      $rent 				         = new invoice_products;
      $rent->invoiceID	         = $invoice->id;
      $rent->propertyID	         = $unit->propID;
      $rent->quantity		      = 1;
      $rent->tax		            = $tax;
      $rent->item_name           = 'Rent';
      $rent->price               = $unit->rent_amount;
      $rent->category            = 'Rent';
      $rent->save();

      if($unit->parkingPrice != "" && $unit->parking_spaces != ""){
         //store parking
         $parking 			      = new invoice_products;
         $parking->invoiceID	   = $invoice->id;
         $parking->propertyID    = $unit->propID;
         $parking->tax		      = $tax;
         $parking->quantity	   = $unit->parking_spaces * $qty;
         $parking->item_name     = 'Parking';
         $parking->price         = $unit->parkingPrice * $qty;
         $parking->category      = 'Rent';
         $parking->save();
      }

      if($unit->serviceCharge != ""){
         //service charge
         $service 			      = new invoice_products;
         $service->invoiceID	   = $invoice->id;
         $service->propertyID    = $unit->propID;
         $service->tax		      = $tax;
         $service->quantity	   = $qty;
         $service->item_name     = 'Service charge';
         $service->price         = $unit->serviceCharge * $qty;
         $service->category      = 'Rent';
         $service->save();
      }

      //invoice setting
      $invoiceNumber 	= $invoiceSettings->invoice_number + 1;
      $invoiceSettings->invoice_number	= $invoiceNumber;
      $invoiceSettings->save();

      Session::flash('success', 'Invoice successfully added to '.$request->period.' period');

      return redirect()->back();      
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function search_history($id) 
   {  
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$id)->first();
         
      return view('app.property.property.payments.search', compact('property'));
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function history($propertyID,$datefrom,$dateto,$type)
   {
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $from = $datefrom;
      $to = $dateto;

      $invoices = invoices::join('tenants', 'tenants.id','=','invoices.tenantID')
                  ->join('property','property.id','=','invoices.propertyID')
                  ->join('property_lease','property_lease.unitID','=','invoices.propertyID')
                  ->join('currency','currency.id','=','invoices.currencyID')
                  ->where('parent_property',$propertyID)
                  ->where('invoices.businessID',Auth::user()->businessID)
                  ->where('invoices.tenantID','!=', "")
                  ->where('invoices.invoice_type','Rent') 
                  //->where('property_lease.invoice_schedule',$type)
                  ->where('invoice_date',$from)
                  // ->where('invoice_due',$to)
                  //->whereBetween('created_at',[$from,$end_date])
                  ->orderby('invoices.id','desc')
                  ->select('*','invoices.id as invoiceID')
                  ->get();
                  
      $tenants = property::join('tenants','tenants.id','=','property.tenantID')
                  ->join('property_lease','property_lease.unitID','=','property.id')
                  ->whereNull('statusID')
                  ->where('parentID',$propertyID)
                  ->orderby('tenants.id','desc')
                  ->select('*','property_lease.id as leaseID')
                  ->get();

      $invoicingDate =  date('Y-m', strtotime($from));

      $count = 1;

      $period = $datefrom.'-'.$dateto;
 
      return view('app.property.property.payments.history', compact('count','property','period','invoices','tenants','invoicingDate'));
   }

   /**
       * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $idpropertyID
      * @return \Illuminate\Http\Response
      */
   public function search_results(Request $request)
   {
      $datefrom = date($request->datefrom);
      $dateto = date($request->dateto);

      return redirect()->route('pm.property.billing.history', [$request->propertyID,$datefrom,$dateto,$request->type]);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
