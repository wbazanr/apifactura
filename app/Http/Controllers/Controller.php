<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function get_response($message,$estado,$data)
    {
        //heredar //padre
        return[
            "estado" => $estado,
            "mensaje" => $message,
            "data" => $data
        ];
    }
}
