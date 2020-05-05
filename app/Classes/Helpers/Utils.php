<?php


namespace App\Classes\Helpers;


class Utils
{
    /**
     * @param array $list
     * @param array $excludeKeys
     */
    public static function eraseArray(&$list, array $excludeKeys = []): void
    {
        $tmpList = [];
        foreach ($list as $key => $val) {
            $tmpList[$key] = $val;
        }
        $list = static::eraseArrayReturn($tmpList, $excludeKeys);
    }

    /**
     * @param array $list
     * @param array $excludeKeys
     * @return array
     */
    protected static function eraseArrayReturn($list, array $excludeKeys = []): array
    {
        foreach ($list as $key => $val) {
            if (is_object($val) || in_array($key, $excludeKeys, true)) {
                continue;
            }
            if (is_array($val)) {
                if (!empty($val)) {
                    $newVal = self::eraseArrayReturn($val);
                    if ($newVal === null || empty($newVal)) {
                        unset($list[$key]);
                    } else {
                        $list[$key] = $val = $newVal;
                    }
                } else {
                    unset($list[$key]);
                }
            } else {
                if ($val === null || empty($val)) {
                    unset($list[$key]);
                }
            }
        }
        return $list;
    }

    /**
     * @param array $arr1
     * @param array $arr2
     * @return array
     */
    public static function arrayCombine(array $arr1 = [], array $arr2 = []) :array
    {
        $cntArr1 = count($arr1);
        $cntArr2 = count($arr2);
        $difference = max($cntArr1, $cntArr2) - min($cntArr1, $cntArr2);
        if ($cntArr1 > $cntArr2) {
            for ($i = 1; $i <= $difference; $i++) {
                $arr2[$cntArr2 + $i] = $cntArr2 + 1;
            }
            return array_combine($arr1, $arr2);
        } else if ($cntArr1 < $cntArr2) {
            for ($i = 1; $i <= $difference; $i++) {
                $arr1[$cntArr1 + $i] = count($arr1) + 1;
            }
            return array_combine($arr1, $arr2);
        }
        return array_combine($arr1, $arr2);
    }
}