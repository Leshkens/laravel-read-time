<?php

use Leshkens\LaravelReadTime\Facades\ReadTime;

if (!function_exists('readtime')) {

    /**
     * @param string|array|null $content
     * @param string|null       $locale
     * @param array             $options
     *
     * @return string
     */
    function readtime(
        $content,
        string $locale = null,
        array $options = []
    ): string
    {
        return ReadTime::parse($content, $locale, $options)
            ->get();
    }
}
