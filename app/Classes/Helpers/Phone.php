<?php


namespace App\Classes\Helpers;


class Phone
{
    public static $defaultFormat = '+?? (??) ??-??-??';
    public static $phoneRule = '/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/';

    /**
     * @param string $phone
     * @return string
     */
    public static function normalize(string $phone): string
    {
        if (!empty($phone)) {
            $phone = preg_replace('~\D~', '', $phone);
        }
        return $phone;
    }

    /**
     * @param string $phone
     * @return bool
     */
    public static function isCorrectPhone(string $phone): bool
    {
        return preg_match(static::$phoneRule, $phone);
    }

    /**
     * @param string $phone
     * @return string
     */
    public static function getFormatted(string $phone): string
    {
        $phone = (string)preg_replace('~\D~', '', $phone);
        if (strlen($phone) <= 10) {
            $numeral = substr($phone, 0, 1);
            if (!in_array($numeral, [7, 8])) {
                $phone = '7' . $phone;
            }
        }
        $n1 = substr($phone, 0, 1);
        $n2 = substr($phone, 1, 3);
        $n3 = substr($phone, 3, 3);
        $n4 = substr($phone, 6, 2);
        $n5 = substr($phone, 8, 2);
        return str_replace_array('??', [$n1, $n2, $n3, $n4, $n5], self::$defaultFormat);
    }
}