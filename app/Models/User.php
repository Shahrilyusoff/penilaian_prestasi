<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'jawatan',
        'gred',
        'kementerian_jabatan',
        'pyd_group_id',
        'peranan'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pydGroup()
    {
        return $this->belongsTo(PydGroup::class);
    }

    public function pppEvaluations()
    {
        return $this->hasMany(Evaluation::class, 'ppp_id');
    }

    public function ppkEvaluations()
    {
        return $this->hasMany(Evaluation::class, 'ppk_id');
    }

    public function pydEvaluations()
    {
        return $this->hasMany(Evaluation::class, 'pyd_id');
    }

    public function pppSkts()
    {
        return $this->hasMany(Skt::class, 'ppp_id');
    }

    public function pydSkts()
    {
        return $this->hasMany(Skt::class, 'pyd_id');
    }

    public function isSuperAdmin()
    {
        return $this->peranan === 'super_admin';
    }

    public function isAdmin()
    {
        return $this->peranan === 'admin';
    }

    public function isPPP()
    {
        return $this->peranan === 'ppp';
    }

    public function isPPK()
    {
        return $this->peranan === 'ppk';
    }

    public function isPYD()
    {
        return $this->peranan === 'pyd';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'peranan'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}