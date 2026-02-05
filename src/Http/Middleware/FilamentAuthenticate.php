<?php

namespace SLNE\FilamentAuthorization\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;

class FilamentAuthenticate extends Middleware
{
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if (!$guard->check()) {
            $this->unauthenticated($request, $guards);
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        $user = $guard->user();
        $panel = Filament::getCurrentPanel();

        if ($panel != null) {
            abort_if(
                $user instanceof FilamentUser ?
                    (!$user->canAccessPanel($panel)) :
                    (config('app.env') !== 'local'),
                403,
            );
        }
    }

    protected function redirectTo(Request $request): ?string
    {
        return route(FilamentAuthorizationPlugin::get()->getAuthHome());
    }
}
