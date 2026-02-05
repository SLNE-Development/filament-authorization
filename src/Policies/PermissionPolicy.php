<?php

namespace SLNE\FilamentAuthorization\Policies;

use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;

class PermissionPolicy extends FilamentPolicy
{
    public static function getModel(): string
    {
        return FilamentAuthorizationPlugin::get()->getPermissionModel();
    }

    public static function getPermissionPrefix(): string
    {
        return FilamentAuthorizationPlugin::get()->getPermissionPermissionPrefix();
    }
}
