<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Leshkens\LaravelReadTime\Locales\En;

/**
 * Class ReadTime
 *
 * @package Leshkens\LaravelReadTime
 */
class ReadTime
{
    /**
     * @var bool
     */
    protected $isNull = false;

    /**
     * @var int|null
     */
    public $number;

    /**
     * @var string|null
     */
    public $unit;

    /**
     * @param string|array|null $content
     * @param array             $options
     *
     * @return self
     */
    public function parse($content, array $options = []): self
    {
        $options = $this->options($options);

        $content = $this->parseContent($content, $options);

        if (is_null($content)) {
            $this->isNull = true;
        }

        $words = $this->wordsCount($content);

        $this->calculate($words, $options);

        return $this;
    }


    /**
     * @param string|null $locale
     *
     * @return string|null
     */
    public function get(string $locale = null): ?string
    {
        if ($this->isNull) {
            return null;
        }

        $locale = is_null($locale)
            ? app()->getLocale()
            : $locale;
        $class = config("read-time.locales.{$locale}", En::class);

        return app($class)->result($this->number, $this->unit);
    }

    /**
     * @param       $content
     * @param array $options
     *
     * @return string|null
     */
    protected function parseContent($content, array $options): ?string
    {
        if (is_array($content)) {

            $arr = [];

            foreach ($content as $item) {
                if (!is_null($item)) {
                    $arr[] = $item;
                }
            }

            $content = !count($arr)
                ? null
                : implode(' ', $arr);
        }

        if (Arr::get($options, 'strip_tags', false)) {
            $content = strip_tags($content);
        }

        return $content;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function options(array $options = []): array
    {
        return array_merge(config('read-time.options'), $options);
    }

    /**
     * @param string|null $locale
     *
     * @return string
     */
    protected function locale(string $locale = null): string
    {
        return is_null($locale)
            ? app()->getLocale()
            : $locale;
    }

    /**
     * @param int   $words
     * @param array $options
     *
     * @return void
     */
    protected function calculate(int $words, array $options): void
    {
        $wordsPerMinute = $options['words_per_minute'];

        $seconds = (int) ceil($words / ($wordsPerMinute / 60));

        $units = $options['units'];

        foreach (array_reverse($units) as $unit => $value) {
            if ($seconds >= $value) {
                $value = $value === 0 ? ++$value : $value;
                $this->number = (int) ceil($seconds / $value);
                $this->unit = $unit;
                break;
            }
        }
    }

    /**
     * @param string|null $content
     *
     * @return int
     */
    protected function wordsCount(?string $content): int
    {
        $class = config('read-time.counter', Counter::class);

        return app($class)->count($content ?? '');
    }
}
