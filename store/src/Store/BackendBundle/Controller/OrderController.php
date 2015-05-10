<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class OrderController
 * @package Store\BackendBundle\Controller
 */
class OrderController extends Controller{


    /**
     * List my orders
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $orders = $em->getRepository('StoreBackendBundle:Order')->getOrderByUser($user);

        //paginate to bundle
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );


        return $this->render('StoreBackendBundle:Order:list.html.twig', array(
            'orders' => $pagination
        ));
    }


    /**
     * Modify State of Order
     * @param $id
     * @Security("is_granted('', id)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stateAction(Order $order, $state){

        $em = $this->getDoctrine()->getManager();
        $order->setState($state);
        $em->persist($order);
        $em->flush();

        //message flash de confirmation
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre commande '.$order->getId().' a bien été modifiée'
        );

        return $this->redirectToRoute('store_backend_order_list');
    }


}





