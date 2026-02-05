<?php

namespace SLNE\FilamentAuthorization\Models;

use Spatie\Permission\Models\Role;

class FilamentRole extends Role
{
    protected $fillable = [
        "name",
        "guard_name",
    ];

    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    public function getRouteKeyName(): string
    {
        return "name";
    }
}
