<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Permissions\RelationManagers;

use Filament\Actions\ActionGroup;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __("authorization.resources.role.title");
    }

    /**
     * @return string|null
     */
    public static function getLabel(): ?string
    {
        return __("authorization.resources.role.label");
    }

    /**
     * @return string|null
     */
    public static function getPluralLabel(): ?string
    {
        return __("authorization.resources.role.plural_label");
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__("authorization.resources.role.form.schema.name.label"))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                TextInput::make('guard_name')
                    ->label(__("authorization.resources.role.form.schema.guard_name.label"))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->default('web')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__("authorization.resources.role.table.columns.name.label"))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('guard_name')
                    ->label(__("authorization.resources.role.table.columns.guard_name.label"))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->multiple(),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
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
