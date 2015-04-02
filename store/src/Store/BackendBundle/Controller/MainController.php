<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class MainController
 * @package Store\BackendBundle\Controller
 */
class MainController extends Controller{

    /**
     * Page Dashboard on Backend
     */
    public function indexAction(){

        // je retourne la vue index de mon dossier Main
        return $this->render('StoreBackendBundle:Main:index.html.twig');
    }


}





