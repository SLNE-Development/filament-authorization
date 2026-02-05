<?php

namespace SLNE\FilamentAuthorization\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SLNE\FilamentAuthorization\FilamentAuthorization
 */
class FilamentAuthorization extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SLNE\FilamentAuthorization\FilamentAuthorization::class;
    }
}
