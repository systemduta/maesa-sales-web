<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'company_id', 'invoice_number', 'customer_name', 'address', 'total_price', 'discount', 'voucher', 'noted', 'status', 'bukti',
    ];

    protected $appends = ['invoice','payment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
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

    /**
     * @param Builder $query
     * @param User|null $user
     * @return \Illuminate\Database\Concerns\BuildsQueries|Builder|mixed
     */
    public function scopeByUser(Builder $query, User $user = null)
    {
        $user = $user ? : auth()->user();
        return $query->when($user instanceof User && $user->hasRole('user'), function (Builder $query) use($user) {
            return $query->where($query->qualifyColumn('user_id'), $user->id);
        });
    }

    public function scopeByCompany(Builder $query, User $user = null)
    {
        $user = $user ? : auth()->user();
        return $query->when($user instanceof User && !$user->hasRole('admin'), function (Builder $query) use($user) {
            return $query->where($query->qualifyColumn('company_id'), $user->company_id);
        });
    }

    public function getInvoiceAttribute()
    {
        return route('invoice', ['id'=> $this->getKey()]);
    }

    public function getPaymentAttribute()
    {
        return $this->company->payment;
    }

//    tetsing git git
}
