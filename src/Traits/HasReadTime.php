<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Traits;

use Illuminate\Support\Arr;

/**
 * Trait HasReadTime
 *
 * @package Leshkens\LaravelReadTime\Traits
 */
trait HasReadTime
{
    /**
     * @return array
     */
    abstract protected function readTime(): array;

    /**
     * @return array|string|null
     */
    public function getReadTimeAttribute()
    {
        $settings = $this->readTime();

        $source = $settings['source'];
        $options = $settings['options'] ?? [];

        $value = $this->$source;

        if (is_null($value)) {
            return null;
        }

        if (isset($settings['localable']) && $settings['localable']) {

            $arr = is_array($value)
                ? $value
                : json_decode($value, true);

            throw_if(
                json_last_error() !== 0,
                "Attribute '{$source}' is not array or correct json."
            );

            $attribute = [];

            foreach ($arr as $locale => $value) {
                $attribute[$locale] = readtime($value, $locale, $options);
            }

            return $attribute;
        }

        $locale = $settings['locale'] ?? null;

        return readtime($value, $locale, $options);
    }

}
