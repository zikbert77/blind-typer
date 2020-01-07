<?php

namespace App\Component;

class Logger
{
    public static function log(string $type, array $data)
    {
        try {
            $logDir = '../var/log/app/' . date('Y-m-d');
            if (!file_exists($logDir)) {
                mkdir($logDir);
            }

            $logData = [
                'time' => (new \DateTime())->format('H:i:s'),
                'data' => $data
            ];

            file_put_contents($logDir . '/' . $type . '_' . '.log', json_encode($logData) . "\n", FILE_APPEND);
        } catch (\Exception $exception) {
            //todo: add telegram errors notificator
            dump($exception->getMessage());
            exit;
        }
    }
}