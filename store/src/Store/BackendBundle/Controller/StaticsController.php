<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class StaticsController
 * @package Store\BackendBundle\Controller
 */
class StaticsController extends Controller{

    /**
     * Page Contact
     */
    public function contactAction(){

        //je retourne la vue contact contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:contact.html.twig');
    }


}





