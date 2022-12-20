<?php
namespace App\Http\Controllers\app\property\accounting;

use Illuminate\Http\Request;
use App\Models\wingu\business;
use App\Http\Controllers\Controller;
use App\Models\finance\accounts;
use App\Models\finance\income\category;
use App\Models\finance\payments\payment_type;
use App\Models\finance\tax;
use App\Models\property\property;
use App\Models\property\invoice\invoices;
use App\Models\property\lease_utility;
use App\Models\property\utilities;
use App\Models\property\invoice\invoice_products;
use App\Models\property\invoice\invoice_settings;
use App\Models\property\payments\payments;
use App\Models\property\tenants\tenants;
use App\Models\property\tenants\contact_persons;
use App\Models\wingu\file_manager as documents;
use App\Mail\sendUtility;
use App\Models\crm\emails;
use Helper;
use Mail;
use Auth;
use Finance;
use Session;
use Wingu;
use PDF;

class utilityController extends Controller
{
   /**
   * List utility
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function index($propertyID){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      return view('app.property.accounting.utility.index', compact('property','propertyID'));
   }


   public function prepare_bulk_billing(Request $request,$id){
      $this->validate($request, [
         'issue_date' => 'required',
         'due_date' => 'required',
      ]);

      //process the billing
      $query = lease_utility::join('property_lease','property_lease.id','=','property_lease_utility.leaseID')
                                 ->join('property','property.leaseID','=','property_lease_utility.leaseID')
                                 ->join('property_utilities','property_utilities.id','=','property_lease_utility.utilityID')
                                 ->join('property_tenants','property_tenants.id','=','property.tenantID')
                                 ->where('property_lease.propertyID',$id)
                                 ->where('property_lease.statusID',15)
                                 ->where('property_lease_utility.businessID',Auth::user()->businessID)
                                 ->where('property_lease_utility.utilityID',$request->utility);
											
		$check_billing = $query->count();

		if($check_billing > 0){
			$utilities = $query->select('property.leaseID as leaseID','property_tenants.id as tenantID','property_lease_utility.id as leaseUtility','property.id as propertyID','property_utilities.name as utilityName','property_tenants.id as tenantsID','property_lease_utility.last_reading as last_reading')->get();

			$setting = invoice_settings::where('businessID',Auth::user()->id)->where('propertyID',$id)->first();

			foreach($utilities as $bill){
				//insert main invoice
				$invoice			          = new invoices;
				$invoice->created_by		 = Auth::user()->id;
				$invoice->tenantID	 	 = $bill->tenantID;
				$invoice->propertyID	    = $bill->propertyID;
				$invoice->leaseID        = $bill->leaseID;
				$invoice->propertyID     = $id;
				$invoice->leaseUtilityID = $bill->leaseUtility;
				$invoice->invoice_prefix = $setting->prefix;
				$invoice->invoice_number = $setting->number + 1;
				$invoice->total		    = 0;
				$invoice->sub_total	    = 0;
				$invoice->balance	       = 0;
				$invoice->invoice_date	 = $request->issue_date;
				$invoice->statusID	    = 2;
				$invoice->invoice_due	 = $request->due_date;
				$invoice->customer_note  = $setting->default_customer_notes;
				$invoice->terms		    = $setting->default_terms_conditions;
				$invoice->invoice_type	 = 'Utility';
				$invoice->description	 = $bill->utilityName;
				$invoice->income_category = 2; 
				$invoice->businessID 	 = Auth::user()->businessID;
				$invoice->save();

				//utility
				$utility 			       = new invoice_products;
				$utility->invoiceID      = $invoice->id;
				$utility->propertyID     = $bill->propertyID;
				$utility->quantity	    = 0;
				$utility->previous_units = $bill->last_reading;
				$utility->current_units  = 0;
				$utility->item_name      = $bill->utilityName;
				$utility->price          = $bill->price;
				$utility->businessID 	 = Auth::user()->businessID;
				$utility->category       = 'utility';
				$utility->save();

				//invoice setting
				$invoiceNumber 	= $setting->number + 1;
				$setting->number	= $invoiceNumber;
				$setting->save();
			}

			//redirect to preparation page
			return redirect()->route('property.record.bulk.reading',[$id,$request->utility,$request->issue_date,$request->due_date]);
		}else{
			Session::flash('warning','You dont have any active utility bills');

			return redirect()->back();
		}
   }


   //recored bulk billing
   public function record_bulk_reading($propertyID,$utility,$from,$to){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();
      $utilities = invoices::join('property_invoice_products','property_invoice_products.invoiceID','=','property_invoices.id')
                           ->join('property','property.leaseID','=','property_invoices.leaseID')
                           ->join('property_lease_utility','property_lease_utility.leaseID','=','property.leaseID')
                           ->join('property_utilities','property_utilities.id','=','property_lease_utility.utilityID')
                           ->join('property_tenants','property_tenants.id','=','property.tenantID')
                           ->where('property_lease_utility.utilityID',$utility)
                           ->where('invoice_date',$from)
                           ->where('invoice_due',$to)
                           ->select('property.leaseID as leaseID','property_tenants.id as tenantID','property_tenants.tenant_name as tenant_name','property_utilities.id as utilityID','property_lease_utility.id as leaseUtility','property.id as propertyID','property_utilities.name as utilityName','property_lease_utility.last_reading as last_reading','property_invoice_products.current_units as current_units','property_invoice_products.id as invoiceProductID','property.serial as serial','property_invoices.id as invoice_id','property_lease_utility.initial_price as price','property_invoice_products.previous_units as previous_reading','property_invoice_products.price as unit_price')
                           ->get();
      $count = 1;
      return view('app.property.accounting.utility.record_reading', compact('property','utilities','count','from','to','propertyID'));
   }

   /**
   * calculate utility bill
   **/
   public function calculate_consumption(Request $request,$propertyID,$id){
      $this->validate($request,[
         'current' => 'required',
         'price' => 'required',
      ]);


      //invoice product
      $product = invoice_products::where('invoiceID',$request->invoiceID)
											->where('businessID',Auth::user()->businessID)
											->where('id',$id)
											->first();

		$invoice = invoices::where('id',$request->invoiceID)->where('businessID',Auth::user()->businessID)->first();
                     
		$previous = lease_utility::where('id',$invoice->leaseUtilityID)->where('businessID',Auth::user()->businessID)->first();

		//check if current is more than previous
		if($request->current < $previous->last_reading ){
         Session::flash('warning','The current consumed units can not be less then the previous consumed units');
         return redirect()->back();
      }
      
      $qty = $request->current - $previous->last_reading;      
      $product->current_units = $request->current;
		$product->previous_units = $previous->last_reading;
      $product->quantity = $qty;
      $product->price = $request->price;
      $product->total_amount = $qty * $request->price;
      $product->businessID = Auth::user()->businessID;
      $product->save();

      //update invoice     
      $invoice->main_amount = $product->total_amount;
      $invoice->propertyID  = $propertyID;
		$invoice->total		 = $product->total_amount;
		$invoice->balance		 = $product->total_amount;
		$invoice->sub_total	 = $product->total_amount;
		$invoice->taxvalue	 = 0; 
		$invoice->save();

      //update the previous reading     
      $previous->updated_by = Auth::user()->id;
		$previous->last_reading = $request->current;
      $previous->save();

      //=====send email
      //check tenant email

      //record activity log

      Session::flash('success','Utility successfully updated');

      return redirect()->back();
   }

	/**
   * update utility bill
   **/
	public function update_utility_billing(Request $request,$propertyID,$id){
		//return utility back to original reading 
		$utility = invoice_products::where('invoiceID',$request->invoiceID)
											->where('businessID',Auth::user()->businessID)
											->where('id',$id)
											->first();

		$invoice = invoices::where('id',$request->invoiceID)->where('businessID',Auth::user()->businessID)->first();

		//return reading to previous
		$OldPrevious = lease_utility::where('id',$invoice->leaseUtilityID)->where('businessID',Auth::user()->businessID)->first();
		$OldPrevious->last_reading = $utility->previous_units;
		$OldPrevious->save();


		//calculate the update
		
		$previous = lease_utility::where('id',$invoice->leaseUtilityID)->where('businessID',Auth::user()->businessID)->first();
		if($request->current < $previous->last_reading ){
         Session::flash('warning','The current consumed units can not be less then the previous consumed units');
         return redirect()->back();
      }
		
		$utility = invoice_products::where('invoiceID',$request->invoiceID)
											->where('businessID',Auth::user()->businessID)
											->where('id',$id)
											->first();
		$qty = $request->current - $previous->last_reading;      
      $utility->current_units = $request->current;
		$utility->previous_units = $previous->last_reading;
      $utility->quantity = $qty;
      $utility->price = $request->price;
      $utility->total_amount = $qty * $request->price;
      $utility->businessID = Auth::user()->businessID;
      $utility->save();

      //update invoice     
      $invoice->main_amount = $utility->total_amount;
      $invoice->propertyID  = $propertyID;
		$invoice->total		 = $utility->total_amount;
		$invoice->balance		 = $utility->total_amount;
		$invoice->sub_total	 = $utility->total_amount;
		$invoice->taxvalue	 = 0; 
		$invoice->save();

      //update the previous reading     
      $previous->updated_by = Auth::user()->id;
		$previous->last_reading = $request->current;
      $previous->save();

		Session::flash('success','Utility successfully updated');

		return redirect()->back();
	}

   /**
   * Show utiity
   **/
   public function show($propertyID,$invoiceID){
      $business = business::join('template','template.id','=','business.templateID')
									->join('currency','currency.id','=','business.base_currency')
									->where('business.id',Auth::user()->businessID)
									->where('businessID',Auth::user()->code)
									->first();

		$property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $invoice = invoices::join('property_lease_utility','property_lease_utility.id','=','property_invoices.leaseUtilityID')
                           ->join('status','status.id','=','property_invoices.statusID')
                           ->where('property_invoices.id',$invoiceID)
                           ->where('propertyID',$propertyID)
									->where('property_invoices.invoice_type','Utility')
                           ->where('property_invoices.businessID',Auth::user()->businessID)
                           ->select('*','property_invoices.id as invoiceID','property_invoices.balance as invoice_balance','property_invoices.statusID as invoiceStatusID','property_invoices.paid as amount_paid')
                           ->first();

      $product = invoice_products::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->where('category','utility')->first();

		$payments = payments::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->get();
		
		$mainMethods =  payment_type::where('businessID',0)->get();
      $paymentmethod = payment_type::where('businessID',Auth::user()->businessID)->get();

		$tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
								->where('businessID',Auth::user()->businessID)
								->where('property_tenants.id',$invoice->tenantID)
								->select('*','property_tenants.id as tenantID')
								->first();

		$balance = invoices::join('property_lease_utility','property_lease_utility.id','=','property_invoices.leaseUtilityID')
									->where('propertyID',$propertyID)
									->where('tenantID',$invoice->tenantID)
									->where('property_invoices.businessID',Auth::user()->businessID)
									->where('invoice_type','Utility')
									->sum('balance');

		$taxes = tax::where('businessID',Auth::user()->businessID)->OrderBy('id','DESC')->get();
		$incomes = category::where('businessID',Auth::user()->businessID)->get();
		$OriginalIncomes = category::where('businessID',0)->get();
      $accounts = accounts::where('businessID',Auth::user()->businessID)->pluck('title','id')->prepend('Choose deposit account','');
      
		if($invoice->tax == 0){
			$taxed = 0;
		}else{
			$taxed = $invoice->sub_total * ($invoice->tax / 100);
		}

		$count = 1; 
      
      return view('app.property.accounting.utility.show', compact('property','invoiceID','invoice','product','tenant','taxes','taxed','incomes','OriginalIncomes','business','mainMethods','paymentmethod','payments','count','propertyID','accounts','balance'));
   }
   
   /**
   * mail utility
   */
   public function compose_mail($propertyID,$invoiceID){
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

      $invoice = invoices::join('property_lease_utility','property_lease_utility.id','=','property_invoices.leaseUtilityID')
                           ->join('status','status.id','=','property_invoices.statusID')
                           ->join('business','business.id','=','property_invoices.businessID')
                           ->join('currency','currency.id','=','business.base_currency')
                           ->join('template','template.id','=','business.templateID')
									->where('property_invoices.invoice_type','Utility')
                           ->where('property_invoices.id',$invoiceID)
                           ->where('propertyID',$propertyID)
                           ->where('property_invoices.businessID',Auth::user()->businessID)
                           ->select('property_invoices.id as invoiceID','property_invoices.tenantID as tenantID','property_invoices.invoice_prefix','property_invoices.invoice_number as invoice_number','template_name','business.businessID as businessID','primary_email','business.name as business_name','property_invoices.paid as paid','currency.code as code','property_invoices.total as bill_total','property_invoices.paid as bill_paid','utility_No')
                           ->first();

      $product = invoice_products::where('invoiceID',$invoiceID)->where('businessID',Auth::user()->businessID)->where('category','utility')->first();

		$balance = invoices::join('property_lease_utility','property_lease_utility.id','=','property_invoices.leaseUtilityID')
									->where('propertyID',$propertyID)
									->where('tenantID',$invoice->tenantID)
									->where('property_invoices.businessID',Auth::user()->businessID)
									->where('invoice_type','Utility')
									->sum('balance');

      $tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
                           ->where('businessID',Auth::user()->businessID)
                           ->where('property_tenants.id',$invoice->tenantID)
                           ->select('property_tenants.id as tenantID','tenant_name','contact_email','email_cc')
                           ->first();
      
      $contacts = contact_persons::where('tenantID',$tenant->tenantID)->get();
      $files = documents::where('fileID',$invoiceID)->where('section','Utility')->where('businessID',Auth::user()->businessID)->get();
      $count = 1;

		$directory = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/utility/';

      //create directory if it doesn't exists
		if (!file_exists($directory)) {
			mkdir($directory, 0777,true);
		}

      $pdf = PDF::loadView('templates/'.$invoice->template_name.'/utility/billing', compact('property','invoiceID','invoice','product','tenant'));

		$pdf->save($directory.$invoice->invoice_prefix.$invoice->invoice_number.'.pdf');

      return view('app.property.accounting.utility.compose_mail', compact('invoice','files','contacts','tenant','property','propertyID','product','balance'));
   }

   /**
   * Send utility
   */
   public function send_mail(Request $request, $propertyID){
      $this->validate($request,[
			'email_from' => 'required|email',
			'send_to' 	 => 'required',
			'subject'    => 'required',
			'message'	 => 'required',
		]);
      
      //property
      $property = property::where('businessID',Auth::user()->businessID)->where('id',$propertyID)->first();

		//invoice_settings information
		$invoice = invoices::where('id',$request->invoiceID)->where('businessID',Auth::user()->businessID)->first();

		//client info
		$tenant = tenants::join('property_tenant_address','property_tenant_address.tenantID','=','property_tenants.id')
                           ->where('businessID',Auth::user()->businessID)
                           ->where('property_tenants.id',$invoice->tenantID)
                           ->select('property_tenants.id as tenantID','tenant_name','contact_email','email_cc')
                           ->first();


		$checkatt = count(collect($request->attach_files));

		if($checkatt > 0){
			//change file status to null
			$filechange = documents::where('section','utility')->where('fileID',$invoice->id)->where('businessID',Auth::user()->businessID)->get();
			foreach ($filechange as $fc) {
				$null = documents::where('id',$fc->id)->where('businessID',Auth::user()->businessID)->first();
				$null->attach = "No";
				$null->save();
			}

			for($i=0; $i < count($request->attach_files); $i++ ) {
				$sendfile = documents::where('id',$request->attach_files[$i])->where('businessID',Auth::user()->businessID)->first();
				$sendfile->attach = "Yes";
				$sendfile->save();
			}
		}else{
			//change file status to null
			$change = documents::where('section','utility')->where('fileID',$invoice->id)->where('businessID',Auth::user()->businessID)->get();
			foreach ($change as $cs) {
				$null = documents::where('id',$cs->id)->where('businessID',Auth::user()->businessID)->first();
				$null->attach = "No";
				$null->save();
			}
		}

		//check for email CC
		$checkcc = count(collect($request->email_cc));

		//save email
		$trackCode = Helper::generateRandomString(9);

		$emails = new emails;
		$emails->message   = $request->message;
		$emails->clientID  = $tenant->tenantID;
		$emails->subject   = $request->subject;
		$emails->tracking_code  = $trackCode;
		$emails->mail_from = $request->email_from;
		if($checkatt > 0){
			$emails->attachment = 'yes';
		}
		$emails->category  = 'Tenants';
      $emails->folder    = 'Sent';
		$emails->status    = 'Sent';
		$emails->ip 		 = Helper::get_client_ip();
		$emails->type      = 'Outgoing';
		$emails->section   = 'Billing';
      $emails->invoice_id = $request->invoiceID;
		$emails->mail_to   = $request->send_to;
		$emails->created_by    = Auth::user()->id;
		$emails->businessID   = Auth::user()->businessID;
		if($checkcc > 0){
			$emails->cc   	= json_encode($request->get('email_cc'));
		}
		$emails->save();

		//update invoice
		$invoice->remainder_count = $invoice->remainder_count + 1;
		$invoice->sent_status  = 'Sent';
		$invoice->save();

		//send email
		$subject = $request->subject;

		$content = $request->message.'<br><img src="'.url('/').'/track/email/'.$trackCode.'/'.Auth::user()->businessID.'/'.$emails->id.'" width="1" height="1" /><img src="'.url('/').'/track/invoice/'.$invoice->invoice_code.'/'.Auth::user()->businessID.'/'.$invoice->id.'" width="1" height="1" />';


		$from = $request->email_from;
		$to = $request->send_to;
		$mailID = $emails->id;
		$docID = $invoice->id; //invoice_settings ID

		$attachment = base_path().'/public/businesses/'.Wingu::business(Auth::user()->businessID)->businessID.'/property/'.$property->property_code.'/utility/'.$invoice->invoice_prefix.$invoice->invoice_number.'.pdf';

		Mail::to($to)->send(new sendUtility($content,$subject,$from,$mailID,$docID,$attachment));

		//recorord activity
		$activities = 'Utility Billing #'.$invoice->invoice_prefix.$invoice->invoice_number.' has been sent to the tenant by '.Auth::user()->name;
		$section = 'Billing';
		$type = 'Utility';
		$adminID = Auth::user()->id;
		$activityID = $request->invoiceID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Billing successfully sent to Tenant');

		return redirect()->back();
   }

   /**
   * utility payments
   **/
   public function pay_utility(Request $request,$propertyID,$invoiceID){

      $this->validate($request, [
			'amount' => 'required',
			'tenantID' => 'required',
		]);

		//update invoice payment & status
		$invoice = invoices::where('id',$invoiceID)->where('businessID',Auth::user()->businessID)->where('propertyID',$propertyID)->first(); 

		//update payment
		$oldPaid = $invoice->paid;
		$newPaid = $oldPaid + $request->amount;
		$invoice->balance = $invoice->total - $newPaid;
		$invoice->paid = $newPaid;

		//update status
		if($newPaid == $invoice->total || $newPaid > $invoice->total){
			$invoice->statusID = 1;
		}elseif($newPaid < $invoice->total && $newPaid != 0 ){
			$invoice->statusID = 3;
		}

		$invoice->save();

		//record payment
		$pay = new payments;
		$pay->amount            = $request->amount;
		$pay->balance           = $invoice->total - $newPaid;
		$pay->reference_number  = $request->transactionID;
		$pay->payment_method    = $request->payment_method;
		$pay->payment_date      = $request->payment_date;
		$pay->invoiceID         = $request->invoiceID;
		$pay->created_by        = Auth::user()->id;
		$pay->businessID        = Auth::user()->businessID;
		$pay->note              = $request->note;
		$pay->tenantID          = $request->tenantID;
		$pay->incomeID          = $request->incomeID;
		$pay->accountID         = $request->accountID;
		$pay->payment_category  = 'Received';
		$pay->save();

	   //tenant Credit
		if($invoice->paid > $invoice->total){
			$check = creditnote_settings::where('propertyID',$propertyID)->where('businessID',Auth::user()->businessID)->count();
			if($check != 1){
				Prop::make_creditnote_settings($propertyID);
			}

			//update creditnote number
			$setting = creditnote_settings::where('businessID',Auth::user()->businessID)->first();

			$creditAmount = $invoice->paid - $invoice->total;

			$credit					      = new creditnote;
			$total                     = $creditAmount;
			$credit->created_by		   = Auth::user()->id;
			$credit->tenantID	 	      = $request->tenantID;
			$credit->creditnote_number = $setting->number+1;
			$credit->creditnote_prefix  = $setting->prefix;
			$credit->leaseID           = $invoice->leaseID;
			$credit->total		         = $total;
			$credit->main_amount		   = $total;
			$credit->balance		      = $total;
			$credit->credit_code 	   = Helper::generateRandomString(16);
			$credit->taxvalue		      = 0;
			$credit->title             = 'Payment credit for invoice #'.$invoice->invoice_prefix.$invoice->invoice_number;
			$credit->sub_total		   = $total;
			$credit->creditnote_date   = date('Y-m-d');
			$credit->statusID		      = 21;
			$credit->propertyID        = $request->propertyID;
			$credit->paymentID         = $pay->id;
			$credit->businessID 	      = Auth::user()->businessID;
			$credit->save();
			
			//products
			$product 					= new creditnote_products;
			$product->creditnoteID  = $credit->id;
			$product->item_name	   = 'Payment credit for invoice #'.$invoice->invoice_number;
			$product->quantity		= 1;
			$product->businessID  	= Auth::user()->businessID;
			$product->propertyID		= $propertyID;
			$product->price    		= $total;
			$product->main_amount   = $total;
			$product->sub_total    	= $total;
			$product->total_amount  = $total;
			$product->save();

			$setting->number = $setting->number + 1;
			$setting->save();

			//update payment
			$updateCredit = payments::where('id',$pay->id)->where('businessID',Auth::user()->businessID)->first();
			$updateCredit->credited = 'yes';
			$updateCredit->creditID = $credit->id;
			$updateCredit->save();
		}


		//Send payment acknowledgment message to client
		if($request->send_email == 'yes'){

			$clientName = Finance::client($invoice->customerID)->customer_name;

			$subject = 'Payment acknowledgment for #'.$invoice->invoice_prefix.$invoice->invoice_number;
			$to = Finance::client($invoice->customerID)->email;
			$content = '<span style="font-size: 12pt;">Hello '.$clientName.'</span><br/><br/>
			Thank you for the payment. Find the payment details below:<br/><br/>
			-------------------------------------------------
			<br/><br/>
			Amount:&nbsp;<strong>'. number_format($request->amount).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
			Balance:&nbsp;<strong>'. number_format($invoice->total - $invoice->paid).' '.Finance::currency(Wingu::business()->base_currency)->code.'</strong><br/>
			Date:&nbsp;<strong>'.date('jS F, Y', strtotime($request->payment_date)).'</strong><br/>
			Invoice number:&nbsp;<span style="font-size: 12pt;"><strong>#'.$invoice->invoice_prefix.$invoice->invoice_number.'</strong><br/><br/></span>
			-------------------------------------------------
			<br/><br/>
			We are looking forward working with you.<br/>';

			Mail::to($to)->send(new sendMessage($content,$subject));

			//save email
			$emails = new emails;
			$emails->message   = $content;
			$emails->clientID  = $invoice->customerID;
			$emails->subject   = $subject;
			$emails->mail_from = 'message-noreply@Winguerp.com';
			$emails->category  = 'Invoice Payment acknowledgment';
			$emails->status    = 'Sent';
			$emails->ip 		 = Helper::get_client_ip();
			$emails->type      = 'Outgoing';
			$emails->section   = 'invoices';
			$emails->mail_to   = $to;
			$emails->userID   = Auth::user()->id;
			$emails->businessID   = Auth::user()->businessID;
			$emails->save();

		}

		//record activity
		$activities = 'Payment has been recorded for Invoice #'.$invoice->invoice_prefix.$invoice->invoice_number.' by '.Auth::user()->name;
		$section = 'Invoice';
		$type = 'Payment';
		$adminID = Auth::user()->id;
		$activityID = $request->invoiceID;
		$businessID = Auth::user()->businessID;

		Wingu::activity($activities,$section,$type,$adminID,$activityID,$businessID);

		Session::flash('success','Payment successfully recorded');

		return redirect()->back();
   }

	/**
   * delete utility
   **/
	public function delete($invoiceID){
		return 'working';
	}
}
