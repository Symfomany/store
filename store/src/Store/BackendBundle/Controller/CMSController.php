<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class CMSController
 * @package Store\BackendBundle\Controller
 */
class CMSController extends Controller{


    /**
     * List my cms
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){

        return $this->render('StoreBackendBundle:CMS:list.html.twig');
    }

    /**
     * View a cms
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){

        return $this->render('StoreBackendBundle:CMS:view.html.twig',
            array(
                'id' => $id,
                'name' => $name
            )
        );

    }

}





