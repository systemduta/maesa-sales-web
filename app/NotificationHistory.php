<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{
    protected $fillable =[
        'transaction_id', 'title', 'body', 'from_user', 'to_user'
    ];
}
