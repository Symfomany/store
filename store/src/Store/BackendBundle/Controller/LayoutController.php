<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class LayoutController
 * @package Store\BackendBundle\Controller
 */
class LayoutController extends Controller{

    /**
     * My Messages
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mymessagesAction(){
        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        $messages = $em->getRepository('StoreBackendBundle:Message')
            ->getLastMessagesByUser($user, 15);

        return $this->render('StoreBackendBundle:Partial:mymessages.html.twig', array(
            'messages' => $messages
        ));
    }

}





