<?php

namespace App\Http\Controllers;

use App\Classes\Entity\User\UserEntity;
use App\Classes\Entity\User\UserInfo;
use App\Classes\Helpers\Phone;
use App\Classes\Helpers\Utils;
use App\Model\Requisites;
use App\Model\UserCards;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Error;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;


class PaymentInvoiceController extends Controller
{
    public function index()
    {
        $result = [];
        /** @TODO реализовать формирование договора pdf */
        /*$result['contract'] = [
            'id' => false,
            'date' => false,
            'status' => false
        ];*/
        try {
            $user = new UserInfo();
            if ($user->roles()->isCarwashUser()) {
                $result['invoice']['businesscard'] = [];
                $entity = $user->getModel()->pointCarwash()->first(['id']);
                if ($entity) {
                    $result['invoice']['businesscard'] = $entity->paymentCards()->getResults()->toArray();
                    $requisites = $entity->requisites()->first();
                    if ($requisites) {
                        $result['requisites'] = $requisites->toArray();
                    }
                }
            }
            if ($user->roles()->isTaxiparkUser()) {
                $entity = $user->getModel()->taxipark()->first(['id']);
                $requisites = $entity->requisites()->first();
                if ($requisites) {
                    $result['requisites'] = $requisites->toArray();
                }
            }
        } catch (Error|QueryException $e) {
        }
        return view('template.invoice.requisites', compact('result'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function edit(Requisites $requisites, Request $request)
    {
        $params = $request->except('_token');
        Utils::eraseArray($params);
        if (array_key_exists('phone', $params)) {
            $params['phone'] = Phone::normalize($params['phone']);
        }
        $validator = Validator::make($params, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'type' => ['required', 'string', 'min:1', 'max:255'],
            'inn' => ['required', 'numeric', 'min:12'],
            'kpp' => ['required', 'numeric', 'min:12'],
            'ogrn' => ['required', 'numeric', 'min:12'],
            'postcode1' => ['required', 'numeric', 'min:12'],
            'address1' => ['required', 'string', 'min:3', 'max:255'],
            'postcode2' => ['required', 'numeric', 'min:12'],
            'address2' => ['required', 'string', 'min:3', 'max:255'],
            'bik' => ['required', 'string', 'min:1', 'max:20'],
            'bank_name' => ['required', 'string', 'min:1', 'max:255'],
            'bank_address' => ['required', 'string', 'min:1', 'max:255'],
            'kor_account' => ['required', 'string', 'min:1', 'max:255'],
            'ras_account' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'min:1', 'max:255'],
            'phone' => ['required', 'numeric', 'min:12'],
            'type_nds' => ['required', 'string', 'min:1', 'max:255'],
            'policy' => ['required', 'in:Y'],
        ], [
            'policy.required' => 'Необходимо согласие с правилами и условиями',
        ]);
        if ($validator->fails()) {
            return redirect()->route('requisites.index')->withErrors($validator)->withInput();
        }
        unset($params['policy']);
        try {
            if ($requisites) {
                $user = new UserInfo();
                if ($user->roles()->isCarwashUser()) {
                    $entity = $user->getModel()->pointCarwash()->firstOrFail(['id']);
                    if ($entity) {
                        $params['entity_id'] = $entity->getAttributeValue('id');
                    }
                }
                if ($user->roles()->isTaxiparkUser()) {
                    $entity = $user->getModel()->taxipark()->firstOrFail(['id']);
                    if ($entity) {
                        $params['org_id'] = $entity->getAttributeValue('id');
                    }
                }
                if ($entity) {
                    $params['id'] = $requisites->id ?? 0;
                    if ((int)$params['id'] > 0) {
                        $isSeccess = $requisites->update($params);
                    } else {
                        $isSeccess = $requisites->fill($params)->save();
                    }
                    if (!$isSeccess) {
                        throw new \ErrorException('Ошибка сохранения данных');
                    }
                }
            }
        } catch (\ErrorException|QueryException $e) {
            return redirect()->route('requisites.index')->withErrors($e->getMessage())->withInput();
        }
        //Session::flash('message', 'Данные успешно сохранены.');
        return redirect()->route('requisites.index');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function deleteCard(Request $request)
    {
        if ($request->input('card_id')) {
            if ((new UserInfo())->roles()->isCarwashUser()) {
                try {
                    UserCards::destroy((int)$request->input('card_id'));
                    return 'Y';
                } catch (Error $e) {
                }
            }
        }
        return 'N';
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addCard(Request $request)
    {
        if (!empty($request->input('entity_cards'))) {
            try {
                $user = new UserInfo();
                $entity = $user->getModel()->pointCarwash()->first(['id']);
                if ($entity) {
                    /** @var UserCards $cardModel */
                    $cardModel = $entity->paymentCards();
                    if ($cardModel) {
                        $cardModel->delete();
                        $cards = $request->input('entity_cards');
                        foreach ($cards as $item) {
                            $number = preg_replace('~\D~', '', $item);
                            if (!empty($number)) {
                                $cardModel->create([
                                    'number' => $number,
                                    'entity_id' => $entity->id,
                                ]);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
            }
        }
        return back();
    }
}
