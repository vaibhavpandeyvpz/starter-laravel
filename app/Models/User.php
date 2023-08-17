<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Quarks\Laravel\Auditors\HasAuditors;
use Quarks\Laravel\Locking\LocksVersion;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasAuditors, HasFactory, HasRoles, LocksVersion, LogsActivity, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'enabled',
        'photo',
        'birthday',
        'timezone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthday' => 'date',
        'email_verified_at' => 'datetime',
        'enabled' => 'boolean',
        'password' => 'hashed',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->logExcept([
                // quarks/laravel-auditors
                'created_by_id',
                'created_by_type',
                'updated_by_id',
                'updated_by_type',
                'deleted_by_id',
                'deleted_by_type',
                // quarks/laravel-locking
                'lock_version',
            ]);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? cdn_url($this->photo) : null;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $data = $this->toArray();
        $data['roles'] = $this->roles()->pluck('name');

        return $data;
    }
}
