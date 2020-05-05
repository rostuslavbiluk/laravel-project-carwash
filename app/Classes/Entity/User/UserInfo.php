<?php

namespace App\Classes\Entity\User;

use App\Classes\Enum\UserGroupRolesEnum;
use App\Model\User;
use App\Model\Cities;
use App\Classes\Entity\GroupRoles\UserRoles;
use Illuminate\Support\Facades\Auth;


/**
 * Class UserInfo
 * @package App\Classes\Entity\User
 */
class UserInfo
{
    public static $defaultGroups = [UserGroupRolesEnum::USER_ROLE['MEMBER']];
    protected $user;
    protected $roles;

    /**
     * UserInfo constructor.
     * @param int $userId
     */
    public function __construct(int $userId = 1)
    {
        if ($userId > 0) {
            //$this->user = Auth::loginUsingId($userId, true);
            $this->user = User::findOrFail($userId);
        } else {
            $this->user = Auth::user();
        }
        $this->roles = new UserRoles($this->user);
    }

    /**
     * @return User|null
     */
    public function getModel(): ?User
    {
        return $this->user ?? null;
    }

    /**
     * @return UserRoles|null
     */
    public function roles(): ?UserRoles
    {
        return $this->roles ?? null;
    }

    public function getId(): int
    {
        return (int)$this->getAttribute('id');
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getEmail(): string
    {
        return $this->getAttribute('email');
    }

    public function getCity(): array
    {
        /** @var Cities $city */
        $city = $this->getModel()->city()->first();
        return $city ? $city->toArray() : [];
    }

    /**
     * @param string $attr
     * @return string
     */
    public function getAttribute(string $attr): string
    {
        return (!is_null($this->getModel()) && $this->getModel()->getAttributeValue($attr)) ? $this->getModel()->getAttributeValue($attr) : '';
    }

    /**
     * @return array
     */
    public function getInfoFormatted(): array
    {
        return [
            'image' => 'template/img/avatar1.jpg',
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'active' => $this->getAttribute('active'),
            'second_name' => $this->getAttribute('second_name'),
            'last_name' => $this->getAttribute('last_name'),
            'roles' => ($this->roles()) ? $this->roles()->getRolesFormatted() : [],
            'role_level' => ($this->roles()) ? $this->roles()->getRoleLevel() : '',
        ];
    }
}