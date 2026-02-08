<?php

namespace SLNE\FilamentAuthorization\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function filamentRoles(): BelongsToMany {
        return $this->permissions();
    }
}
