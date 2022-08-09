<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime;

use Leshkens\LaravelReadTime\Contracts\CounterInterface;

/**
 * Class Counter
 *
 * @package Leshkens\LaravelReadTime\Counter
 */
class Counter implements CounterInterface
{
    /**
     * @param string $content
     *
     * @return int
     */
    public function count(string $content): int
    {
        return count(preg_split('/\s+/', $content, -1, PREG_SPLIT_NO_EMPTY));
    }
}
