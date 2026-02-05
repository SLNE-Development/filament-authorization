<?php

namespace SLNE\FilamentAuthorization\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Session\Middleware\AuthenticateSession as Middleware;
use SLNE\FilamentAuthorization\FilamentAuthorizationPlugin;

class FilamentAuthenticateSession extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return route(FilamentAuthorizationPlugin::get()->getAuthHome());
    }
}
