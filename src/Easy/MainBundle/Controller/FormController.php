<?php

namespace Easy\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormController extends Controller
{
    public function indexAction(Request $request){
        $name = $request->request->get('name');
        $phone = $request->request->get('phone');
        
        $to      = 'irk@e-a-s-y.ru';
        $subject = 'Запрос с сайта';
        $message = "Имя: {$name}, Номер: {$phone}";
        $headers = 'From: irk@e-a-s-y.ru' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        //var_dump(mail($to, $subject, $message, $headers));die();
        if(mail($to, $subject, $message, $headers)){
            echo "sended";die();
        }else{
            echo "not sended";die();
        }
        
    }
    
    
    public function changeFormAction($type)
    {   
        $html = ""; // HTML as response
//        $tag = $this->getDoctrine()
//            ->getRepository('YourBundle:Tag')
//            ->find($tagId);
//
//        $categories = $tag->getCategories();
//
//        foreach($categories as $cat){
//            $html .= '<option value="'.$cat->getId().'" >'.$cat->getName().'</option>';
//        }
        $html .= "<p>ok{$type}</p>";

        return new Response($html, 200);
        
    }
}