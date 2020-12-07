<?php

namespace App\SWF\SWServices\Authentication;


use App\SWF\SWServices\Services as Services;
use App\SWF\SWServices\Authentication\AuthRequest as AR;
use Exception;


class AuthenticationService extends Services{
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function auth($params){
        if(!is_array($params)){
            
            throw new Exception('No hay valores');
            
        }
        return new AuthenticationService($params);
        
    }
    

    public static function Token(){
        return AR::sendReq(Services::get_url(), Services::get_password(), Services::get_user(), Services::get_proxy());
    }
}










?>