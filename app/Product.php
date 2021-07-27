<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        'company_id', 'name', 'description', 'price', 'stok', 'featured', 'img',
    ];

    /**
     * @param Builder $query
     * @param User|null $user
     * @return \Illuminate\Database\Concerns\BuildsQueries|Builder|mixed
     */
    public function scopeByCompany(Builder $query, User $user = null)
    {
        $user = $user ? : auth()->user();
        return $query->when($user instanceof User && !$user->hasRole('admin'), function (Builder $query) use($user) {
            return $query->where($query->qualifyColumn('company_id'), $user->company_id);
        });
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

}
