<?php

namespace Easy\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SummerController extends Controller
{
    public function moreAction()
    {
        return $this->render('EasyMainBundle:Summer:more.html.twig');
    }
    
}
