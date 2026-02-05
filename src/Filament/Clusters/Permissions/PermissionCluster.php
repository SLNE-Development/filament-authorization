<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions;

use Filament\Clusters\Cluster;
use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;
use UnitEnum;

class PermissionCluster extends Cluster
{
    public static function getNavigationLabel(): string
    {
        return FilamentAuthorizationPlugin::get()->getNavigationLabel();
    }

    public static function getNavigationSort(): ?int
    {
        return FilamentAuthorizationPlugin::get()->getNavigationSort();
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return FilamentAuthorizationPlugin::get()->getNavigationGroup();
    }
}
