<?php
namespace App\Traits;

use App\Traits\GeneralTrait;

trait AuthTrait
{
    use GeneralTrait;
    public function getResponse($message = null, $data = null, $error = false)
    {
        $report = $this->generateReport($message, $data, $error);

        return response()->json($report);

    }
}
