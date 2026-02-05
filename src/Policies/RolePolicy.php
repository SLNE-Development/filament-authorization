<?php

namespace SLNE\FilamentAuthorization\Policies;

use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;

class RolePolicy extends FilamentPolicy
{
    public static function getModel(): string
    {
        return FilamentAuthorizationPlugin::get()->getRoleModel();
    }

    public static function getPermissionPrefix(): string
    {
        return FilamentAuthorizationPlugin::get()->getRolePermissionPrefix();
    }
}
