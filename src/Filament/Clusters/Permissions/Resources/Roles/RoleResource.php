<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles;

use Exception;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\PermissionCluster;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\Pages\ListRoles;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\Pages\ViewRole;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\RelationManagers\PermissionsRelationManager;
use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;
use Spatie\Permission\Models\Role;
use UnitEnum;

class RoleResource extends Resource
{
    protected static ?string $cluster = PermissionCluster::class;

    public static function getModel(): string
    {
        return config("permission.models.role", Role::class);
    }

    public static function getLabel(): ?string
    {
        return __("authorization.resources.role.label");
    }

    public static function getPluralLabel(): ?string
    {
        return __("authorization.resources.role.plural_label");
    }

    public static function getNavigationBadge(): ?string
    {
        return (static::getModel())->count();
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return FilamentAuthorizationPlugin::get()->getNavigationGroup();
    }

    /**
     * @throws Exception
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__("authorization.resources.role.form.schema.name.label"))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__("authorization.resources.role.table.columns.name.label"))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('guard_name')
                    ->label(__("authorization.resources.role.table.columns.guard_name.label"))
                    ->searchable()
                    ->sortable()
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
            "permissions" => PermissionsRelationManager::make()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            "view" => ViewRole::route('/{record}'),
        ];
    }
}
