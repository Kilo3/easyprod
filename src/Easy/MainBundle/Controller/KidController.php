<?php

namespace Easy\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KidController extends Controller
{
    public function moreAction()
    {
        return $this->render('EasyMainBundle:Kid:more.html.twig');
    }
    
}
