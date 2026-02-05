<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Permissions;

use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\PermissionCluster;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Permissions\Pages\ListPermissions;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Permissions\Pages\ViewPermission;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Permissions\RelationManagers\RolesRelationManager;
use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;
use Spatie\Permission\Models\Permission;
use UnitEnum;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;
    protected static ?string $cluster = PermissionCluster::class;

    public static function getLabel(): ?string
    {
        return __("authorization.resources.permission.label");
    }

    public static function getPluralLabel(): ?string
    {
        return __("authorization.resources.permission.plural_label");
    }

    public static function getNavigationBadge(): ?string
    {
        return Permission::query()->count();
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return FilamentAuthorizationPlugin::get()->navigationGroup;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__("authorization.resources.permission.form.schema.name.label"))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                TextInput::make('guard_name')
                    ->label(__("authorization.resources.permission.form.schema.guard_name.label"))
                    ->required()
                    ->maxLength(255)
                    ->default('web')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("name")
                    ->label(__("authorization.resources.permission.table.columns.name.label"))
                    ->searchable()
                    ->sortable(),
                TextColumn::make("guard_name")
                    ->label(__("authorization.resources.permission.table.columns.guard_name.label"))
                    ->sortable(),
                TextColumn::make("roles_count")
                    ->label(__("authorization.resources.permission.table.columns.roles_count.label"))
                    ->counts('roles')
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ])
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [
            "roles" => RolesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPermissions::route('/'),
            "view" => ViewPermission::route('/{record}'),
        ];
    }
}
