<?php


namespace App\Classes\Helpers\Group;

/**
 * Class AccessGroupHelper
 * @package App\Classes\Helpers\Group
 */
class AccessGroupHelper
{
    /**
     * @param array $userGroups
     *
     * @return array
     */
    public static function diffAccessGroups(array $userGroups = []): array
    {
        $groupForbidden = ClassHelper::$groupNotAccess;
        return array_diff($userGroups, $groupForbidden);
    }
}