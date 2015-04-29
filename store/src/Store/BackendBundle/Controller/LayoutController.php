<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class LayoutController
 * Ce controlleur spécial contiendra mon action rendus par Twig
 * @package Store\BackendBundle\Controller
 */
class LayoutController extends Controller{

    /**
     * Me retourne la liste de mes messages
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mymessagesAction(){

        //je récupère l'Entité Manager
        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        //récuperer mes messages depuis ma requête
        $messages = $em->getRepository('StoreBackendBundle:Message')
            ->getLastMessagesByUser($user, 15);

        return $this->render('StoreBackendBundle:Partial:mymessages.html.twig',
            array(
                'messages' => $messages
            )
        );
    }
    /**
     * Me retourne la liste de mes commandes
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myordersAction(){

        //je récupère l'Entité Manager
        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        //récuperer mes messages depuis ma requête
        $orders = $em->getRepository('StoreBackendBundle:Order')
            ->getOrderByUser($user, 15);

        return $this->render('StoreBackendBundle:Partial:myorders.html.twig',
            array(
                'orders' => $orders
            )
        );
    }

}





