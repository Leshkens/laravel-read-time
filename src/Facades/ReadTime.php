<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ReadTimeFacade
 *
 * @method static self        parse($content, string $locale = null, array $options = [])
 * @method static string|null get()
 *
 * @package Leshkens\LaravelReadTime
 */
class ReadTime extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'read-time';
    }
}
