<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class OrderController
 * @package Store\BackendBundle\Controller
 */
class OrderController extends Controller{


    /**
     * List my orders
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $orders = $em->getRepository('StoreBackendBundle:Order')->getOrderByUser($user);

        return $this->render('StoreBackendBundle:Order:list.html.twig', array(
            'orders' => $orders
        ));
    }

    /**
     * View a order
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){

        return $this->render('StoreBackendBundle:Order:view.html.twig',
            array(
                'id' => $id,
                'name' => $name
            )
        );

    }

}





