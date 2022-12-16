<?php

namespace App\Exceptions;

class ClientException extends \Exception
{
    public function responseJson(){
        return response()->json([
            'error'=>true,
            'message'=>$this->getMessage()
        ]);
    }
}
