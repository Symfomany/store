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
        $user = 1;

        // Récupérer Doctrine Manager
        $em = $this->getDoctrine()->getManager();

        // Stats of counters
        $nbprod = $em->getRepository('StoreBackendBundle:Product')->getCountByUser($user);
        $nbsupp = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser($user);
        $nbcms = $em->getRepository('StoreBackendBundle:CMS')->getCountByUser($user);
        $nbcomm = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser($user);

        // Turn Over
        $ca = $em->getRepository('StoreBackendBundle:Order')->getCA($user);

        // Chart in last 6 months
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('now'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-1 month'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-2 month'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-3 month'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-4 month'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-5 month'));

        // je retourne la vue index de mon dossier Main
        return $this->render('StoreBackendBundle:Main:index.html.twig',
            array(
                'ca' => $ca,
                'nbprod' => $nbprod,
                'nbsupp' => $nbsupp,
                'nbcms' => $nbcms,
                'nbcomm' => $nbcomm,
                'statorder' => $statorder,
            )
        );
    }


}





