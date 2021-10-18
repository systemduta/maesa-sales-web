<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = ['user_id','name','address','phone','result','photo','visited_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByCompany(Builder $query, User $user = null)
    {
        $user = $user ? : auth()->user();
        return $query->when($user instanceof User && !$user->hasRole('admin'), function (Builder $query) use($user) {
            return $query->whereHas('user', function (Builder $query) use ($user) {
                return $query->where('company_id', $user->company_id);
            });
        });
    }
}
