<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $appends = ['product_name', 'img'];

    protected $fillable = [
        'transaction_id', 'product_id', 'price', 'amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'product'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }

    public function getImgAttribute()
    {
        return $this->product->img;
    }
}
