<?php

namespace App\Http\Controllers;

use App\Classes\Entity\User\UserInfo;
use App\Classes\Helpers\ModelHelper;
use App\Model\Entity;
use App\Model\EntityPayment;
use App\Model\EntityService;
use App\Model\Payment;
use App\Model\ProfilesService;
use App\Model\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServicesController extends Controller
{
    public function index()
    {
        $result = [
            'selected' => [
                'services' => [],
                'profiles' => [],
                'payments' => [],
            ]
        ];
        try {
            $user = new UserInfo();
            if (!$user->roles()->isCarwashUser()) {
                return abort(Response::HTTP_NOT_FOUND);
            }
            /** @var Entity $entity */
            $entity = $user->getModel()->pointCarwash()->firstOrFail(['id']);
            if ($entity) {
                $entityId = (int)$entity->getAttributeValue('id');
                ModelHelper::getReferenceList(Payment::class, $result['payments']);
                ModelHelper::getReferenceList(Service::class, $result['services']);
                ModelHelper::getReferenceList(ProfilesService::class, $result['profiles_service']);
                $servicesRelated = $entity->servicesRelated()->get();
                if ($servicesRelated->count() > 0) {
                    $result['related']['services'] = $servicesRelated->toArray();
                    if (!empty($result['related']['services'])) {
                        $temp = array_column($result['related']['services'], 'service_id');
                        if (!empty($temp)) {
                            $result['selected']['services'] = array_unique($temp);
                        }
                        $temp = array_column($result['related']['services'], 'profile_id');
                        if (!empty($temp)) {
                            $result['selected']['profiles'] = array_unique($temp);
                        }
                    }
                }
                $paymentsRelated = $entity->paymentsRelated()->get();
                if ($paymentsRelated->count() > 0) {
                    $result['related']['payments'] = $paymentsRelated->toArray();
                    if (!empty($result['related']['payments'])) {
                        $temp = array_column($result['related']['payments'], 'payment_id');
                        if (!empty($temp)) {
                            $result['selected']['payments'] = array_unique($temp);
                        }
                    }
                }

            }
        } catch (Error|QueryException $e) {
            return redirect()->route('services.index')->withErrors($e->getMessage())->withInput();
        }
        return view('template.services.index', compact('result'));
    }

    public function edit(Request $request)
    {
        $reqPayments = $request->input('payments') ?? [];
        $reqProfiles = $request->input('profiles_service') ?? [];
        $reqServices = $request->input('services') ?? [];

        $matrixServices = $matrixServicesClone = [];
        $updateServices = $deleteServices = [];
        if (!empty($reqProfiles)) {
            foreach ($reqServices as $serviceId) {
                foreach ($reqProfiles as $profileId) {
                    $matrixServices[] = [
                        'profile' => $profileId,
                        'service' => $serviceId,
                    ];
                }
            }
        }
        if (!empty($matrixServices)) {
            $matrixServicesClone = $matrixServices;
        }
        try {
            $user = new UserInfo();
            if (!$user->roles()->isCarwashUser()) {
                return abort(Response::HTTP_NOT_FOUND);
            }
            $entity = $user->getModel()->pointCarwash()->firstOrFail(['id']);
            if ($entity) {
                $entityId = (int)$entity->getAttributeValue('id');

                /** @var Collection $payments */
                $payments = $entity->paymentsRelated()->get();
                if ($payments) {
                    /** @var EntityPayment $payment */
                    foreach ($payments as $payment) {
                        $paymentId = $payment->getAttribute('payment_id');
                        if (!in_array($paymentId, $reqPayments)) {
                            $payment->delete();
                        }
                        $key = array_search($paymentId, $reqPayments);
                        if (false !== $key) {
                            unset($reqPayments[$key]);
                        }
                    }
                }
                if (!empty($reqPayments)) {
                    foreach ($reqPayments as $idPayment) {
                        (new EntityPayment([
                            'entity_id' => $entityId,
                            'payment_id' => $idPayment
                        ]))->save();
                    }
                }

                $services = $entity->servicesRelated()->get();
                if ($services) {
                    /** @var EntityService $service */
                    foreach ($services as $service) {
                        $profileId = $service->getAttribute('profile_id');
                        $serviceId = $service->getAttribute('service_id');

                        $findKey = false;
                        foreach ($matrixServicesClone as $key => $item) {
                            if ((int)$item['profile'] === (int)$profileId && (int)$item['service'] === (int)$serviceId) {
                                $findKey = $key;
                                unset($matrixServices[$key]);
                                break;
                            }
                        }
                        if ($findKey !== false) {
                            $updateServices[] = $service;
                        } else {
                            $deleteServices[] = $service;
                        }
                    }
                    if (!empty($deleteServices)) {
                        /** @var EntityService $service */
                        foreach ($deleteServices as $service) {
                            $service->delete();
                        }
                    }
                    if (!empty($matrixServices)) {
                        foreach ($matrixServices as $matrixService) {
                            (new EntityService([
                                'entity_id' => $entityId,
                                'profile_id' => $matrixService['profile'],
                                'service_id' => $matrixService['service'],
                                'cost' => null,
                            ]))->save();
                        }
                    }
                }
            }
        } catch (Error|QueryException $e) {
            return redirect()->route('services.index')->withErrors($e->getMessage())->withInput();
        }
        return back();
    }

    public function updatePrice(Request $request)
    {
        if ($request->input('id') && $request->input('cost')) {
            $user = new UserInfo();
            if ($user->roles()->isCarwashUser()) {
                $entity = $user->getModel()->pointCarwash()->firstOrFail(['id']);
                if ($entity) {
                    $entityId = (int)$entity->getAttributeValue('id');
                    EntityService::where('id', $request->input('id'))
                        ->where('entity_id', $entityId)
                        ->update(['cost' => (int)$request->input('cost')]);
                }
            }
        }
    }
}
