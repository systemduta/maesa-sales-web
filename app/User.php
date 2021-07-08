<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company_id','devision_id','device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'company', 'devision', 'transaction', 'settings'
    ];

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
        'devision_name',
        'company_logo'
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

    public function getPerformanceAttribute()
    {
        $acheived = $this->transaction->count();
//        ganti nilai target dari data setting yaak
        return collect([
            'achieved' => $acheived,
            'target_low' => 5,
            'target_middle' => 9,
            'target_high' => 16,
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
}
