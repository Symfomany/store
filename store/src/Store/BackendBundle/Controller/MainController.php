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
        // Récupérer l'utilisateur
        $user = $this->getUser();

        // Récupérer Doctrine Manager
        $em = $this->getDoctrine()->getManager();
        $nbprod = $em->getRepository('StoreBackendBundle:Product')->getCountByUser($user);
        $nbsupp = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser($user);
        $nbcms = $em->getRepository('StoreBackendBundle:CMS')->getCountByUser($user);
        $nbcomm = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser($user);

        // je retourne la vue index de mon dossier Main
        return $this->render('StoreBackendBundle:Main:index.html.twig',
            array(
                'nbprod' => $nbprod,
                'nbsupp' => $nbsupp,
                'nbcms' => $nbcms,
                'nbcomm' => $nbcomm,
            )
        );
    }


}





