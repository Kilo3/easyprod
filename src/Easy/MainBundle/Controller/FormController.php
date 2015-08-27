<?php

namespace Easy\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class FormController extends Controller
{
    public function indexAction(Request $request){
        $name = $request->request->get('name');
        $phone = $request->request->get('phone');
        
        $to      = 'cubeintocube@gmail.com';
        $subject = 'Запрос с сайта';
        $message = "Имя: {$name}, Номер: {$phone}";
        $headers = 'From: webmaster@e-a-s-y.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        //var_dump(mail($to, $subject, $message, $headers));die();
        if(mail($to, $subject, $message, $headers)){
            echo "sended";die();
        }else{
            echo "not sended";die();
        }
        
    }
}