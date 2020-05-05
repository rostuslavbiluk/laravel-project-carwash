<?php

namespace App\Http\Controllers;

use App\Classes\Entity\User\UserInfo;
use App\Model\Entity;
use App\Model\EntityService;
use App\Model\Order;
use App\Model\Payment;
use App\Model\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {

        $arResult = [];

        /*$entities = DB::table('entities')
            ->join('entity_services', 'entity_services.entity_id', '=', 'entities.id')
            ->join('service_lists', 'service_lists.id', '=', 'entity_services.service_id')
            ->select(
                'entities.*',
                'service_lists.*',
                'entity_services.cost as cost',
                'entities.id as entity_id',
                'service_lists.id as service_id'
                )
            ->where('entities.id','=',1)
            ->get();*/

        $objOrders = Order::where('user_id', 21);

        $arItemsOrders = $objOrders->where('profile_id', '=', 2)
            ->where('status', '=', 2)
            ->get()
            ->toArray();

        if (!empty($arItemsOrders)) {

            foreach ($arItemsOrders as $items) {

                if (isset($items['services_id'])) {

                    $arJson = json_decode($items['services_id']);
                    if (is_array($arJson) && !empty($arJson)) {

                        foreach ($arJson as $value) {
                            if ((int)$value > 0) {
                                $arIdServices[(int)$value] = (int)$value;
                            }
                        }
                    }
                }

                if (isset($items['payment_id'])) {
                    if ((int)$items['payment_id'] > 0) {

                        $arIdPayment[(int)$items['payment_id']] = (int)$items['payment_id'];
                    }
                }

                if (isset($items['entity_id'])) {
                    if ((int)$items['entity_id'] > 0) {

                        $arIdEntity[(int)$items['entity_id']] = (int)$items['entity_id'];
                    }
                }
            }

            if (!empty($arIdServices)) {

                $arServices = Service::whereIn('id', $arIdServices)->get();
                if (!empty($arServices)) {
                    foreach ($arServices as $service) {

                        $arResult['service'][$service->id] = array(
                            'name' => $service->name
                        );
                    }
                }
            }

            if (!empty($arIdPayment)) {

                $arPayments = Payment::whereIn('id', $arIdPayment)->get();
                if (!empty($arPayments)) {
                    foreach ($arPayments as $payment) {

                        $arResult['payments'][$payment->id] = array(
                            'name' => $payment->name
                        );
                    }
                }
            }

            if (!empty($arIdEntity)) {

                $arEntities = Entity::whereIn('id', $arIdEntity)->get();
                if (!empty($arEntities)) {
                    foreach ($arEntities as $entity) {

                        $arResult['entity'][$entity->id] = array(
                            'name' => $entity->name
                        );
                    }
                }
            }


            foreach ($arItemsOrders as $items) {

                $arItems = [];
                $arItems['name'] = 'Номер заказа ' . $items;
                $arItems['cost'] = 'Заказ на сумму: ' . number_format($items['cost'], 0, '', ' ') . 'р.';

                if (isset($arResult['entity'][$items['entity_id']])) {
                    $arItems['entity'] = $arResult['entity'][$items['entity_id']]['name'];
                }

                if (isset($arResult['payments'][$items['payment_id']])) {
                    $arItems['payment'] = $arResult['payments'][$items['payment_id']]['name'];
                }

                if (isset($items['services_id'])) {

                    $arJson = json_decode($items['services_id']);
                    if (is_array($arJson) && !empty($arJson)) {

                        $textService = '';
                        foreach ($arJson as $value) {
                            if ((int)$value > 0) {

                                if (isset($arResult['service'][$value])) {
                                    $textService .= $arResult['service'][$value]['name'] . '</br>';
                                }
                            }
                        }

                        $arItems['service'] = $textService;
                    }
                }

                $arItems['comment'] = $items['comment'];
                $arItems['time'] = ['created_at'];

                $arOrders[] = $arItems;
            }
            //unset($items);

            return response()->json([
                'status' => 'successful',
                'message' => 'Список заказов',
                'items' => $arOrders,
            ]);

        } else {

            return response()->json([
                'status' => 'successful',
                'message' => 'Список заков пуст',
                'items' => [],
            ]);
        }

        //dd($arItemsOrders);

        //return '<pre>' . print_r($objItemsOrders, 1) . '</pre>';
    }

    public function setStatusOrder(Request $request)
    {
        $responce = 'N';
        if ($request->input('order_id')) {
            $user = new UserInfo();
            if ($user->roles()->isCarwashUser()) {
                $order = Order::where('id', $request->input('order_id'))->first();
                if ($order) {
                    $order->status = $request->input('value');
                    $order->save();
                }
                $responce = 'Y';
            }
        }
        return $responce;
    }

    public function setStatusEntity(Request $request)
    {
        $responce = 'N';
        if ((int)$request->input('entity_id') > 0) {
            if (!empty($request->input('status'))) {
                $user = new UserInfo();
                if ($user->roles()->isCarwashUser()) {
                    $entity = $user->getModel()->pointCarwash()->firstOrFail(['id']);
                    if ($entity) {
                        $entityId = (int)$entity->getAttributeValue('id');
                        if ($entityId === (int)$request->input('entity_id')) {
                            $entityModel = Entity::where('id', $request->input('entity_id'))->first();
                            if ($entityModel) {
                                $entityModel->status = $request->input('status');
                                $entityModel->save();
                                $responce = 'Y';
                            }
                        }
                    }
                }
            }
        }
        return $responce;
    }
}
