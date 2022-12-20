<?php
namespace App\Models\finance\payments;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    Protected $table = 'fn_payments';

    public function invoice_client_payments($invoiceID)
	{
		$query = DB::table('fn_payments')
				->join('payments_types', 'payments_types.id', '=', 'invoice_payments.payment_id')	
				->where('invoice_payments.invoice_id', $invoiceID)
				->where('invoice_payments.user_id', 1)
				->get();		
		
		return $query;	
	}
}
