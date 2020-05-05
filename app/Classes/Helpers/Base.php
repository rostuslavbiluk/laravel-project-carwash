<?php

namespace App\Classes\Helpers;

use Illuminate\Support\Str;

class Base
{
    /**
     * @param string $prefix
     * @param string $domain
     * @return string
     */
    public static function createEmail(string $prefix = 'test', string $domain = 'laravel.loc'): string
    {
        return $prefix . '@' . $domain;
    }

    /**
     * @param string $prefix
     * @param int $length
     * @return string
     */
    public static function createPassword(string $prefix = 'create', int $length = 8): string
    {
        $sSaltWorld = '1khj21f423k4vbj34hgbyosfxmwdxyfowufrv38745b' . microtime();
        return Str::random($length, $sSaltWorld . $prefix);
    }

    /**
     * @param string $prefix
     * @param int $length
     * @return string
     */
    public static function createCode(string $prefix = 'isCode', int $length = 5): string
    {
        $sSaltWorld = '1khj21f423k4vbj34hgbyosfxmwdxyfowufrv38745b' . microtime();
        return Str::random($length, $sSaltWorld . $prefix);
    }
}