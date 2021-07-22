<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{
    protected $fillable =[
        'transaction_id', 'title', 'body', 'from_user', 'to_user'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function from_user_name()
    {
        return $this->belongsTo(User::class, 'from_user');
    }
}
