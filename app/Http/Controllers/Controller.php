<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function toObject($arr)
    {
        return (object) json_decode(json_encode($arr));
    }

    public function toDbActive($bool)
    {
        switch ($bool) {
            case true:
                return 'Y';
                break;
            case false:
                return 'N';
                break;
        }
    }
}
