<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Devision extends Model
{
    protected $fillable = [
        'company_id', 'code', 'name',
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
