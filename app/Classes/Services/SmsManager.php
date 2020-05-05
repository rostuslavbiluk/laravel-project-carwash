<?php

namespace App\Classes\Services;

class SmsManager
{
    private static $apiKey = 'B535A136-A4EA-EAB6-E53D-AD6D194FBED1';
    private static $sendSms = false;

    public static function sendConfim(array $params)
    {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/.aSendConfim.txt', json_encode($params));
        if (!static::$sendSms) {
            return true;
        }
        if (!empty($params['phone']) && !empty($params['confirm_code'])) {
            $smsru = new SmsRu(self::$apiKey);

            $objStdClass = new \stdClass();
            $objStdClass->to = (string)$params['phone'];
            $objStdClass->text = 'Ваш код ' . (string)$params['confirm_code'] . ' (подключение приложения) '; // Текст сообщения

            // $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
            // $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
            // $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
            // $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения

            $objStdClass->partner_id = '237659';
            $sms = $smsru->send_one($objStdClass);

            /** @TODO реализовать нормальный класс логера смс */
            $logs = [];
            if ($sms->status == "OK") {
                $logs['message'] = 'Сообщение отправлено успешно. ';
                $logs['id_message'] = "ID сообщения: $sms->sms_id. ";
                $logs['balance'] = "Ваш новый баланс: $sms->balance";
            } else {
                $logs['message'] = 'Сообщение не отправлено. ';
                $logs['id_message'] = "Код ошибки: $sms->status_code. ";
                $logs['balance'] = "Текст ошибки: $sms->status_text.";
            }
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/.aSendConfimLogs.txt', json_encode($logs), FILE_APPEND);
            if ($sms->status == "OK") {
                return true;
            }
        }
        return false;
    }
}
