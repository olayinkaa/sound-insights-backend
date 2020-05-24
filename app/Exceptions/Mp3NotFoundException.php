<?php

namespace App\Exceptions;

use Exception;

class Mp3NotFoundException extends Exception
{
    //
    public function render()
    {
        return response()->json([

            'error'=>'Mp3 does not exist'

        ],404);
    }
}
