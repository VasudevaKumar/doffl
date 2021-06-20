<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    protected $table = 'bills';
    
    public function getCompany()
    {
        return $this->belongsTo("App\Company", 'company_id');
    }
	
	public function getPayment()
    {
        return $this->belongsTo("App\BillPayments", 'pay_id');
    }
}
