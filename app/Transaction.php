<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'company_id', 'invoice_number', 'customer_name', 'address', 'total_price', 'discount', 'voucher', 'noted', 'status', 'bukti',
    ];

    protected $appends = ['invoice'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function notification_histories()
    {
        return $this->hasMany(NotificationHistory::class);
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($transaction) {
            $transaction->transaction_details()->each(function($transaction_detail) {
                $transaction_detail->delete();
            });
            $transaction->notification_histories()->each(function($notification_history) {
                $notification_history->delete();
            });
        });
    }

    public function getInvoiceAttribute()
    {
        return route('invoice', ['id'=> $this->getKey()]);
    }
}
