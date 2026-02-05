<?php

namespace SLNE\FilamentAuthorization;

class FilamentAuthorization
{
    public static function translate(
        string $key,
        array  $replace = [],
               $locale = null
    ): array|string|null
    {
        return __("filament-authorization::$key", $replace, $locale);
    }
}
