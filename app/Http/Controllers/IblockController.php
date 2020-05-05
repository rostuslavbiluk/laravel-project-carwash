<?php

namespace App\Http\Controllers;

use App\Classes\ClassHelper;
use App\User;
use App\UserGroups;
use Illuminate\Http\Request;
use App\Classes\Grid;
use App\Model\Iblock;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class IblockController extends Controller
{
    public function index()
    {
        $iblock = Iblock::all();
        if ($iblock) {
            $result = ['items' => $iblock->toArray()];
        }
        return view('template.iblock.index', ['result' => $result]);
    }

    public function showTypeIblock()
    {
        $iblock = Iblock::all();
        if ($iblock) {
            $items = Grid::getStructureData($iblock->toArray(), Iblock::$nameColumns);
        }
        $result = Grid::prepareSettings([
            'ITEM' => $items ?? [],
            'H1' => 'Список типов ифоблоков',
            'MAIN_ACTIONS' => [
                ['ADD' => '/admin/iblock/type/add'],
                ['EDIT' => '#'],
                ['DELETE' => '/admin/iblock/type/delete'],
            ],
            'ACTIONS' => [
                ['EVENT' => '/admin/iblock/type/edit'],
                ['EVENT' => '/admin/iblock/type/delete'],
            ],
        ]);
        return view('template.iblock.type')->with(compact('result'));
    }






    public function showListIblock(Request $request)
    {
        $arItems = [];

        $code = $request->route('code');

        list($objEntity, $sTitlePage) = \App\Classes\ClassHelper::getEntityModel($code);

        if (is_object($objEntity)) {
            $arAllResult = $objEntity::all();
        }

        if (is_object($arAllResult)) {

            $arItems = Grid::getStructureData($arAllResult->toArray(), Grid::$nameColumns);
        }

        $arResult = Grid::prepareSettings([
            'ITEM' => $arItems,
            'H1' => $sTitlePage,
            'MAIN_ACTIONS' => [
                ['ADD' => '/admin/iblock/list/'.$code.'/add'],
                ['EDIT' => '/admin/iblock/list/'.$code.'/edit'],
                ['DELETE' => '/admin/iblock/list/'.$code.'/delete'],
            ],
            'ACTIONS' => [
                ['EVENT' => '/admin/iblock/list/'.$code.'/edit'],
                ['EVENT' => '/admin/iblock/list/'.$code.'/delete']
            ],
        ]);

        return view('template.iblock.list')->with(compact('arResult'));
    }



    public function typeIblockAdd(Request $request)
    {
        $arResult = [
            'ACTION' => '/admin/iblock/type/add',
            'TYPE_FORM' => 'ADD', //EDIT, DELETE
            'FIELDS' => []
        ];

        if ((int)$request->route('id') > 0) {
            $arResult['ID'] = $request->route('id');
            $arResult['ACTION'] .= '/'.$arResult['ID'];

        } else {
            $arResult['ID'] = 0;
        }

        if (\Request::has('SEND_FORM') && \Request::isMethod('post')) {
            if ($request->SEND_FORM == 'Y' && $arResult['ID'] == 0) {

                Iblock::create($request->toArray());
                return redirect('/admin/iblock/type');
            } else {

                if (!empty($request->name)
                    && !empty($request->code)) {

                    Iblock::where('ID', $arResult['ID'])
                        ->update([
                            'NAME' => $request->name,
                            'CODE' => $request->code,
                            'SORT' => (((int)$request->sort > 0)? $request->sort: 500),
                            'ACTIVE' => (($request->active == 'Y')? 'Y': 'N'),
                        ]);

                    return redirect('/admin/iblock/type');
                }
            }
        }

        if ((int)$arResult['ID'] > 0) {
            $arResult['TYPE_FORM'] = 'EDIT';

            $iblockRes = Iblock::find($arResult['ID']);
            $arResult['FIELDS'] = $iblockRes->toArray();
        }

        return view('template.iblock.type-add')->with(compact('arResult'));
    }

    public function typeIblockDelete(Request $request)
    {
        if ((int)$request->route('id') > 0) {

            /*$objectIblock = Iblock::where('ID', (int)$request->route('id'))->first();
            if (!$objectIblock) {
                $objectIblock->delete();
            }*/

            Iblock::destroy((int)$request->route('id'));
        }

        return redirect('/admin/iblock/type')->with('message', 'Successfully deleted the items!');
    }

    public function addElementIblock(Request $requests)
    {

        if (!empty($requests->route('code'))) {
            $nameTemplate = $requests->route('code');

            $arResult = [
                'ACTION' => '/admin/iblock/list/' . $nameTemplate . '/add',
                'SEND_FORM' => 'Y',
                'TITLE' => 'Добавление элемента',
                'DESCRIPTION' => '',
                'BACK' => '/admin/iblock/list/' . $nameTemplate,
                'FIELDS' => [],
            ];

            $idUserCreated = (Auth::user()->id)?Auth::user()->id: 1;

            $arFieldsDefault = [
                [
                    'TYPE' => 'S',
                    'INPUT_NAME' => 'entity',
                    'CODE' => 'entity',
                    'VALUE' => $nameTemplate,
                    'HIDDEN' => 'Y',
                    'PARAMS' => '',
                ],[
                    'TYPE' => 'S',
                    'INPUT_NAME' => 'SEND_FORM',
                    'CODE' => 'SEND_FORM',
                    'VALUE' => 'Y',
                    'HIDDEN' => 'Y',
                    'PARAMS' => '',
                ],[
                    'TYPE' => 'S',
                    'INPUT_NAME' => 'created_by',
                    'CODE' => 'created_by',
                    'VALUE' => $idUserCreated,
                    'HIDDEN' => 'Y',
                    'PARAMS' => '',
                ]
            ];

            if (!empty($nameTemplate)) {
                list($objEntity, $sTitlePage) = \App\Classes\ClassHelper::getEntityModel($nameTemplate);
            }

            if ($objEntity) {

                if (isset($objEntity::$arFieldsEntity)) {
                    $arFieldsEntity = $objEntity::$arFieldsEntity;

                    $arResult['FIELDS'] = array_merge($arFieldsDefault, $arFieldsEntity);

                    $arRequst['id'] = $requests->route('id');
                    $arRequst['code'] = $nameTemplate;

                    ClassHelper::getEntityData($nameTemplate, $arResult['FIELDS'], $arRequst);
                }

                //echo '<pre>'.print_r($arResult['FIELDS'], 1).'</pre>';

                if (!empty($requests->route('id'))) {
                    if ((int)$requests->route('id') > 0) {

                        $this->getValueItemsByID($objEntity, $requests->route('id'), $arResult['FIELDS']);

                        $arResult['FIELDS'][] = [
                            'TYPE' => 'S',
                            'INPUT_NAME' => 'id',
                            'CODE' => 'id',
                            'NAME' => '',
                            'VALUE' => (int)$requests->route('id'),
                            'HIDDEN' => 'Y',
                            'PARAMS' => '',
                        ];

                    }
                }

                //echo '<pre>'.print_r($arResult, 1).'</pre>';
            }

            return view('template.iblock.form.add')->with(compact('arResult'));
        }

        return redirect('/admin/iblock');
    }

    public function getValueItemsByID($objEntity, $nId, &$arFields)
    {
        if (isset($objEntity)) {
            if ((int)$nId > 0) {

                $objElement = $objEntity::find($nId);

                if (!empty($objElement->toArray())) {

                    $arValueItem = $objElement->toArray();
                    if (!empty($arValueItem)) {

                        if (!empty($arFields)) {
                            foreach ($arFields as &$arField) {

                                if (isset($arValueItem[$arField['INPUT_NAME']])) {

                                    $arField['VALUE'] = $arValueItem[$arField['INPUT_NAME']];
                                }
                            }
                            unset($arField);
                        }
                    }

                }
            }
        }
    }

    public function saveElementIblock(Request $requests)
    {
        if ($requests->SEND_FORM == 'Y') {
            if (!empty($requests->entity)) {

                list($objEntity, $sTitlePage) = \App\Classes\ClassHelper::getEntityModel($requests->entity);

                if ($objEntity) {
                    $arSaveParams = $requests->toArray();

                    if (!isset($arSaveParams['active'])) {
                        $arSaveParams['active'] = "N";
                    }

                    /* логируем пользователя который добавляем запись */
                    $arSaveParams['created_by'] = Auth::user()->id;

                    if (isset($arSaveParams['id'])) {
                        if ((int)$arSaveParams['id'] > 0) {

                            if (method_exists($objEntity, 'OnBeforeIBlockElementUpdate')) {
                                $objEntity::OnBeforeIBlockElementUpdate($arSaveParams);
                            }

                            $objEntity::where('id', $arSaveParams['id'])->update($arSaveParams);

                            if (method_exists($objEntity, 'OnAfterIBlockElementUpdate')) {
                                $objEntity::OnAfterIBlockElementUpdate($arSaveParams);
                            }

                        }

                        $sMessage = 'Запись успешно обновлена';
                    } else {

                        if (method_exists($objEntity, 'OnBeforeIBlockElementAdd')) {
                            $objEntity::OnBeforeIBlockElementAdd($arSaveParams);
                        }

                        $arResult = $objEntity::create($arSaveParams)->toArray();

                        if (isset($arResult['id'])) {
                            $arSaveParams['id'] = $arResult['id'];
                        }

                        if (method_exists($objEntity, 'OnAfterIBlockElementAdd')) {
                            $objEntity::OnAfterIBlockElementAdd($arSaveParams);
                        }

                        $sMessage = 'Запись успешно добавлена';
                    }

                    return redirect('/admin/iblock/list/' . $requests->entity)->with([
                        'message' => $sMessage
                    ]);
                }
            }
        }

        return redirect('/admin/iblock');
    }

    public function deleteElement($sEntityCode, $nId)
    {
        if (!empty($sEntityCode)) {
            list($objEntity, $sTitlePage) = \App\Classes\ClassHelper::getEntityModel($sEntityCode);

            if ($objEntity) {

                if ((int)$nId > 0) {
                    $objEntity::find($nId)->delete();
                    //$objEntity::destroy($nId);

                    return redirect('/admin/iblock/list/' . $sEntityCode)->with(['message' => 'Запись успешно удалена']);
                }
            }
        }

        return redirect('/admin/iblock/list/' . $sEntityCode)->with(['message' => 'Ошибка удаления записи']);
    }
}
