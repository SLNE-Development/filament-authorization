<?php

namespace SLNE\FilamentAuthorization\Http\Middleware;

use Filament\Exceptions\NoDefaultPanelSetException;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;

class FilamentAuthenticate extends Middleware
{
    /**
     * @throws NoDefaultPanelSetException
     * @throws AuthenticationException
     */
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if (!$guard->check()) {
            $this->unauthenticated($request, $guards);

            /** @noinspection PhpUnreachableStatementInspection */
            return;
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        $user = $guard->user();
        $panel = Filament::getCurrentOrDefaultPanel();

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
