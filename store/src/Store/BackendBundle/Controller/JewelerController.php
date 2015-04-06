<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class JewelerController
 * @package Store\BackendBundle\Controller
 */
class JewelerController extends Controller{

    /**
     * My Account
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myaccountAction(){

        return $this->render('StoreBackendBundle:Jeweler:myaccount.html.twig');
    }

    /**
     * My parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myparametersAction(){

        return $this->render('StoreBackendBundle:Jeweler:myparameters.html.twig');
    }

    /**
     * My parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mymessagesAction(){

        return $this->render('StoreBackendBundle:Jeweler:mymessages.html.twig');
    }

}





