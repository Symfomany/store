<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class SupplierController
 * @package Store\BackendBundle\Controller
 */
class SupplierController extends Controller{


    /**
     * List my suppliers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){

        return $this->render('StoreBackendBundle:Supplier:list.html.twig');
    }

    /**
     * View a supplier
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){

        return $this->render('StoreBackendBundle:Supplier:view.html.twig',
            array(
                'id' => $id,
                'name' => $name
            )
        );

    }

}





