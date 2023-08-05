<?php

namespace App\Models;

use Quarks\Laravel\Auditors\HasAuditors;
use Quarks\Laravel\Locking\LocksVersion;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasAuditors, LocksVersion, LogsActivity;

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
}
