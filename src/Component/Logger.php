<?php

namespace App\Component;

class Logger
{
    public static function log(string $type, array $data)
    {
        try {
            $logDir = '../var/log/app';
            if (!file_exists($logDir)) {
                mkdir($logDir);
            }

            $logData = [
                'time' => (new \DateTime())->format('H:i:s'),
                'data' => $data
            ];

            file_put_contents('../var/log/app/' . $type . '_' . date('Y-m-d') . '.log', json_encode($logData) . "\n", FILE_APPEND);
        } catch (\Exception $exception) {
            //todo: add telegram errors notificator
            dump($exception->getMessage());
            exit;
        }
    }
}