<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Contracts;

/**
 * Interface Localeable
 *
 * @package Leshkens\LaravelReadtime\Contracts
 */
interface Localeable
{
    /**
     * @param int    $number
     * @param string $unit
     *
     * @return string
     */
    public function result(int $number, string $unit): string;
}
