<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Contracts;

/**
 * Interface LocaleInterface
 *
 * @package Leshkens\LaravelReadTime\Contracts
 */
interface LocaleInterface
{
    /**
     * @param int    $number
     * @param string $unit
     *
     * @return string
     */
    public function result(int $number, string $unit): string;
}
