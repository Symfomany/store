<?php

namespace Store\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StoreFrontendBundle:Default:index.html.twig', array('name' => $name));
    }
}
