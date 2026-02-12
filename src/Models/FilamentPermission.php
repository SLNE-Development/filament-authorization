<?php

namespace SLNE\FilamentAuthorization\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function filamentRoles(): BelongsToMany {
        return $this->roles();
    }
}
