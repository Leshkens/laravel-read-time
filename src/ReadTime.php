<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadTime;

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
     * @var string
     */
    protected $locale;

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
     * @param string|null       $locale
     * @param array             $options
     *
     * @return self
     */
    public function parse($content, string $locale = null, array $options = []): self
    {

        if (is_array($content)) {
            $content = implode(' ', $content);
        }

        if (is_null($content)) {
            $this->isNull = true;
        }

        $options = $this->options($options);

        if ($options['strip_tags']) {
            $content = strip_tags($content);
        }

        $words = $this->wordsCount($content);

        $this->calculate($words, $options);
        $this->locale = $this->locale($locale);

        return $this;
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
    public function locale(string $locale = null): string
    {
        return is_null($locale)
            ? app()->getLocale()
            : $locale;
    }

    /**
     * @return string|null
     */
    public function get(): ?string
    {
        if ($this->isNull) {
            return null;
        }

        $class = config("read-time.locales.{$this->locale}", En::class);

        return app($class)->result($this->number, $this->unit);
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
            if (($seconds === 0 ? 1 : $seconds) >= $value) {
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
