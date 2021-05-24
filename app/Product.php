<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        'company_id', 'name', 'description', 'price', 'stok', 'featured', 'img',
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

}
