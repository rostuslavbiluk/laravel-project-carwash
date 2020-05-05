<?php

namespace App\Classes\Entity\Profile\Carwash;

use App\Classes\Entity\User\UserInfo;
use App\Classes\Enum\StatusOrderEnum;
use App\Order;
use App\PaymentOption;
use App\ServiceList;
use App\User;
use App\Entity;
use App\Profile;
use App\ProfilesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class IndexPage
 * @package App\Classes\Entity\Profile\Carwash
 */
class IndexPage
{

    public static function index()
    {
        $currentUser = Auth::user();
        $returnResult = [
            'SHOW_BLOCK_ENTITY' => 'Y',
            'ENTITY' => false,

            'SHOW_BLOCK_NEW_ORDERS' => 'Y',
            'NEW_ORDERS' => [],

            'SHOW_BLOCK_COMPLETE_ORDERS' => 'Y',
            'COMPLETE_ORDERS' => [],

            'SHOW_BLOCK_STATISTICS' => 'N',
            'STATISTICS' => [],
        ];

        $activeEntity = Entity::where('user_id', (int)$currentUser->id)->first();
        if ($activeEntity) {
            $activeEntity = $activeEntity->toArray();
            $returnResult['ENTITY'] = $activeEntity;

            if (isset($returnResult['ENTITY']['id'])) {

                $orders = Order::where('entity_id', $activeEntity['id'])->get();
                $orderList = $orders->whereIn('status', array_keys(StatusOrderEnum::TYPE));

                foreach ($orderList as $order) {
                    if ((int)$order->status === 0) {
                        $returnResult['NEW_ORDERS'][$order->id] = $order->toArray();
                    }
                    if ((int)$order->status !== 0) {
                        $returnResult['COMPLETE_ORDERS'][$order->id] = $order->toArray();
                    }
                    if ((int)$order->user_id > 0) {
                        $idUsers[] = (int)$order->user_id;
                    }
                    if ((int)$order->payment_id > 0) {
                        $idPayments[] = (int)$order->payment_id;
                    }
                    if ((int)$order->profile_id > 0) {
                        $idProfiles[] = $order->profile_id;
                    }
                    foreach (json_decode($order->services_id) as $value) {
                        $idServices[$value] = $value;
                    }
                }

                $idUsers = ($idUsers) ? array_unique($idUsers) : [];
                $idPayments = ($idPayments) ? array_unique($idPayments) : [];
                $idProfiles = ($idProfiles) ? array_unique($idProfiles) : [];

                if (!empty($idUsers)) {
                    $userList = User::whereIn('id', $idUsers)->get();
                    if (!empty($userList)) {
                        foreach ($userList as $user) {
                            $userInfo = new UserInfo($user);
                            $returnResult['USERS'][$user->id] = $userInfo->getInfoFormatted();
                        }
                    }
                }

                if (!empty($idPayments)) {
                    $paymentList = PaymentOption::whereIn('id', $idPayments)->get();
                    if (!empty($paymentList)) {
                        foreach ($paymentList as $payment) {
                            $returnResult['PAYMENTS'][$payment->id] = [
                                'PAYMENT' => $payment->name
                            ];
                        }
                    }
                }

                if (!empty($idServices)) {
                    $servicesList = ServiceList::whereIn('id', $idServices)->get();
                    if (!empty($servicesList)) {
                        foreach ($servicesList as $service) {
                            $returnResult['SERVICES'][$service->id] = array(
                                'SERVICE' => $service->name
                            );
                        }
                    }
                }

                if (!empty($idProfiles)) {
                    $profilesList = Profile::whereIn('id', $idProfiles)->get();
                    if (!empty($profilesList)) {

                        foreach ($profilesList as $profile) {
                            $idBrands[] = $profile->brand;
                            $idTypes[] = $profile->type;
                        }

                        $brandsInfo = [];
                        if (!empty($idBrands)) {
                            $brandList = \App\Brands::whereIn('id', $idBrands)->get();
                            if (!empty($brandList)) {
                                foreach ($brandList as $brand) {
                                    $brandsInfo[$brand->id] = [
                                        'name' => $brand->name,
                                    ];
                                }
                            }
                        }
                        $typesInfo = [];
                        if (!empty($idTypes)) {
                            $typeList = ProfilesService::whereIn('id', $idTypes)->get();
                            if (!empty($typeList)) {
                                foreach ($typeList as $type) {
                                    $typesInfo[$type->id] = [
                                        'name' => $type->name,
                                    ];
                                }
                            }
                        }

                        foreach ($profilesList as $profile) {
                            $returnResult['PROFILES'][$profile->id] = [
                                //'SERVICE' => $profile->name,
                                'TYPE' => '',
                                'BRAND' => '',
                                'NUMBER' => $profile->address,
                            ];
                            if (isset($typesInfo[$profile->type])) {
                                $returnResult['PROFILES'][$profile->id]['TYPE'] = $typesInfo[$profile->type]['name'];
                            }
                            if (isset($brandsInfo[$profile->brand])) {
                                $returnResult['PROFILES'][$profile->id]['BRAND'] = $brandsInfo[$profile->brand]['name'];
                            }
                        }
                    }
                }

            }
        }
        return $returnResult;
    }
}