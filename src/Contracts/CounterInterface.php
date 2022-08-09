<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Contracts;

/**
 * Interface CounterInterface
 *
 * @package Leshkens\LaravelReadTime\Counter
 */
interface CounterInterface
{
    /**
     * @param string $content
     *
     * @return int
     */
    public function count(string $content): int;
}
