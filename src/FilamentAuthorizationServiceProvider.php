<?php

namespace SLNE\FilamentAuthorization;

use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Gate;
use SLNE\FilamentAuthorization\Commands\CreateDefaultPermissionsCommand;
use SLNE\FilamentAuthorization\Commands\PolicyPermissionCommand;
use SLNE\FilamentAuthorization\Http\Policies\FilamentPolicy;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentAuthorizationServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-authorization';
    public static string $viewNamespace = 'filament-authorization';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->startWith(function (InstallCommand $command) {
                        $command->comment("Please make sure your user model uses the trait HasRoles by spatie permissions and also implements Authenticatable.");
                        if (!$command->confirm("Did you update your user model accordingly?", true)) {
                            $command->info("Aborting installation. Please update your user model and run the install command again.");
                            exit;
                        }

                        $command->comment("Please make sure to remove the default Authorization middlewares from middleware and authMiddleware in your panel provider.");
                        if (!$command->confirm("Did you update your panel provider accordingly?", true)) {
                            $command->info("Aborting installation. Please update your panel provider and run the install command again.");
                            exit;
                        }
                    })
                    ->askToStarRepoOnGitHub('slne-development/filament-authorization');
            });

        $package->hasConfigFile("permission");

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-authorization/{$file->getFilename()}"),
                ], 'filament-authorization-stubs');
            }
        }

        // Handle policies
        foreach (glob(__DIR__ . "/Http/Policies/*.php") as $file) {
            $class = "SLNE\\FilamentAuthorization\\Http\\Policies\\" . basename($file, ".php");

            if (class_exists($class) && $class != FilamentPolicy::class) {
                $model = $class::getModel() ?? null;

                if ($model) {
                    Gate::policy($model, $class);
                }
            }
        }
    }

    protected function getAssetPackageName(): ?string
    {
        return 'slne-development/filament-authorization';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            CreateDefaultPermissionsCommand::class,
            PolicyPermissionCommand::class
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_permission_tables',
        ];
    }
}
