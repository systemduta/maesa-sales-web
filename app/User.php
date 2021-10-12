<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use TCG\Voyager\Facades\Voyager;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company_id','devision_id','device_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'company', 'devision', 'transaction', 'settings', 'target_visit','target_low',
        'target_middle','target_high', 'visits',
    ];
//    update this

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'performance',
        'visit_performance',
        'devision_name',
        'company_logo',
        'company_name'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function devision()
    {
        return $this->belongsTo('App\Devision');
    }

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function visit_today()
    {
        return $this->visits()->whereDate('visited_at', '=', date('Y-m-d'));
    }

    public function getPerformanceAttribute()
    {
        $achieved = $this->transaction->count();
        return collect([
            'achieved'      => $achieved,
            'target_low'    => $this->target_low??0,
            'target_middle' => $this->target_middle??0,
            'target_high'  => $this->target_high??0,
//            'target_low'    => Voyager::setting('target_low', 3),
//            'target_middle' => Voyager::setting('target_middle', 5),
//            'target_hight'  => Voyager::setting('target_hight', 10),
        ]);
    }

    public function getVisitPerformanceAttribute()
    {
        $achieved = $this->visit_today->count();
        return collect([
            'achieved'  => $achieved,
            'target'    => $this->target_visit??0
        ]);
    }

    public function getDevisionNameAttribute()
    {
        return $this->devision ? $this->devision->name : null;
    }

    public function getCompanyLogoAttribute()
    {
        return $this->company->logo;
    }

    public function getCompanyNameAttribute()
    {
        return $this->company->name;
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
            return $query->whereNotNull('company_id')->where('company_id', $user->company_id);
        });
    }
}
