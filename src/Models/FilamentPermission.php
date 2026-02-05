<?php

namespace SLNE\FilamentAuthorization\Models;

use Spatie\Permission\Models\Permission;

class FilamentPermission extends Permission
{
    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
