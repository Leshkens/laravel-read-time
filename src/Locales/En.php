<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Locales;

use Illuminate\Support\Str;
use Leshkens\LaravelReadTime\Contracts\LocaleInterface;

/**
 * Class En
 *
 * @package Leshkens\LaravelReadTime\Locales
 */
class En implements LocaleInterface
{
    /**
     * @param int    $number
     * @param string $unit
     *
     * @return string
     */
    public function result(int $number, string $unit): string
    {
        return $number . ' ' . Str::plural($unit, $number) . ' on read';
    }
}
