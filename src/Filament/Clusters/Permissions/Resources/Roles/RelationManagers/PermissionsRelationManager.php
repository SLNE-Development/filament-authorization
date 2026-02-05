<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\RelationManagers;

use Filament\Actions\ActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\Actions\ImportPermissionsAction;

class PermissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __("authorization.resources.permission.title");
    }

    /**
     * @return string|null
     */
    public static function getLabel(): ?string
    {
        return __("authorization.resources.permission.label");
    }

    /**
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __("authorization.resources.permission.plural_label");
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__("authorization.resources.permission.form.schema.name.label"))
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->unique(ignoreRecord: true),
                TextInput::make("guard_name")
                    ->label(__("authorization.resources.permission.form.schema.guard_name.label"))
                    ->nullable()
                    ->default('web')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__("authorization.resources.permission.table.columns.name.label"))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('guard_name')
                    ->label(__("authorization.resources.permission.table.columns.guard_name.label"))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->multiple(),
                ImportPermissionsAction::make()
                    ->withRole($this->ownerRecord),
            ])
            ->recordActions([
                ActionGroup::make([
                    DetachAction::make()
                        ->requiresConfirmation()
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
