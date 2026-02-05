<?php

namespace SLNE\FilamentAuthorization;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use SLNE\FilamentAuthorization\Http\Middleware\FilamentAuthenticate;
use SLNE\FilamentAuthorization\Http\Middleware\FilamentAuthenticateSession;
use UnitEnum;

class FilamentAuthorizationPlugin implements Plugin
{
    private ?string $authHome = "";
    private string|UnitEnum|null $navigationGroup = null;
    private ?int $navigationSortIndex = null;
    private ?string $userModel = null;

    private string $permissionPermissionPrefix = "permission";
    private string $rolePermissionPrefix = "role";

    private string $permissionRolesRelation = "roles";
    private string $rolePermissionsRelation = "permissions";

    public function getId(): string
    {
        return FilamentAuthorizationServiceProvider::$name;
    }

    public function register(Panel $panel): void
    {
        $panel->middleware([
            FilamentAuthenticate::class
        ]);

        $panel->authMiddleware([
            FilamentAuthenticateSession::class
        ]);

        $panel->strictAuthorization();

        $panel->discoverClusters(
            in: __DIR__ . "/Filament/Clusters",
            for: "SLNE\\FilamentAuthorization\\Filament\\Clusters",
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }


    public function withUserModel(string $userModel): static
    {
        if (!is_subclass_of($userModel, Model::class)) {
            throw new \InvalidArgumentException("The user model must be a subclass of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->userModel = $userModel;

        return $this;
    }

    public function withAuthHome(string $authHome): static
    {
        $this->authHome = $authHome;

        return $this;
    }

    public function withNavigationGroup(string|UnitEnum $navigationGroup): static
    {
        $this->navigationGroup = $navigationGroup;

        return $this;
    }

    public function withNavigationSortIndex(int $navigationSortIndex): static
    {
        $this->navigationSortIndex = $navigationSortIndex;

        return $this;
    }

    public function getNavigationGroup(): string|UnitEnum|null
    {
        return $this->navigationGroup;
    }

    public function getNavigationSort(): ?int
    {
        return $this->navigationSortIndex;
    }

    public function getUserModel(): ?string
    {
        return $this->userModel;
    }

    public function getAuthHome(): ?string
    {
        return $this->authHome;
    }

    public function getPermissionPermissionPrefix(): string
    {
        return $this->permissionPermissionPrefix;
    }

    public function getRolePermissionPrefix(): string
    {
        return $this->rolePermissionPrefix;
    }

    public function getPermissionRolesRelation(): string
    {
        return $this->permissionRolesRelation;
    }

    public function getRolePermissionsRelation(): string
    {
        return $this->rolePermissionsRelation;
    }

    public function withPermissionPermissionPrefix(string $permissionPermissionPrefix): static
    {
        $this->permissionPermissionPrefix = $permissionPermissionPrefix;
        return $this;
    }

    public function withRolePermissionPrefix(string $rolePermissionPrefix): static
    {
        $this->rolePermissionPrefix = $rolePermissionPrefix;
        return $this;
    }

    public function withPermissionRolesRelation(string $permissionRolesRelation): static
    {
        $this->permissionRolesRelation = $permissionRolesRelation;
        return $this;
    }

    public function withRolePermissionsRelation(string $rolePermissionsRelation): static
    {
        $this->rolePermissionsRelation = $rolePermissionsRelation;
        return $this;
    }

    public function getPermissionModel(): string
    {
        return config("filament-authorization.permission_model");
    }

    public function getRoleModel(): string
    {
        return config("filament-authorization.role_model");
    }
}
