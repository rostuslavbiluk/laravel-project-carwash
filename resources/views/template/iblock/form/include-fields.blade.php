@php
    $html = '';
    if (!empty($arResult['FIELDS'])) {

        foreach($arResult['FIELDS'] as $arItems) {
            if ($arItems['HIDDEN'] == 'Y') {
                echo '<div style="display:none;"><input type="text" '.$arItems['PARAMS'].'
                        id="'.$arItems['INPUT_NAME'].'"
                        name="'.$arItems['INPUT_NAME'].'"
                        value="'.$arItems['VALUE'].'"></div>';
            }
        }

        foreach($arResult['FIELDS'] as $arItems) {

            if ($arItems['HIDDEN'] == 'Y') {
                continue;
            }

            $html .= '<div class="form-group row">';
            switch($arItems['TYPE']) {
                case('S'):

                    $prefBlockBegin = "";
                    $prefBlockEnd = "";

                    if ($arItems['CODE'] == 'email' && 1==2) {
                        $prefBlockBegin = '<div class="input-group">';
                        $prefBlockEnd = '
                            <div class="input-group-addon">@</div>
                                <input class="form-control" type="text" value="laravel.loc" disabled>
                            </div>';

                            $sValueEmail = $arItems['VALUE'];

                            if(!empty($sValueEmail)) {
                                $sValueEmail = explode('@', $sValueEmail);
                                if (isset($sValueEmail['0']) && !empty($sValueEmail['0'])) {
                                    $arItems['VALUE'] = $sValueEmail['0'];
                                }
                            }
                    }

                    $html .= '
                        <label class="col-form-label col-sm-4" for="'.$arItems['INPUT_NAME'].'">'.$arItems['NAME'].'</label>
                        <div class="col-sm-8">

                            ' . $prefBlockBegin . '

                            <input '.$arItems['PARAMS'].'
                                id="'.$arItems['INPUT_NAME'].'"
                                name="'.$arItems['INPUT_NAME'].'"';

                                if (isset($arItems['HIDDEN']) && $arItems['HIDDEN'] == 'Y') {
                                   $html .= ' type="hidden"';
                                } else {
                                   $html .= ' type="text"';
                                }

                                if (isset($arItems['REQUIRED']) && $arItems['REQUIRED'] == 'Y') {
                                    $html .= ' required="required"';
                                }

                                if (isset($arItems['VALUE'])) {
                                    if (!empty($arItems['DEFAULT']) && empty($arItems['VALUE'])) {
                                        $html .= 'value="'. $arItems['DEFAULT'] .'"';
                                    } else {
                                        $html .= 'value="'. $arItems['VALUE'] .'"';
                                    }
                                }
                                $html .= '>';

                                $html .= $prefBlockEnd;

                                $html .= '
                        </div>';
                    break;

                case('S:html'):

                    $html .= '
                        <label class="col-form-label col-sm-4" for="'.$arItems['INPUT_NAME'].'">'.$arItems['NAME'].'</label>
                            <div class="col-sm-8">';

                                $textareaValue ='';
                                if (isset($arItems['VALUE'])) {
                                    $textareaValue = $arItems['VALUE'];
                                }

                    $html .= '<textarea '.$arItems['PARAMS'].'
                                    id="'.$arItems['INPUT_NAME'].'"
                                    name="'.$arItems['INPUT_NAME'].'">'.$textareaValue.'</textarea>';
                    $html .= '
                            </div>';
                    break;

                case('S:date'):

                    $html .= '
                        <label class="col-form-label col-sm-4" for="'.$arItems['INPUT_NAME'].'">'.$arItems['NAME'].'</label>
                            <div class="col-sm-2">
                                <input '.$arItems['PARAMS'].'
                                id="'.$arItems['INPUT_NAME'].'"
                                name="'.$arItems['INPUT_NAME'].'"';

                                if (isset($arItems['HIDDEN']) && $arItems['HIDDEN'] == 'Y') {
                                   $html .= ' type="hidden"';
                                } else {
                                   $html .= ' type="text"';
                                }

                                if (isset($arItems['REQUIRED']) && $arItems['REQUIRED'] == 'Y') {
                                    $html .= ' required="required"';
                                }

                                if (isset($arItems['VALUE'])) {
                                    if (!empty($arItems['DEFAULT']) && empty($arItems['VALUE'])) {
                                        $html .= 'value="'. $arItems['DEFAULT'] .'"';
                                    } else {
                                        $html .= 'value="'. $arItems['VALUE'] .'"';
                                    }
                                }
                                $html .= '>';
                    $html .= '
                            </div>';
                    break;

                case('L:select'):
                    $html .= '
                        <label class="col-form-label col-sm-4" for="'.$arItems['INPUT_NAME'].'">'.$arItems['NAME'].'</label>
                            <div class="col-sm-8">
                                <select ' . $arItems['PARAMS'] . ' name="'.$arItems['INPUT_NAME'].'">';

                                $sSelDef = '';
                                if (!isset($arItems['LIST']) || empty($arItems['LIST'])) {
                                    $sSelDef = 'selected';
                                }

                                $html .= '<option value="" ' . $sSelDef . '>Не установлено</option>';

                                if (isset($arItems['LIST']) && !empty($arItems['LIST'])) {

                                    foreach ($arItems['LIST'] as $arItem) {

                                    $arItem['ID'] = (isset($arItem['id'])) ? $arItem['id']:$arItem['ID'];
                                    $arItem['NAME'] = (isset($arItem['name'])) ? $arItem['name']:$arItem['NAME'];

                                        if (isset($arItem['ID'])) {

                                        $html .= '<option value="'.$arItem['ID'].'"';

                                            $sValue = $arItems['VALUE'];
                                            if (!empty($arItems['DEFAULT'])
                                                && empty($arItems['VALUE'])) {

                                                $sValue = $arItems['DEFAULT'];
                                            }

                                            if (($sValue == $arItem['ID']) ||
                                                (isset($arItem['SELECTED']) && $arItem['SELECTED'] == 'Y')) {
                                                $html .= 'selected="true"';
                                            }

                                        $html .= '>'.$arItem['NAME'].'</option>';

                                        }
                                    }
                                }

                    $html .=    '</select>
                            </div>';

                    break;

                case('S:checkbox'):

                    $html .= '
                        <label class="col-form-label col-sm-5" for="'.$arItems['INPUT_NAME'].'">'.$arItems['NAME'].'</label>
                            <div class="col-sm-2">';

                                $html .= '<input '.$arItems['PARAMS'].' id="'.$arItems['INPUT_NAME'].'"';

                                    if ($arItems['VALUE'] == 'Y') {
                                        $html .= 'checked';
                                    }

                                    if ((!empty($arItems['DEFAULT']) && $arItems['DEFAULT'] == 'Y')
                                        && empty($arItems['VALUE'])) {

                                        $html .= 'checked';
                                    }

                                $html .= '  value="Y"
                                            name="'.$arItems['INPUT_NAME'].'"
                                            type="checkbox">';

                    $html .= '</div>';
                    break;

                default:
                    $html .= '
                        <label class="col-form-label col-sm-4" for="'.$arItems['INPUT_NAME'].'">'.$arItems['NAME'].'</label>
                            <div class="col-sm-8">
                                <input '.$arItems['PARAMS'].'
                                    id="'.$arItems['INPUT_NAME'].'"
                                    name="'.$arItems['INPUT_NAME'].'"';

                                    if (isset($arItems['HIDDEN']) && $arItems['HIDDEN'] == 'Y') {
                                       $html .= ' type="hidden"';
                                    } else {
                                       $html .= ' type="text"';
                                    }

                                    if (isset($arItems['REQUIRED']) && $arItems['REQUIRED'] == 'Y') {
                                        $html .= ' required="required"';
                                    }

                                    if (isset($arItems['VALUE'])) {
                                        if (!empty($arItems['DEFAULT']) && empty($arItems['VALUE'])) {
                                            $html .= 'value="'. $arItems['DEFAULT'] .'"';
                                        } else {
                                            $html .= 'value="'. $arItems['VALUE'] .'"';
                                        }
                                    }
                                    $html .= '>
                            </div>';
            }

            $html .= '</div>';
        }

        echo $html;
    }

@endphp
