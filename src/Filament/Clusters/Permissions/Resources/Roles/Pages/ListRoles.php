<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\RoleResource;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->mutateDataUsing(function (array &$data) {
                $name = $data['name'];
                $guardName = Str::slug($name);

                $data['guard_name'] = $guardName;

                return $data;
            }),
        ];
    }
}
