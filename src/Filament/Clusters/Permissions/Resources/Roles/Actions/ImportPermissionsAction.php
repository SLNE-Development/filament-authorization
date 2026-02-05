<?php

namespace SLNE\FilamentAuthorization\Filament\Clusters\Permissions\Resources\Roles\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Spatie\Permission\Models\Role;

class ImportPermissionsAction extends Action
{
    public ?Role $role = null;

    public static function getDefaultName(): ?string
    {
        return "import_permissions";
    }

    public function withRole(Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__("authorization.actions.import_permissions.label"));
        $this->icon(Heroicon::Document);
        $this->color("gray");
        $this->authorize("update");

        $this->modalHeading(__("authorization.actions.import_permissions.modal.heading"));
        $this->modalDescription(__("authorization.actions.import_permissions.modal.description"));

        $this->requiresConfirmation();

        $this->schema([
            Select::make("role_id")
                ->label(__("authorization.actions.import_permissions.schema.role_id.label"))
                ->preload()
                ->searchable()
                ->options(Role::query()->distinct()->pluck("name", "id")->toArray()),
            Checkbox::make("delete_existing")
                ->label(__("authorization.actions.import_permissions.schema.delete_existing.label"))
                ->helperText(__("authorization.actions.import_permissions.schema.delete_existing.helper_text")),
        ]);

        $this->action(function (array $data) {
            if (is_null($this->role)) {
                Notification::make()
                    ->title(__("authorization.actions.import_permissions.action.notifications.role_missing.title"))
                    ->body(__("authorization.actions.import_permissions.action.notifications.role_missing.description"))
                    ->danger()
                    ->send();

                return;
            }

            $roleId = $data["role_id"];
            $deleteExisting = $data["delete_existing"];

            $importedRole = Role::find($roleId);

            if ($deleteExisting) {
                $this->role->permissions()->detach();

                Notification::make()
                    ->title(__("authorization.actions.import_permissions.action.notifications.existing_permissions_deleted.title"))
                    ->body(__("authorization.actions.import_permissions.action.notifications.existing_permissions_deleted.description"))
                    ->success()
                    ->send();
            }

            $this->role->permissions()->syncWithoutDetaching($importedRole->permissions);

            Notification::make()
                ->title(__("authorization.actions.import_permissions.action.notifications.permissions_imported.title"))
                ->body(__("authorization.actions.import_permissions.action.notifications.permissions_imported.description"))
                ->success()
                ->send();

            $this->success();
        });
    }
}