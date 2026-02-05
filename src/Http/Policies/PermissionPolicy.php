<?php

namespace SLNE\FilamentAuthorization\Http\Policies;

use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;

class PermissionPolicy extends FilamentPolicy
{
    protected static function getModel(): string
    {
        return FilamentAuthorizationPlugin::get()->getPermissionModel();
    }

    protected static function getPermissionPrefix(): string
    {
        return FilamentAuthorizationPlugin::get()->getPermissionPermissionPrefix();
    }
}
