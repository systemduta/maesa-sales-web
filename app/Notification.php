<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable =[
        'title', 'body', 'from_user', 'to_user'
    ];
}
