<?php

namespace SLNE\FilamentAuthorization;

class FilamentAuthorization
{
    public static function translate(string $key, array $replace = []): array|string|null
    {
        return __("filament-authorization:$key", $replace);
    }
}
