<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'company_id', 'invoice_number', 'customer_name', 'address', 'total_price', 'discount', 'voucher', 'noted', 'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
