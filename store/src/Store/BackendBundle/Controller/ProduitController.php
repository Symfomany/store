<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class ProduitController
 * @package Store\BackendBundle\Controller
 */
class ProduitController extends Controller{


    /**
     * List my product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('StoreBackendBundle:Product')->getProductByUser(1);

        return $this->render('StoreBackendBundle:Product:list.html.twig', array(
            'products' => $products
        ));
    }

    /**
     * View a product
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){

        return $this->render('StoreBackendBundle:Product:view.html.twig',
            array(
                'id' => $id,
                'name' => $name
            )
        );

    }

}





