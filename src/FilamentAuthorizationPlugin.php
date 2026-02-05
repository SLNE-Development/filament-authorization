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
    public ?string $authHome = "" {
        get {
            return $this->authHome;
        }
        set(string|null $value) {
            $this->authHome = $value;
        }
    }

    public string|UnitEnum|null $navigationGroup = null {
        get {
            return $this->navigationGroup;
        }
        set(string|UnitEnum|null $value) {
            $this->navigationGroup = $value;
        }
    }

    public ?int $navigationSortIndex = null {
        get {
            return $this->navigationSortIndex;
        }
        set(int|null $value) {
            $this->navigationSortIndex = $value;
        }
    }

    /**
     * @var class-string<Model>|null
     */
    public ?string $userModel = null {
        get {
            return $this->userModel;
        }
        set(string|null $value) {
            if ($value !== null && !is_subclass_of($value, Model::class)) {
                throw new \InvalidArgumentException("The user model must be a subclass of Illuminate\\Database\\Eloquent\\Model");
            }

            $this->userModel = $value;
        }
    }

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
}
