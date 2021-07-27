<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @param Builder $query
     * @param User|null $user
     * @return \Illuminate\Database\Concerns\BuildsQueries|Builder|mixed
     */
    public function scopeByUser(Builder $query, User $user = null)
    {
        $user = $user ? : auth()->user();
        return $query->when($user instanceof User && !$user->hasRole('admin'), function (Builder $query) use($user) {
            return $query->whereHas('company', function (Builder $q) use ($user) {
                return $q->whereHas('users', function (Builder $qu) use ($user) {
                    return $qu->where('id', auth()->user()->id);
                });
            });
        });
    }
}
