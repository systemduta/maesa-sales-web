<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'address', 'color', 'logo', 'background',
    ];

    public function devisions()
    {
        return $this->hasMany(Devision::class);
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
            return $query->whereHas('users', function (Builder $q) use ($user) {
                return $q->where('id', auth()->user()->id);
            });
        });
    }
}
