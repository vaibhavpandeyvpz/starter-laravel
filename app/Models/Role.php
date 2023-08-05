<?php

namespace App\Models;

use Quarks\Laravel\Auditors\HasAuditors;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasAuditors;
}
