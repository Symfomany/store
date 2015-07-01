<?php

namespace Store\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('StoreFrontendBundle:Default:index.html.twig');
    }
}
