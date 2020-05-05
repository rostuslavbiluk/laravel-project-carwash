<?php

namespace App\Http\Controllers;


use App\Classes\Entity\User\UserInfo;
use App\Classes\Enum\GenderEnum;
use App\Classes\Entity\Profile;
use App\Classes\Helpers\Phone;
use App\Classes\Helpers\Utils;
use App\Model\Entity;
use App\Model\EntityService;
use App\Model\EntityServiceList;
use App\Model\Cities;
use App\Model\Group;
use App\Model\User;
use App\Http\Requests;
use App\Classes\Helpers\ModelHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Error;
use ErrorException;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index()
    {
        //$currentUser = Auth::user();
        $arResult = [];

        /*$userInfo = new UserInfo($currentUser);
        $arResult['USER'] = $userInfo->getInfoFormatted();

        if ($userInfo->isRoleType(UserGroupRolesEnum::ROLE['ADMIN'])) {
            $arResult = array_merge($arResult, Profile\Admin\IndexPage::index());
            return view('index')->with(compact('arResult'));
        }

        if ($userInfo->isRoleType(UserGroupRolesEnum::ROLE['ROOT_CARWASH'])) {
            $arResult = array_merge($arResult, Profile\Carwash\IndexPage::index());
            return view('template.entity')->with(compact('arResult'));
        }

        if ($userInfo->isRoleType(UserGroupRolesEnum::ROLE['ROOT_TAXIPARK'])) {
            $arResult = array_merge($arResult, Profile\Taxipark\IndexPage::index());
            return view('template.entity')->with(compact('arResult'));
        }*/

        return view('template.empty')->with(compact('arResult'));
    }

    public function edit(User $user, Request $request)
    {
        if ($request->input('confim') !== 'Y') {
            return back()->with([
                'message' => 'Необходимо согласие с правилами и условиями'
            ]);
        }
        $requestCustom = $request->except(['confim', '_token']);
        Utils::eraseArray($requestCustom);
        foreach (['personal_phone', 'personal_mobile'] as $item) {
            if (array_key_exists($item, $requestCustom)) {
                $requestCustom[$item] = Phone::normalize($requestCustom[$item]);
            }
        }
        $rules = [
            'email' => 'sometimes|max:255|unique:users,email,' . $user->getId(),
            'password' => 'sometimes|required|min:8|max:12',
            'password_confirmation' => 'sometimes|required|min:8|max:12|same:password',
            'city' => 'sometimes|numeric|exists:' . Cities::class .',id',
            'name' => 'sometimes|required|max:255',
            'last_name' => 'sometimes|required|max:255',
            'second_name' => 'sometimes|required|max:255',
            'personal_gender' => 'sometimes|in:' . implode(',', array_keys(GenderEnum::TYPE)),
            'personal_phone' => 'sometimes|unique:' . User::class . ',personal_phone,' . $user->getId(),
            'personal_mobile' => 'sometimes|unique:' . User::class . ',personal_mobile,' . $user->getId(),
        ];
        $messages = [
            'password_confirmation.same' => 'Подтверждение пароля должно соответствовать паролю',
        ];
        $validator = Validator::make($requestCustom, $rules, $messages);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->messages());
        }
        if (!empty($requestCustom['groups'])) {
            $userGroups = array_merge($requestCustom['groups'], UserInfo::$defaultGroups);
            $requestCustom['groups'] = array_diff(array_unique($userGroups), []);
            $user->roles()->sync($requestCustom['groups']);
            unset($requestCustom['groups']);
        }
        if (!empty($requestCustom)) {
            $message = 'Данные успешно сохранены';
            $isSuccess = $user->fill($requestCustom)->save();
            if (!$isSuccess) {
                $message = 'Ошибка сохранения данных';
            }
            return back()->with(['message' => $message]);
        }
        return back();
    }

    public function profile()
    {
        $result = [];
        try {
            $user = new UserInfo();
            $result['user'] = $user->getInfoFormatted();
            $result['user']['is_admin'] = 'N';
            if ($user->roles()->isAdmin()) {
                $result['user']['is_admin'] = 'Y';
                ModelHelper::getReferenceList(Group::class, $result['roles']['list']);
            }
            ModelHelper::getReferenceList(Cities::class, $result['city']['list']);
            $result['user']['city'] = $user->getCity();
            $result['user']['personal_birthdate'] = $user->getAttribute('personal_birthdate');
            $result['user']['personal_mobile'] = $user->getAttribute('personal_mobile');
            $result['user']['personal_phone'] = $user->getAttribute('personal_phone');
            $result['user']['personal_gender'] = $user->getAttribute('personal_gender');
            $result['gender']['list'] = GenderEnum::TYPE;

            if ($user->roles()->isCarwashUser()) {
                $result['carwash'] = 'Y';
                $organization = $user->getModel()->pointCarwash()->first(['id', 'name', 'preview_text', 'phone']);
                if ($organization) {
                    $result['entity'] = $organization->toArray();
                }
            }
            if ($user->roles()->isTaxiparkUser()) {
                $result['taxipark'] = 'Y';
                $organization = $user->getModel()->taxipark()->first(['id', 'name', 'preview_text', 'phone']);
                if ($organization) {
                    $result['entity'] = $organization->toArray();
                }
            }

        } catch (Error|QueryException|ErrorException $e) {
        }
        return view('template.users.profile', ['result' => $result]);
    }
}
