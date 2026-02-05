<?php

namespace SLNE\FilamentAuthorization\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SLNE\FilamentAuthorization\Models\FilamentPermission;
use SLNE\FilamentAuthorization\Models\FilamentRole;
use SLNE\FilamentAuthorization\Policies\FilamentPolicy;
use SLNE\FilamentAuthorization\Policies\PermissionPolicy;
use SLNE\FilamentAuthorization\Policies\RolePolicy;

class FilamentAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected array $extraPolicies = [];

    public function register(): void
    {
        $this->booting(function () {
            $this->registerFilamentPolicies();
            $this->registerExtraPolicies();
        });
    }

    public function registerFilamentPolicies(): void
    {
        $directoryIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(app_path("Policies")));

        foreach ($directoryIterator as $file) {
            if ($file->getExtension() !== "php") {
                continue;
            }

            $relativeClass = str_replace([app_path() . DIRECTORY_SEPARATOR, '.php'], "", $file->getPathname());
            $class = str_replace(DIRECTORY_SEPARATOR, "\\", $relativeClass);

            Log::info("#########");
            Log::info("Checking class: " . $class);
            Log::info("Class Exists: " . class_exists($class));
            Log::info("Is Subclass of FilamentPolicy: " . is_subclass_of($class, FilamentPolicy::class));

            if (class_exists($class) && is_subclass_of($class, FilamentPolicy::class)) {
                Log::info("Found policy: " . $class);
                $model = $class::getModel() ?? null;
                Log::info("Model: " . $model);

                if ($model && class_exists($model)) {
                    Log::info("Registering policy: " . $class);
                    Gate::policy($model, $class);
                }
            }
            Log::info("#########");
        }
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerExtraPolicies(): void
    {
        $policies = array_merge($this->extraPolicies(), [
            FilamentRole::class => RolePolicy::class,
            FilamentPermission::class => PermissionPolicy::class
        ]);

        foreach ($policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array<class-string, class-string>
     */
    public function extraPolicies(): array
    {
        return $this->extraPolicies;
    }
}