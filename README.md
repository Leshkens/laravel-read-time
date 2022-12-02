# Laravel read time package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/leshkens/laravel-read-time.svg?style=flat-square)](https://packagist.org/packages/leshkens/laravel-read-time)
[![Total Downloads](https://img.shields.io/packagist/dt/leshkens/laravel-read-time.svg?style=flat-square)](https://packagist.org/packages/leshkens/laravel-read-time)

A package for laravel that shows users the approximate time to read content.

![img.png](https://user-images.githubusercontent.com/8939383/113155120-24f5e380-9252-11eb-95ec-402f4cf3a2e4.png)

### Requirements

- Laravel version 6 or higher

## Installation

You can install the package via composer:

``` bash
composer require leshkens/laravel-read-time
```

### Publish config file

``` bash
php artisan vendor:publish --provider="Leshkens\LaravelReadTime\Providers\ReadTimeServiceProvider"
```

## Config file `config/read-time.php`


### Global options:

``` php
'options' => [
    // The number of words per minute, based on which the approximate  
    // time for reading will be calculated. Default is 230    
    'words_per_minute' => 230,
    
    // Clear result string of html tags
    'strip_tags' => false,
    
    // How many seconds does a new unit start with
    'units' => [
        'second' => 0,
        'minute' => 60,
        //'hour'   => 3600
    ]
],

```

### Word counter class

``` php 
'counter' => Leshkens\LaravelReadTime\Counter::class,
```
You can use your class and logic in word counting. 
Your class must implement the `Leshkens\LaravelReadTime\Contracts\CounterInterface` interface. The logic should be in the `count()` method.

For example, this is what a standard word counter logic looks like:
``` php 
public function count(string $content): int
{
    return count(preg_split('/\s+/', $content, -1, PREG_SPLIT_NO_EMPTY));
}
```

### Locale list

List of locales for forming the string "time to read":
``` php 
'locales' => [
    'en' => Leshkens\LaravelReadTime\Locales\En::class
]
```
Locale class must implement the `Leshkens\LaravelReadTime\Contracts\LocaleInterface` interface. The logic should be in the `result()` method.

For example, let's add the Ru locale class:

``` php 
namespace App\Support\ReadTimeLocales;

use Leshkens\LaravelReadTime\Contracts\Localeable;
use function morphos\Russian\pluralize;

class Ru implements LocaleInterface
{
    protected $unitMap = [
        'second' => 'секунда',
        'minute' => 'минута',
        'hour'   => 'час'
    ];

    public function result(int $number, string $unit): string
    {
        return pluralize($number, $this->unitMap[$unit]);
    }
}
```
In config:

``` php 
'locales' => [
    'en' => Leshkens\LaravelReadTime\Locales\En::class,
    'ru' => App\Support\ReadTimeLocales\Ru::class
]
```

## Usage

### Object
``` php

use Illuminate\Support\Str;
use Leshkens\LaravelReadTime\Facades\ReadTime;

$readTime = ReadTime::parse('Lorem ipsum dolor sit amet, consectetur adipiscing elit...');
// Or array
$readTime = ReadTime::parse(['Lorem ipsum dolor sit amet', 'consectetur adipiscing elit']);

$number = $readTime->number; // 3
$unit   = $readTime->unit;   // second

$result = Str::plural($unit, $number);

return "{$number} {$result} on read"; // 3 seconds on read
```


You can pass your array of settings (the same settings as the global ones) as the second argument of the `ReadTime` object. 

Example:

``` php 

$options = [
    'words_per_minute' => 1,
    'units'            => [
        'second' => 1 // leave only a seconds
    ]
];

$readTime = ReadTime::parse('Lorem ipsum dolor sit amet, consectetur adipiscing elit...', $options);

$number = $readTime->number; // 3
$unit   = $readTime->unit;   // second

$result = Str::plural($unit, $number);

return "{$number} {$result} on read"; // 480 seconds on read
```
### String

Just add the `get()` method.

The method can take a locale (from package config locale list) string value as the first argument.
If nothing is passed to the method, or the value is null, the current application locale is taken.
``` php 
use Leshkens\LaravelReadTime\Facades\ReadTime;

ReadTime::parse('Lorem ipsum dolor sit amet, consectetur adipiscing elit...')
    ->get('ru');
```
Will return `3 секунды`

**Note:** If the object of the desired locale is not in the config file of the package, then by default the string for English will be output

You can also use the `readtime()` helper to render a string:
``` php 
readtime($content, $locale, $options);
```

### In model
Add the `HasReadTime` trait and `readTime()` method with settings to your model:

``` php 
use Illuminate\Database\Eloquent\Model;
use Leshkens\LaravelReadTime\Traits\HasReadTime;

class Article extends Model
{
    use HasReadTime;
    
    protected function readTime(): array
    {
        return [
            // Attribute for parse. You can split it with 
            // a dot (e.g 'content.text') if the desired 
            // attribute is inside a array or json
            'source' => 'content',
                    
            // No required. If this key is not present, then the current application locale is taken.
            'locale' => 'en',      
                  
            // No required. Options array.
            'options' => [
                'strip_tags' => true
            ]
        ];
    }
}
```
`$article->read_time` returns the string value of the time to read.

If your attribute contains an array or json with locales:

``` php 
// array
[
    'ru' => 'Какой-то прекрасный текст',
    'en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit'
]

// or json
{
    "ru": "Какой-то прекрасный текст",
    "en": "Lorem ipsum dolor sit amet, consectetur adipiscing elit"
}
```

you can set `localable` to `true`:

``` php 
protected function readTime(): array
{
    return [
        'source'    => 'content',
        'localable' => true
    ];
}
```
`$article->read_time` returns the array value:
``` php
[
  'ru' => '1 секунда'
  'en' => '3 seconds on read'
]
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email Leshkens@gmail.com instead of using the issue tracker.

## Credits

- [Alexey Chugunov](https://github.com/leshkens)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
