<?php

namespace App\Http\Controllers\Api;

use App\Classes\Entity\User\UserInfo;
use App\Classes\Enum\ExternalEnum;
use App\Classes\Enum\UserGroupRolesEnum;
use App\Classes\Helpers\Base;
use App\Classes\Helpers\Phone;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Classes\Services\SmsManager;
use Exception;
use Error;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Request return",
 * )
 *
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    protected $soulPassword = 'carwash';

    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'register',
                'confirmCode',
                'newConfirmCode',
                'refreshToken'
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/me",
     *     operationId="getUserData",
     *     tags={"Auth"},
     *     summary="Returns user first data",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="username", type="string", description="user name"),
     *                 @OA\Property(property="personal_phone", type="string", description="user phone"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     * @return JsonResponse
     */
    public function me()
    {
        try {
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$user = Auth::guard('api')->user();
            $user = new UserInfo();
            $name = $user->getAttribute('name');
            $secondName = $user->getAttribute('second_name');
            $lastName = $user->getAttribute('last_name');
            $phone = $user->getAttribute('personal_phone');
            if (!empty($phone)) {
                $phone = Phone::getFormatted($phone);
            }
            $result = [
                'username' => implode(' ', [$lastName, $name, $secondName]),
                'personal_phone' => $phone,
            ];
            return response()->json($result);
        } catch (Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     operationId="userLogout",
     *     tags={"Auth"},
     *     summary="Returns message on user logout",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="successful", description="custom status"),
     *                 @OA\Property(property="message", type="string", description="custom message"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     * @return JsonResponse
     */
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'status' => 'successful',
                'message' => 'Successfully logged out'
            ]);
        } catch (Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/refresh",
     *     operationId="userRefrashToken",
     *     tags={"Auth"},
     *     summary="Return new user token",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="access_token", type="string", description="user token for request"),
     *                 @OA\Property(property="token_type", type="string", default="bearer", description="default type token"),
     *                 @OA\Property(property="expires_in", type="integer", description="expires token"),
     *                 @OA\Property(property="status", type="string", default="successful", description="custom status"),
     *                 @OA\Property(property="message", type="string", description="custom message"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="userLogin",
     *     tags={"Auth"},
     *     summary="User login",
     *     @OA\Parameter(
     *         description="user phone",
     *         in="query",
     *         name="phone",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="+7(333)333-33-33"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="successful", description="custom status"),
     *                 @OA\Property(property="message", type="string", description="custom message"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $phone = Phone::normalize((string)$request->input('phone'));
            if (empty($phone)) {
                throw new ErrorException('Введите телефон');
            }
            $user = User::where((new LoginController())->username(), $phone)->first();
            if (!$user) {
                throw new ErrorException('Ошибка авторизации');
            }
            $confimCode = Base::createCode($phone);
            if (empty($confimCode)) {
                throw new ErrorException('Что-то пошло не так, повторите попытку');
            }
            /* confim register user on phone number */
            $smsParams = [
                'phone' => $phone,
                'confirm_code' => $confimCode,
            ];
            $isSuccess = SmsManager::sendConfim($smsParams);
            if (!$isSuccess) {
                throw new ErrorException('Ошибка отправки кода подтверждения, повторите попытку');
            }
            $user->setAttribute('confirm_code', $smsParams['confirm_code']);
            $isExternal = ($user->getAttributeValue('external_auth_id') === ExternalEnum::TYPE['MOBILE']) ?? false;
            if ($isExternal) {
                $user->setAttribute('password', bcrypt($smsParams['confirm_code'] . $this->soulPassword));
            }
            $user->save();
            //TODO убрать вывод ключа test в response после отладки
            return response()->json([
                'status' => 'successful',
                'message' => 'Код подтверждения успешно отправлен',
                'test' => $smsParams
            ]);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/register",
     *     operationId="userRegister",
     *     tags={"Auth"},
     *     summary="User register",
     *     @OA\Parameter(
     *         description="user phone",
     *         in="query",
     *         name="phone",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="+7(333)333-33-33"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="user name",
     *         in="query",
     *         name="name",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="access_token", type="string", description="user token for request"),
     *                 @OA\Property(property="status", type="string", default="successful", description="custom status"),
     *                 @OA\Property(property="message", type="string", description="custom message"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $phone = Phone::normalize((string)$request->input('phone'));
            $user = User::where('username', $phone)->first();
            if ($user) {
                throw new ErrorException('Номер телефона уже зарегистрирован в приложении');
            }
            $confimCode = Base::createCode($phone);
            $params = [
                'name' => $request->input('name'),
                'email' => Base::createEmail($phone),
                'password' => Hash::make($confimCode),
                'username' => $phone, // login

                'personal_phone' => $phone,
                'active' => 'N',
                'external_auth_id' => ExternalEnum::TYPE['MOBILE'],
                'confirm_code' => $confimCode,

                'last_name' => '',
                'second_name' => '',
                'checkword' => '',
                'personal_photo' => 0,
                'personal_gender' => '',
                'personal_birthdate' => '',
                'personal_mobile' => $phone,
                'personal_city' => '',
            ];
            $user = User::create($params);
            if (!$user) {
                throw new ErrorException('Ошибка создания аккаунта, повторите еще раз');
            }
            $user->roles()->sync(UserGroupRolesEnum::DEFAULT_ROLE);
            /* confim register user on phone number */
            $smsParams = [
                'phone' => $phone,
                'confirm_code' => $confimCode,
            ];
            SmsManager::sendConfim($smsParams);
            return response()->json([
                'access_token' => bcrypt($phone),
                'status' => 'successful',
                'message' => 'Пользователь зарегистрирован, требуется подтверждение'
            ]);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/confirm_code",
     *     operationId="userConfirmCode",
     *     tags={"Auth"},
     *     summary="Return user token after confirm code",
     *     @OA\Parameter(
     *         description="user phone",
     *         in="query",
     *         name="phone",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="+7(333)333-33-33"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="confim code for access",
     *         in="query",
     *         name="confirm_code",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="access_token", type="string", description="user token for request"),
     *                 @OA\Property(property="token_type", type="string", default="bearer", description="default type token"),
     *                 @OA\Property(property="expires_in", type="integer", description="expires token"),
     *                 @OA\Property(property="status", type="string", default="successful", description="custom status"),
     *                 @OA\Property(property="message", type="string", description="custom message"),
     *             ),
     *         ),
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="filter", type="string", description="filter phone"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmCode(Request $request)
    {
        try {
            $phone = Phone::normalize((string)$request->input('phone'));
            $confirmCode = $request->input('confirm_code');
            if (empty($phone) || empty($confirmCode)) {
                throw new ErrorException('Введите телефон и код подтверждения');
            }
            $user = $this->getUser($phone, $confirmCode);
            if (!$user) {
                throw new ErrorException('Подтверждение кода не корректно');
            }
            $user->setAttribute('active', 'Y');
            $user->save();
            $token = $this->getAuthToken($user);
            return $this->respondWithToken($token);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/new_confirm_code",
     *     operationId="userNewConfirmCode",
     *     tags={"Auth"},
     *     summary="Return new confirm code for confirm user",
     *     @OA\Parameter(
     *         description="user phone",
     *         in="query",
     *         name="phone",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="+7(333)333-33-33"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="successful", description="custom status"),
     *                 @OA\Property(property="message", type="string", description="custom message"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function newConfirmCode(Request $request)
    {
        try {
            $phone = Phone::normalize((string)$request->input('phone'));
            if (empty($phone)) {
                throw new ErrorException('Введите ваш номер телефона');
            }
            $user = User::where((new LoginController())->username(), $phone)->first();
            if (!$user) {
                throw new ErrorException('Не корректный телефон');
            }
            $confimCode = Base::createCode($phone);
            if (empty($confimCode)) {
                throw new ErrorException('Что-то пошло не так, повторите попытку');
            }
            /* confim register user on phone number */
            $smsParams = [
                'phone' => $phone,
                'confirm_code' => $confimCode,
            ];
            $isSuccess = SmsManager::sendConfim($smsParams);
            if (!$isSuccess) {
                throw new ErrorException('Ошибка отправки кода подтверждения, повторите попытку');
            }
            $user->setAttribute('confirm_code', $smsParams['confirm_code']);
            $isExternal = ($user->getAttributeValue('external_auth_id') === ExternalEnum::TYPE['MOBILE']) ?? false;
            if ($isExternal) {
                $user->setAttribute('password', bcrypt($smsParams['confirm_code'] . $this->soulPassword));
            }
            $user->save();
            //TODO убрать вывод ключа test в response после отладки
            return response()->json([
                'status' => 'successful',
                'message' => 'Код подтверждения успешно отправлен',
                'test' => $smsParams
            ]);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/refresh_token",
     *     operationId="userUpdateToken",
     *     tags={"Auth"},
     *     summary="Return new user token",
     *     @OA\Parameter(
     *         description="user phone",
     *         in="query",
     *         name="phone",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="+7(333)333-33-33"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="confim code for access",
     *         in="query",
     *         name="code",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="access_token", type="string", description="user token for request"),
     *                 @OA\Property(property="token_type", type="string", default="bearer", description="default type token"),
     *                 @OA\Property(property="expires_in", type="integer", description="expires token"),
     *                 @OA\Property(property="status", type="string", default="successful", description="custom status"),
     *                 @OA\Property(property="message", type="string", description="custom message"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="unexpected error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorModel")
     *     ),
     *     security={
     *       {"token": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refreshToken(Request $request)
    {
        try {
            $phone = Phone::normalize((string)$request->input('phone'));
            $confirmCode = $request->input('code');
            if (empty($phone) || empty($confirmCode)) {
                throw new ErrorException('Не корректный телефон');
            }
            $user = $this->getUser($phone, $confirmCode);
            if (!$user) {
                throw new ErrorException('Ошибка идентификации');
            }
            $token = $this->getAuthToken($user);
            return $this->respondWithToken($token);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param string $phone
     * @param string $code
     * @return Builder|Model|object|null
     */
    protected function getUser(string $phone, string $code)
    {
        return User::where((new LoginController())->username(), trim($phone))
            ->where('confirm_code', trim($code))
            ->first();
    }

    /**
     * @param User $user
     */
    protected function getAuthToken(User $user)
    {
        return Auth::guard('api')->login($user);
    }

    /**
     * @param string $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'status' => 'successful',
            'message' => 'Пользователь успешно авторизован'
        ]);
    }
}
