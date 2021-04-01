<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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

        throw_if(!isset($settings['source']), 'Source target is required.');

        $source = $settings['source'];

        $options = Arr::get($settings, 'options', []);

        $value = Str::contains($source, '.')
            ? $this->{pull_first_substr($source)}
            : $this->$source;

        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === 0) {
                $value = $decoded;
            }
        }

        if (is_array($value)) {

            $value = Arr::get($value, $source, $value);

            if (is_array($value) && Arr::get($settings, 'localable', false)) {

                $result = $value;

                foreach ($result as $locale => $value) {
                    $result[$locale] = readtime($value, $locale, $options);
                }

                return $result;
            }
        }

        $locale = Arr::get($settings, 'locale');

        return readtime($value, $locale, $options);
    }
}
