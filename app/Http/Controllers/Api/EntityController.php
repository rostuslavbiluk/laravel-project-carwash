<?php

namespace App\Http\Controllers\Api;

use App\Classes\Entity\User\UserInfo;
use App\Classes\Enum\StatusEntityEnum;
use App\Classes\Helpers\Phone;
use App\Http\Controllers\Controller;
use App\Model\Entity;
use App\Model\EntityBox;
use App\Model\EntityPayment;
use App\Model\EntityService;
use App\Model\EntityType;
use App\Model\Payment;
use App\Model\Profile;
use App\Model\Service;
use App\Model\ServiceCategory;
use Illuminate\Http\Request;
use ErrorException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Entity",
 *     description="Request return",
 * )
 *
 * Class EntityController
 * @package App\Http\Controllers\Api
 */
class EntityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/get_entity",
     *     operationId="getEntity",
     *     tags={"Entity"},
     *     summary="Returns list of Entities",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\JsonContent(ref="#/components/schemas/Entity")
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $status = StatusEntityEnum::TYPE;
            /** @var Profile $profile */
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$profile = Auth::guard('api')->user()->profiles()->where('active', 'Y')->first();
            $profile = (new UserInfo())->getModel()->profiles()->where('active', 'Y')->first();
            if (!$profile) {
                throw new ErrorException('Установите пожалуйста активность одного из профиля');
            }
            $typeProfile = (int)$profile->getAttributeValue('type');
            if ($typeProfile <= 0) {
                throw new ErrorException('Установите пожалуйста активность одного из профиля');
            }
            $entityServiceCollections = EntityService::get()->whereIn('profile_id', $typeProfile);
            if ($entityServiceCollections->count() > 0) {
                $servicesByProfile = $entityServiceCollections->toArray();

                $idEntities = array_column($servicesByProfile, 'entity_id');
                $idServices = array_column($servicesByProfile, 'service_id');

                if (!empty($idEntities)) {
                    $idEntities = array_unique($idEntities);
                    $entitieCollections = Entity::whereIn('id', $idEntities)
                        ->where('active', 'Y')
                        ->get();
                    if ($entitieCollections->count() > 0) {
                        $entities = $entitieCollections->toArray();
                        $entityTypeId = array_column($entities, 'type_entity');
                        if (!empty($entityTypeId)) {
                            $entityTypeId = array_unique($entityTypeId);
                            $collectionTypes = EntityType::whereIn('id', $entityTypeId)
                                ->where('active', 'Y')
                                ->get(['id', 'name', 'code']);
                            if ($collectionTypes->count() > 0) {
                                $entityTypes = $collectionTypes->toArray();
                            }
                        }
                    }
                    $entityPaymentCollections = EntityPayment::whereIn('entity_id', $idEntities)->get();
                    if ($entityPaymentCollections->count() > 0) {
                        $entityPayments = $entityPaymentCollections->toArray();
                    }
                    $entityBoxCollections = EntityBox::whereIn('entity_id', $idEntities)->get();
                    if ($entityBoxCollections->count() > 0) {
                        $entityBoxes = $entityBoxCollections->toArray();
                    }
                }
                if (!empty($idServices)) {
                    $idServices = array_unique($idServices);
                    $serviceCollections = Service::whereIn('id', $idServices)
                        ->where('active', 'Y')
                        ->get();
                    if ($serviceCollections->count() > 0) {
                        $services = $serviceCollections->toArray();
                        $serviceCategories = array_column($services, 'category_id');
                        if (!empty($serviceCategories)) {
                            $serviceCategories = array_unique($serviceCategories);
                            $serviceCategoryCollections = ServiceCategory::whereIn('id', $serviceCategories)
                                ->where('active', 'Y')
                                ->get();
                            if ($serviceCategoryCollections->count() > 0) {
                                $categories = $serviceCategoryCollections->toArray();
                            }
                        }
                    }
                }
                $paymentCollections = Payment::get()->where('active', 'Y');
                if ($paymentCollections->count() > 0) {
                    $payments = $paymentCollections->toArray();
                }

                if (!empty($entities)) {
                    $tempTypes = [];
                    foreach ($entities as $entity) {
                        $tempServices = $tempPayments = $tempCategory = $tempBoxes = [];
                        $idEntity = $entity['id'];
                        $idType = $entity['type_entity'];
                        $type = $tempTypes[$idType] ?? false;
                        if (!$type) {
                            $findItem = array_filter($entityTypes, function ($item, $key) use ($idType) {
                                return (int)$item['id'] === (int)$idType;
                            }, ARRAY_FILTER_USE_BOTH);
                            if (!empty($findItem)) {
                                $type = $tempTypes[$idType] = array_shift($findItem)['code'];
                            }
                        }
                        if (is_array($services) && !empty($services)) {
                            $findItem = array_filter($servicesByProfile, function ($item, $key) use ($idEntity) {
                                return (int)$item['entity_id'] === (int)$idEntity;
                            }, ARRAY_FILTER_USE_BOTH);
                            if (!empty($findItem)) {
                                $idServices = array_column($findItem, 'service_id');
                                if (!empty($idServices)) {
                                    foreach ($services as $service) {
                                        if (in_array($service['id'], $idServices, true)) {
                                            $tempServices[] = $service;
                                        }
                                    }
                                }
                            }
                        }
                        if (!empty($tempServices)) {
                            $idCategories = array_column($tempServices, 'category_id');
                            if (!empty($idCategories)) {
                                foreach ($categories as $category) {
                                    if (in_array($category['id'], $idCategories)) {
                                        $tempCategory[] = $category;
                                    }
                                }
                            }
                        }
                        if (is_array($entityPayments) && !empty($entityPayments)) {
                            $findItem = array_filter($entityPayments, function ($item, $key) use ($idEntity) {
                                return (int)$item['entity_id'] === (int)$idEntity;
                            }, ARRAY_FILTER_USE_BOTH);
                            if (!empty($findItem)) {
                                $idPayments = array_column($findItem, 'payment_id');
                                if (!empty($idPayments)) {
                                    foreach ($payments as $payment) {
                                        if (in_array($payment['id'], $idPayments, true)) {
                                            $tempPayments[] = $payment;
                                        }
                                    }
                                }
                            }
                        }
                        if ($type === 'selfservice') {
                            if (!empty($entityBoxes)) {
                                $findItem = array_filter($entityBoxes, function ($item, $key) use ($idEntity) {
                                    return (int)$item['entity_id'] === (int)$idEntity;
                                }, ARRAY_FILTER_USE_BOTH);
                                if (!empty($findItem)) {
                                    foreach ($findItem as $item) {
                                        if (isset($status[$item['status']])) {
                                            $item['status'] = $status[$item['status']];
                                        }
                                        $tempBoxes[] = $item;
                                    }
                                }
                            }
                        }

                        $result[] = [
                            'id' => $entity['id'],
                            'name' => $entity['name'],
                            'code' => $entity['code'],
                            'active' => $entity['active'],
                            'preview_text' => $entity['preview_text'],
                            'preview_picture' => $entity['preview_picture'],
                            'phone' => Phone::getFormatted($entity['phone']),
                            'location' => $entity['location'],
                            'status' => $status[$entity['status']] ?? '',
                            'type_entity' => $type,
                            'services' => $tempServices,
                            'boxes' => $tempBoxes,
                            'category' => $tempCategory,
                            'payments' => $tempPayments,
                        ];
                    }
                }
            }
            return response()->json([
                'status' => 'successful',
                'message' => '',
                'items' => $result ?? [],
                'status' => array_values($status),
                'category' => $categories ?? [],
            ]);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
