<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Contracts;

/**
 * Interface CounterInterface
 *
 * @package Leshkens\LaravelReadtime\Counter
 */
interface Counterable
{
    /**
     * @param string $content
     *
     * @return int
     */
    public function count(string $content): int;
}
