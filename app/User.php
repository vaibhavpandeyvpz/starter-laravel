<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Quarks\Laravel\Auditors\HasAuditors;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasAuditors, HasRoles, LogsActivity, Notifiable;

    protected static $logAttributes = ['*'];

    protected static $logAttributesToIgnore = [
        'password', 'remember_token', 'created_by_id', 'created_by_type', 'updated_by_id', 'updated_by_type',
        'deleted_by_id', 'deleted_by_type',
    ];

    protected static $logOnlyDirty = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birthday' => 'date',
        'email_verified_at' => 'datetime',
        'enabled' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'enabled', 'photo', 'birthday', 'timezone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? Storage::disk('public')->url($this->photo) : null;
    }
}
