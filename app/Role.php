<?php

namespace App;

use Quarks\Laravel\Auditors\HasAuditors;
use Quarks\Laravel\Locking\LocksVersion;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasAuditors, LocksVersion, LogsActivity;

    protected static $logAttributes = ['*'];

    protected static $logAttributesToIgnore = [
        'created_by_id', 'created_by_type', 'updated_by_id', 'updated_by_type', 'deleted_by_id', 'deleted_by_type',
        'lock_version',
    ];

    protected static $logOnlyDirty = true;
}
