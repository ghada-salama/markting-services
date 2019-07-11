<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
trait  ApiResponseTrait  
{

    public function apiResponse( $data = null , $error = null , $code = 200,$message=null){

        $array = [
            'message' => $message,
            'code' => $code,
            'data' => $data,
            'status' => $code==200 ? true : false,
            'error' => $error
        ];

        return $array;

    }
    
    // public function successCode(){
    //     return [
    //         200 , 201 , 202
    //     ];
    // }
}
// "code": 400,
//     "message": "Validation Failed",
//     "errors": {
//         "children": {
//             "name": {
//                 "errors": [
//                     "This value should not be blank."
//                 ]
//             },
//             "client": {}
//         }
//     }