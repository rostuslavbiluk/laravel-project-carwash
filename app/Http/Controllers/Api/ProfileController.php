<?php

namespace App\Http\Controllers\Api;

use App\Classes\Entity\User\UserInfo;
use App\Http\Controllers\Controller;
use App\Model\Brands;
use App\Model\Profile;
use App\Model\ProfilesService;
use Illuminate\Http\Request;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Error;
use Exception;

/**
 * @OA\Tag(
 *     name="Profile",
 *     description="Request return",
 * )
 * Class ProfileController
 * @package App\Http\Controllers\Api
 */
class ProfileController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user_profiles",
     *     operationId="getProfiles",
     *     tags={"Profile"},
     *     summary="Returns list user profiles",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="successful"),
     *                 @OA\Property(property="message", type="string", default="", description="is custom message"),
     *                 @OA\Property(property="profiles", type="array", description="user profiles",
     *                     @OA\Items(ref="#/components/schemas/Profile")
     *                 ),
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
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $message = "У вас пока не добавлено ни одного профиля. <br/> Укажите свой профиль и вы будете видеть цены на услуги именно для вашего профиля";
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$collections = Auth::guard('api')->user()->profiles();
            $collections = (new UserInfo())->getModel()->profiles()->getResults();
            if ($collections->count() > 0) {
                $message = "Выберите профиль и услуги будут вам отображаться с актуальными для вас ценами";
                $profiles = $collections->toArray();
                foreach ($profiles as $profile) {
                    $idBrands[] = (int)$profile['brand'];
                    $idTypes[] = (int)$profile['type'];
                }
                $idBrands = array_unique($idBrands);
                if (!empty($idBrands)) {
                    $collections = Brands::whereIn('id', $idBrands)->get(['id', 'name']);
                    if ($collections->count() > 0) {
                        $brands = $collections->toArray();
                    }
                }
                $idTypes = array_unique($idTypes);
                if (!empty($idTypes)) {
                    $collections = ProfilesService::whereIn('id', $idTypes)->get(['id', 'name']);
                    if ($collections->count() > 0) {
                        $profilesService = $collections->toArray();
                    }
                }
                foreach ($profiles as &$profile) {
                    $findId = $profile['type'];
                    if (!empty($profilesService)) {
                        $findType = array_filter($profilesService, function ($item, $k) use ($findId) {
                            return (int)$item['id'] === (int)$findId;
                        }, ARRAY_FILTER_USE_BOTH);
                        if (!empty($findType)) {
                            $profile['type'] = array_shift($findType)['name'];
                        }
                    }
                    $findId = $profile['brand'];
                    if (!empty($brands)) {
                        $findType = array_filter($brands, function ($item, $k) use ($findId) {
                            return (int)$item['id'] === (int)$findId;
                        }, ARRAY_FILTER_USE_BOTH);
                        if (!empty($findType)) {
                            $profile['brand'] = array_shift($findType)['name'];
                        }
                    }
                }
                unset($profile);
            }
            return response()->json([
                'status' => 'successful',
                'message' => $message,
                'profiles' => $profiles ?? [],
            ]);
        } catch (Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     *     path="/change_active_profile/{id}",
     *     operationId="getActivateProfile",
     *     tags={"Profile"},
     *     summary="Set one active profiles",
     *     @OA\Parameter(
     *         description="user id profile",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer",
     *             default="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="successful"),
     *                 @OA\Property(property="message", type="string", default="", description="is custom message"),
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
     * @param int id
     *
     * @return JsonResponse
     */
    public function activate(int $id)
    {
        try {
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$profile = Auth::guard('api')->user()->profiles()->where('id', (int)$request->input('profile_id'))->first();
            $profile = (new UserInfo())->getModel()->profiles()->where('id', $id)->first();
            if (!$profile) {
                throw new ErrorException('Профиль не найден');
            }
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$collections = Auth::guard('api')->user()->profiles();
            $collections = (new UserInfo())->getModel()->profiles()->getResults();
            if ($collections->count() > 0) {
                /** @var Profile $prof */
                foreach ($collections as $prof) {
                    $prof->setAttribute('active', 'N');
                    $prof->save();
                }
            }
            $profile->setAttribute('active', 'Y');
            $isSuccess = $profile->save();
            if (!$isSuccess) {
                throw new ErrorException('Ошибка активации профиля');
            }
            return response()->json([
                'status' => 'successful',
                'message' => 'Профиль успешно активирован',
            ]);
        } catch (Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/add_profile",
     *     operationId="createUserProfile",
     *     tags={"Profile"},
     *     summary="create user profile",
     *     @OA\Parameter(
     *         description="custom name profile",
     *         in="query",
     *         name="name",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="custom number auto",
     *         in="query",
     *         name="address",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id types profile",
     *         in="query",
     *         name="type",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer",
     *             default="1"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id brands types",
     *         in="query",
     *         name="brand",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer",
     *             default="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="message", type="string", default="", description="is custom message"),
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
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $requests = $request->all();
            $rules = [
                'name' => 'required|min:3|max:255',
                'address' => 'required|min:9|max:15', //fix field name to auto number
                'type' => 'required|numeric|exists:' . ProfilesService::class . ',id',
                'brand' => 'required|numeric|exists:' . Brands::class . ',id',
            ];
            $message = [
                'required' => 'Поле :attribute обязательно для заполнения',
                'min' => 'Поле :attribute содержать мин :min символа',
                'max' => 'Длина :attribute не может превышать :max символов',
                'numeric' => 'Должно быть числом',
                'exists' => 'Указанное :attribute значение не найдено в справочнике',
            ];
            $validator = Validator::make($requests, $rules, $message);
            if ($validator->fails()) {
                throw new ErrorException($validator->messages());
            }
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$profile = Auth::guard('api')->user()->profiles();
            $profile = (new UserInfo())->getModel()->profiles();
            $profile->create([
                'name' => $requests['name'],
                'address' => $requests['address'],
                'type' => $requests['type'],
                'brand' => $requests['brand'],
                'active' => 'N',
            ]);
            return response()->json([
                'status' => 'successful',
                'message' => 'Профиль добавлен'
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
     *     path="/show_profile/{id}",
     *     operationId="getShowProfile",
     *     tags={"Profile"},
     *     summary="Returns fields user profile by id",
     *     @OA\Parameter(
     *         description="id user profile",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer",
     *             minimum="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\JsonContent(ref="#/components/schemas/Profile")
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
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            /** @var Profile $profile */
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$profile = Auth::guard('api')->user()->profiles()->where('id', $id)->first();
            $profile = (new UserInfo())->getModel()->profiles()->where('id', $id)->first();
            if (!$profile) {
                throw new ErrorException('Ошибка получения профиля');
            }
            return response()->json($profile);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Put(
     *     path="/edit_profile/{id}",
     *     operationId="updateProfile",
     *     tags={"Profile"},
     *     summary="Update data profile",
     *     @OA\Parameter(
     *         description="id user profile",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer",
     *             default="1",
     *             minimum="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="successful"),
     *                 @OA\Property(property="message", type="string", default="", description="is custom message"),
     *             ),
     *         ),
     *     ),
     *     @OA\RequestBody(
     *         description="Profile to add to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="type", format="int64", type="integer", example="1", description="id entity of type profile"),
     *                 @OA\Property(property="brand", format="int64", type="integer", example="1", description="id entity of brands type"),
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
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id, Request $request)
    {
        try {
            if ((int)$id > 0) {
                /** @var Profile $profile */
                /** @TODO вернуть проверку авторизации пользователя после фикса */
                //$profile = Auth::guard('api')->user()->profiles()->where('id', $id)->first();
                $profile = (new UserInfo())->getModel()->profiles()->where('id', $id)->first();
                if (!$profile) {
                    throw new ErrorException('Ошибка редактирования профиля');
                }
                $isUpdate = false;
                if ($request->input('name')) {
                    $profile->setAttribute('name', trim($request->input('name')));
                    $isUpdate = true;
                }
                if ($request->input('address')) {
                    $profile->setAttribute('address', trim($request->input('address')));
                    $isUpdate = true;
                }
                if ($request->input('type')) {
                    $profile->setAttribute('type', trim($request->input('type')));
                    $isUpdate = true;
                }
                if ($request->input('brand')) {
                    $profile->setAttribute('brand', trim($request->input('brand')));
                    $isUpdate = true;
                }
                $profile->setAttribute('active', $profile->getAttributeValue('active'));
                if ($isUpdate) {
                    $profile->save();
                }
            }
            return response()->json([
                'status' => 'successful',
                'message' => 'Профиль успешно изменён'
            ]);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Delete(
     *     path="/delete_profile/{id}",
     *     operationId="deleteProfile",
     *     tags={"Profile"},
     *     summary="Remove user profile by id",
     *     @OA\Parameter(
     *         description="id user profile",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer",
     *             default="1",
     *             minimum="1",
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="successful"),
     *                 @OA\Property(property="message", type="string", default="", description="is custom message"),
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
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            if ((int)$id <= 0) {
                throw new ErrorException('Не корректный запрос');
            }
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$userId = Auth::guard('api')->user()->id;
            $profile = (new UserInfo())->getModel()->profiles()->where('id', $id)->first();
            if (!$profile) {
                throw new ErrorException('Профиль не найден');
            }
            $profile->delete();
            return response()->json([
                'status' => 'successful',
                'message' => 'Профиль удалён'
            ]);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
