<?php

use Leshkens\LaravelReadTime\Facades\ReadTime;

if (!function_exists('readtime')) {

    /**
     * @param string|array|null $content
     * @param string|null       $locale
     * @param array             $options
     *
     * @return string|null
     */
    function readtime(
        $content,
        ?string $locale = null,
        array $options = []
    ): ?string
    {
        return ReadTime::parse($content, $options)
            ->get($locale);
    }
}

if (!function_exists('pull_first_substr')) {

    /**
     * @param string $string
     * @param string $separator
     *
     * @return string
     */
    function pull_first_substr(string &$string, string $separator = '.'): string
    {
        $arr = explode($separator, $string);

        $value = array_shift($arr);

        $string = implode('.', $arr);

        return $value;
    }
}
