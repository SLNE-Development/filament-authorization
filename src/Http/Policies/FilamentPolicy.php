<?php

namespace SLNE\FilamentAuthorization\Http\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * @template T of Model
 */
abstract class FilamentPolicy
{
    /**
     * @var class-string<T>
     */
    protected static string $model;
    protected static string $permissionPrefix;

    public function __construct()
    {
        if (!isset(static::$model)) {
            throw new \LogicException("Please define static::\$model in " . static::class);
        }

        if (!isset(static::$permissionPrefix)) {
            throw new \LogicException("Please define static::\$permissionPrefix in " . static::class);
        }
    }

    public function getAllPermissions(): array
    {
        return [
            static::$permissionPrefix . '.viewAny',
            static::$permissionPrefix . '.view',
            static::$permissionPrefix . '.create',
            static::$permissionPrefix . '.update',
            static::$permissionPrefix . '.delete',
            static::$permissionPrefix . '.restore',
            static::$permissionPrefix . '.forceDelete',
            static::$permissionPrefix . '.deleteAny',
            static::$permissionPrefix . '.restoreAny',
            static::$permissionPrefix . '.forceDeleteAny',
        ];
    }

    private function checkAuthenticatable(Authenticatable $user): void
    {
        if (!method_exists($user, "getAllPermissions")) {
            throw new \LogicException("User model must implement Spatie HasRoles trait");
        }

        if (!method_exists($user, "hasPermissionTo")) {
            throw new \LogicException("User model must implement Spatie HasRoles trait");
        }
    }

    private function hasPermission(
        Authenticatable $user,
        string          $permission,
        ?string         $guard = "web",
        ?Model          $model = null
    ): bool
    {
        $this->checkAuthenticatable($user);

        $permission = static::$permissionPrefix . '.' . $permission;
        $hasStarPermission = $user->getAllPermissions()->contains("*");
        $hasDirectPermission = $user->hasPermissionTo($permission, $guard);

        return $hasStarPermission || $hasDirectPermission;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param Authenticatable $user
     * @return bool
     * @throws \Exception
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $this->hasPermission($user, "viewAny");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param Authenticatable $user
     * @param Model $model
     * @return bool
     * @throws \Exception
     */
    public function view(Authenticatable $user, Model $model): bool
    {
        return $this->hasPermission($user, "view", model: $model);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Authenticatable $user
     * @return bool
     * @throws \Exception
     */
    public function create(Authenticatable $user): bool
    {
        return $this->hasPermission($user, "create");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Authenticatable $user
     * @param Model $model
     * @return bool
     * @throws \Exception
     */
    public function update(Authenticatable $user, Model $model): bool
    {
        return $this->hasPermission($user, "update", model: $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Authenticatable $user
     * @param Model $model
     * @return bool
     * @throws \Exception
     */
    public function delete(Authenticatable $user, Model $model): bool
    {
        return $this->hasPermission($user, "delete", model: $model);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param Authenticatable $user
     * @param Model $model
     * @return bool
     * @throws \Exception
     */
    public function restore(Authenticatable $user, Model $model): bool
    {
        return $this->hasPermission($user, "restore", model: $model);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param Authenticatable $user
     * @param Model $model
     * @return bool
     * @throws \Exception
     */
    public function forceDelete(Authenticatable $user, Model $model): bool
    {
        return $this->hasPermission($user, "forceDelete", model: $model);
    }

    /**
     * Determine whether the user can bulk delete models.
     *
     * @param Authenticatable $user
     * @return bool
     * @throws \Exception
     */
    public function deleteAny(Authenticatable $user): bool
    {
        return $this->hasPermission($user, "deleteAny");
    }

    /**
     * Determine whether the user can bulk restore models.
     *
     * @param Authenticatable $user
     * @return bool
     * @throws \Exception
     */
    public function restoreAny(Authenticatable $user): bool
    {
        return $this->hasPermission($user, "restoreAny");
    }

    /**
     * Determine whether the user can bulk force-delete models.
     *
     * @param Authenticatable $user
     * @return bool
     * @throws \Exception
     */
    public function forceDeleteAny(Authenticatable $user): bool
    {
        return $this->hasPermission($user, "forceDeleteAny");
    }
}
