<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Permissions\Pages;

use Filament\Resources\Pages\ViewRecord;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Permissions\PermissionResource;

class ViewPermission extends ViewRecord
{
    protected static string $resource = PermissionResource::class;
}
