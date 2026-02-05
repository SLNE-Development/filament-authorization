<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\Pages;

use Exception;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\RoleResource;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    /**
     * @throws Exception
     */
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
