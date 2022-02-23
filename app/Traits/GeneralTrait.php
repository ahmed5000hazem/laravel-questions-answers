<?php

namespace App\Traits;

trait GeneralTrait
{
    public function generateReport($message = null, $data = null, $error = false)
    {
        if (!is_array($message)) $message = [$message];
        return [
            "message" => $message,
            "context" => [
                "error" => $error,
                "data" => $data
            ],
        ];
    }
}
