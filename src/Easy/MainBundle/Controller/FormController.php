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
        // отправка формы
        echo "sended";die();
        //return true;
    }
}