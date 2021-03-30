<?php

return [

    /*
     * Global options
     */
    'options' => [
        'words_per_minute' => 230,
        'strip_tags'       => false,
        'units'            => [
            /*
             * Time units in seconds which seconds will be converted to
             */
            'second' => 1,
            'minute' => 60,
            'hour'   => 3600
        ]
    ],

    /*
     * Words counter
     */
    'counter' => Leshkens\LaravelReadTime\Counter::class,

    'locales' => [
        'en' => Leshkens\LaravelReadTime\Locales\En::class
    ]
];
