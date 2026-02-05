<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions;

use Filament\Clusters\Cluster;
use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;
use UnitEnum;

class PermissionCluster extends Cluster
{
    public static function getNavigationSort(): ?int
    {
        return FilamentAuthorizationPlugin::get()->navigationSortIndex;
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return FilamentAuthorizationPlugin::get()->navigationGroup;
    }
}
