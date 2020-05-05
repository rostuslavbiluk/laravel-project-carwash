<?php


namespace App\Classes\Entity\GroupRoles;

use App\Classes\Enum\UserGroupRolesEnum;
use App\Model\User;

/**
 * Class UserRoles
 * @package App\Classes\Entity\GroupRoles
 */
class UserRoles
{
    protected $idRoles = [];
    protected $roles = [];
    protected $roleLevel = UserGroupRolesEnum::ROLE['MEMBER'];

    /**
     * UserRoles constructor.
     * @param User|null $user
     */
    public function __construct(?User $user)
    {
        if (is_callable([$user, 'getRoleIds'])) {
            $this->idRoles = $user->getRoleIds()->toArray();
        }
    }

    /**
     * Проверка пользователя к группе администраторов
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isRoleType([UserGroupRolesEnum::ROLE['ADMIN']]);
    }

    /**
     * @return bool
     */
    public function isCarwashUser(): bool
    {
        return $this->isRoleType([
            UserGroupRolesEnum::ROLE['ROOT_CARWASH'],
            UserGroupRolesEnum::ROLE['MEMBER_CARWASH'],
        ]);
    }

    /**
     * @return bool
     */
    public function isTaxiparkUser(): bool
    {
        return $this->isRoleType([
            UserGroupRolesEnum::ROLE['ROOT_TAXIPARK'],
            UserGroupRolesEnum::ROLE['MEMBER_TAXIPARK'],
        ]);
    }

    /**
     * @param array $typeRoles
     * @return bool
     */
    public function isRoleType(array $typeRoles): bool
    {
        if (empty($typeRoles)) {
            return false;
        }
        foreach ($typeRoles as $typeRole) {
            $type = array_search($typeRole, UserGroupRolesEnum::ROLE, true);
            if ($type) {
                $roleId = UserGroupRolesEnum::USER_ROLE[$type];
                if ((int)$roleId > 0 && in_array($roleId, $this->idRoles, true)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getRoleLevel(): string
    {
        foreach (UserGroupRolesEnum::ROLE as $role) {
            if ($this->isRoleType([$role])) {
                $this->roleLevel = $role;
            }
        }
        return $this->roleLevel;
    }

    /**
     * @return array
     */
    public function getRolesFormatted(): array
    {
        if (!empty($this->idRoles)) {
            foreach ($this->idRoles as $userIdRole) {
                $keyRole = array_search($userIdRole, UserGroupRolesEnum::USER_ROLE, true);
                $nameRole = (UserGroupRolesEnum::ROLE_NAME[$keyRole]) ?? false;
                if ($nameRole) {
                    $this->roles[] = [
                        'id' => $userIdRole,
                        'key' => $keyRole,
                        'name' => $nameRole
                    ];
                }
            }
        }
        return $this->roles;
    }
}
