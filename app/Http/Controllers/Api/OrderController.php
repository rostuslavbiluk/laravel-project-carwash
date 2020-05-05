<?php

namespace App\Http\Controllers\Api;

use App\Classes\Entity\User\UserInfo;
use App\Classes\Enum\StatusOrderEnum;
use App\Http\Controllers\Controller;
use App\Model\Entity;
use App\Model\EntityService;
use App\Model\Order;
use App\Model\Payment;
use App\Model\Service;
use App\Model\User;
use App\Notifications\NotifyOrder;
use Illuminate\Http\Request;
use ErrorException;
use Exception;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Order",
 *     description="Request return",
 * )
 *
 * Class OrderController
 * @package App\Http\Controllers\Api
 */
class OrderController extends Controller
{
    /**
     * @OA\Post(
     *     path="/user_make_order",
     *     operationId="createOrder",
     *     tags={"Order"},
     *     summary="Params for create order",
     *     @OA\Parameter(
     *         description="id object carwash",
     *         in="query",
     *         name="object",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer",
     *             default="1"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id payments",
     *         in="query",
     *         name="payment",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer",
     *             default="1"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="array ids services",
     *         in="query",
     *         name="services",
     *         required=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="string",
     *                 enum={"3", "4", "5"},
     *                 default="3"
     *             ),
     *         ),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="success", description=""),
     *                 @OA\Property(property="status_connect", type="string", default="pending", description=""),
     *                 @OA\Property(property="process", type="string", default="init", description=""),
     *                 @OA\Property(property="next_step", type="string", default="ping", description="for control send next step"),
     *                 @OA\Property(property="message", type="string", default="", description=""),
     *                 @OA\Property(property="order", format="int64", type="integer", description="new id order"),
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
    public function store(Request $request)
    {
        try {
            $cost = 0;
            /** @var Profile $profile */
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$profile = Auth::guard('api')->user()->profiles()->where('active', 'Y')->first();
            $profile = (new UserInfo())->getModel()->profiles()->where('active', 'Y')->first();
            if (!$profile) {
                throw new ErrorException('Ошибка оформления заказа, установите активный профиль');
            }
            $typeProfile = (int)$profile->getAttributeValue('type');
            $virtualSum = (int)$profile->getAttributeValue('cost');
            $userId = (int)$profile->getAttributeValue('user_id');
            $requests = $request->all();
            $rules = [
                'object' => 'required|numeric|exists:' . Entity::class . ',id',
            ];
            $validator = Validator::make($requests, $rules);
            if ($validator->fails()) {
                throw new ErrorException($validator->messages());
            }
            $payment = Payment::where('id', (int)$requests['payment'])->first();
            if ($payment->count() <= 0 || !$payment->isActive()) {
                throw new ErrorException('Варинат оплаты не найден, пожалуйста повторите оформление заказа');
            }
            $serviceCollections = EntityService::where('entity_id', (int)$requests['object'])
                ->where('profile_id', $typeProfile)
                ->whereIn('service_id', $requests['services'])
                ->get();
            if ($serviceCollections->count() < count($requests['services'])) {
                throw new ErrorException('Выбранные услуги не найдены, пожалуйста повторите оформление заказа');
            }
            $services = $serviceCollections->toArray();
            foreach ($services as $service) {
                $cost += round($service['cost'], 0, PHP_ROUND_HALF_UP);
            }
            if (round($virtualSum) === 0) {
                throw new ErrorException('Извините ваш баланс пуст');
            }
            if ($cost > round($virtualSum)) {
                throw new ErrorException('На балансе достаточно денег, выберите другие услуги');
            }
            $params = [
                'user_id' => $userId,
                'profile_id' => $typeProfile,
                'entity_id' => (int)$requests['object'],
                'payment_id' => (int)$requests['payment'],
                'services_id' => json_encode($requests['services']),
                'cost' => $cost,
                'status' => StatusOrderEnum::TYPE['NEW']['id'],
                'comment' => '',
                'params' => json_encode([])
            ];
            $newOrder = Order::create($params);
            if ((int)$newOrder->getAttribute('id') <= 0) {
                throw new ErrorException('Ошибка создания заказа, пожалуйста повторите оформление заказа');
            }
            /** @TODO вунести в отдельный метод обновление остатка на счету по профилю пользователя */
            if ($payment->isPaymentBill()) {
                $balance = (float)round((int)round($virtualSum) - (int)$cost);
                if ($balance < 0) {
                    $balance = 0;
                }
                $profile->setAttribute('cost', $balance);
                $profile->save();
            }

            /** @TODO перенести отправку уведоилений на событие создание заказа */
            /*$entity = Entity::where('id', $requests['object'])->first();
            if ((int)$entity->getAttribute('user_id') > 0) {
                $user = User::where('id', $entity->getAttribute('user_id'))->first();
                if ($user) {
                    Notification::send($user, new NotifyOrder($newOrder));
                }
            }*/

            return response()->json([
                'status' => 'successful',
                'status_connect' => 'pending',
                'process' => 'init',
                'next_step' => 'ping',
                'message' => '',
                'order' => $newOrder->getAttribute('id'),
            ]);
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @OA\Get(
     *     path="/get_order_history",
     *     operationId="getOrders",
     *     tags={"Order"},
     *     summary="Returns list user orders",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="successful", description=""),
     *                 @OA\Property(property="message", type="string", default="", description="is message - Список заказов||Список заказов пуст"),
     *                 @OA\Property(property="items", type="array", description="new id order",
     *                     @OA\Items(ref="#/components/schemas/Order")
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
     * @return JsonResponse
     */
    public function history()
    {
        try {
            /** @var Profile $profile */
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$profile = Auth::guard('api')->user()->profiles()->where('active', 'Y')->first();
            $profile = (new UserInfo())->getModel()->profiles()->where('active', 'Y')->first();
            if (!$profile) {
                throw new ErrorException('Ошибка получения информации по заказам');
            }
            $orderCollections = Order::where('user_id', $profile->getAttribute('user_id'))
                ->where('profile_id', '=', $profile->getAttribute('type'))
                ->where('status', '=', StatusOrderEnum::TYPE['FINISHED']['id'])
                ->get();
            if ($orderCollections->count() > 0) {
                $orders = $orderCollections->toArray();
                if (!empty($orders)) {
                    $payments = $entity = $services = [];
                    foreach ($orders as $order) {
                        if (isset($order['services_id'])) {
                            $json = json_decode($order['services_id']);
                            if (is_array($json) && !empty($json)) {
                                foreach ($json as $id) {
                                    if ((int)$id > 0) {
                                        $services[] = (int)$id;
                                    }
                                }
                            }
                        }
                        if ((int)$order['payment_id'] > 0) {
                            $payments[] = (int)$order['payment_id'];
                        }
                        if ((int)$order['entity_id'] > 0) {
                            $entity[] = (int)$order['entity_id'];
                        }
                    }
                    if (!empty($services)) {
                        $services = array_unique($services);
                        $serviceCollections = Service::whereIn('id', $services)
                            ->get(['id', 'name']);
                        if ($serviceCollections->count() > 0) {
                            $services = $serviceCollections->toArray();
                        }
                    }
                    if (!empty($payments)) {
                        $payments = array_unique($payments);
                        $entityPaymentCollections = Payment::whereIn('id', $payments)
                            ->get(['id', 'name']);
                        if ($entityPaymentCollections->count() > 0) {
                            $entityPayments = $entityPaymentCollections->toArray();
                        }
                    }
                    if (!empty($entity)) {
                        $entity = array_unique($entity);
                        $entityCollections = Entity::whereIn('id', $entity)
                            ->get(['id', 'name']);
                        if ($entityCollections->count() > 0) {
                            $entities = $entityCollections->toArray();
                        }
                    }
                    foreach ($orders as $order) {
                        $idEntity = $order['entity_id'];
                        $idPayment = $order['payment_id'];
                        $item = [];
                        $item['name'] = 'Номер заказа ' . $order['id'];
                        $item['cost'] = 'Заказ на сумму: ' . number_format($order['cost'], 0, '', ' ') . ' р.';
                        $item['entity'] = '';
                        $findItem = array_filter($entities, function ($item, $key) use ($idEntity) {
                            return (int)$item['id'] === (int)$idEntity;
                        }, ARRAY_FILTER_USE_BOTH);
                        if (!empty($findItem)) {
                            $item['entity'] .= array_shift($findItem)['name'];
                        }
                        $item['payments'] = 'Тип оплаты: ';
                        $findItem = array_filter($entityPayments, function ($item, $key) use ($idPayment) {
                            return (int)$item['id'] === (int)$idPayment;
                        }, ARRAY_FILTER_USE_BOTH);
                        if (!empty($findItem)) {
                            $item['payments'] .= array_shift($findItem)['name'];
                        }
                        $item['service'] = 'Список оказанных услуг: ';
                        if (!empty($order['services_id'])) {
                            $idServices = json_decode($order['services_id']);
                            if (is_array($idServices) && !empty($idServices)) {
                                foreach ($idServices as $value) {
                                    if ((int)$value > 0) {
                                        $findItem = array_filter($services, function ($item, $key) use ($value) {
                                            return (int)$item['id'] === (int)$value;
                                        }, ARRAY_FILTER_USE_BOTH);
                                        if (!empty($findItem)) {
                                            $item['service'] .= '<br/>' . array_shift($findItem)['name'];
                                        }
                                    }
                                }
                            }
                        }
                        $item['comment'] = 'Комментарий: ' . $order['comment'];
                        $item['time'] = date('d-m-Y', strtotime($order['created_at']));
                        $result[] = $item;
                    }
                }
            }
            return response()->json([
                'status' => 'successful',
                'message' => (!empty($result)) ? 'Список заказов' : 'Список заказов пуст',
                'items' => $result ?? [],
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
     *     path="/get_order_status",
     *     operationId="getOrderSatatus",
     *     tags={"Order"},
     *     summary="Returns list next type status send ",
     *     @OA\Parameter(
     *         description="id order",
     *         in="query",
     *         name="order",
     *         required=true,
     *         @OA\Schema(
     *             format="int64",
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="type process steps",
     *         in="query",
     *         name="process",
     *         required=true,
     *         @OA\Schema(
     *           type="array",
     *           @OA\Items(
     *               type="string",
     *               enum={"ping", "ordercreate", "accept", "сompleted", "finish"},
     *               default="ping"
     *           ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="status", type="string", default="success", description=""),
     *                 @OA\Property(property="status_connect", type="string", default="pending", description="is value success|pending"),
     *                 @OA\Property(property="process", type="string", default="init", description="is value finish|ping|ordercreate|accept|сompleted"),
     *                 @OA\Property(property="next_step", type="string", default="ping", description="for control send next step, is value ordercreate|accept|сompleted|finish"),
     *                 @OA\Property(property="message", type="string", default="", description=""),
     *                 @OA\Property(property="order", format="int64", type="integer", description="id order"),
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
     * @param Request $request
     * @return JsonResponse
     */
    public function status(Request $request)
    {
        /*
         *  // для проверки что запрос пришел от сервера корректный
            'status' => 'success',

            // для проверки что нам нужно отправить запрос дальше по шагам
            'status_connect' => 'pending',

            // текущий процесс запроса - пока не знаю для чего, но может пригодиться
            'process' => 'ping', //возможные варианты ping, ordercreate, accept, сompleted, finish

            // чтоб со стороны мобилки не было зацикливания в запросах, нужно передавать уникальный код
            // передаем след шаг на который необходимо отправить запрос
            'next_step' => 'ordercreate', //accept, сompleted, finish

            // для вывода сообщения
            'message' => 'Получили ошибку при отправке заказа в интегрируемую систему, заказ отменяется....',

            // для понимания по какому заказу отправлять данные
            'order' => 76, // (int) номер заказа
         * */
        try {
            /** @TODO вернуть проверку авторизации пользователя после фикса */
            //$profile = Auth::guard('api')->user()->profiles()->where('active', 'Y')->first();
            if ($request->input('order')) {
                $idOrder = (int)$request->input('order');
                $process = $request->input('process');
                $user = (new UserInfo())->getModel();
                if (!$user) {
                    throw new ErrorException('Ошибка авторизации');
                }
                $orderCollections = Order::where('id', $idOrder)->get();
                if ($orderCollections->count() <= 0) {
                    throw new ErrorException('Ошибка получения данных, отмена заказа');
                }
                $order = $orderCollections->toArray();

                /** @TODO реализовать механизм подключения к сервисам и получать ответ-стутус по формированию заказа */
                if ($process === 'cancel') {
                    sleep(1);
                    return response()->json([
                        'status' => 'success',
                        'status_connect' => 'success',
                        'process' => 'finish',
                        'next_step' => '',
                        //'message' => 'Ваш заказ #' . $request->order .', отменен.',
                        'message' => '',
                        'order' => $order['id'],
                    ]);
                }
                if ($process === 'ping') {
                    sleep(1);
                    return response()->json([
                        'status' => 'success',
                        'status_connect' => 'pending',
                        'process' => 'ping',
                        'next_step' => 'ordercreate',
                        'message' => 'Подключение к интегрируемой системе, ожидайте....',
                        'order' => $order['id'],
                    ]);
                }
                if ($process === 'ordercreate') {
                    sleep(5);
                    return response()->json([
                        'status' => 'success',
                        'status_connect' => 'pending',
                        'process' => 'ordercreate',
                        'next_step' => 'accept',
                        'message' => 'Происходит регистрация заказа в интегрируемой системе, ожидайте....',
                        'order' => $order['id'],
                    ]);
                }
                if ($process === 'accept') {
                    sleep(3);
                    return response()->json([
                        'status' => 'success',
                        'status_connect' => 'pending',
                        'process' => 'accept',
                        'next_step' => 'сompleted',
                        'message' => 'Заказ принят и обработан интегрируемой системой....',
                        'order' => $order['id'],
                    ]);
                }
                if ($process === 'сompleted') {
                    sleep(2);
                    return response()->json([
                        'status' => 'success',
                        'status_connect' => 'pending',
                        'process' => 'сompleted',
                        'next_step' => 'finish',
                        'message' => 'Заказ принят и обработан интегрируемой системой....',
                        'order' => $order['id'],
                    ]);
                }
                if ($process === 'finish') {
                    sleep(1);
                    return response()->json([
                        'status' => 'success',
                        'status_connect' => 'success',
                        'process' => 'finish',
                        'next_step' => 'finish',
                        'message' => 'Заказ успешно создан, номер вашего заказа #' . $order['id'],
                        'order' => $order['id'],
                    ]);
                }
            }
        } catch (Exception|Error|ErrorException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
