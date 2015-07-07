<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MainController.
 */
class MainController extends Controller
{
    /**
     * Page Dashboard on Backend.
     */
    public function indexAction()
    {

        //dump(['message' => "coucou"]);

//        exit(dump($this->get('store.backend.datas')));
//        $finderProducts = $this->container->get('fos_elastica.finder.website.product');
//
//// Option 1. Returns all users who have example.net in any of their mapped fields
//        $results = $finderProducts->find('zuzu38080@gmail.com');

        // Récupérer l'utilisateur
        $user = $this->getUser();
//
//        $this->get('store.backend.email')->sendparam($user, 'julien@meetserious.com',
//            'StoreBackendBundle:Email:welcome.html.twig', "Bienvenue :)",'zuzu38080@gmail.com', '<p>okay</p>');
//
        // Récupérer Doctrine Manager
        $em = $this->getDoctrine()->getManager();

        // Stats of counters
        $nbprod = $em->getRepository('StoreBackendBundle:Product')->getCountByUser($user);
        $nbsupp = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser($user);
        $nbcms = $em->getRepository('StoreBackendBundle:CMS')->getCountByUser($user);
        $nbcomm = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser($user);

        // Turn Over
        $ca = $em->getRepository('StoreBackendBundle:Order')->getCA($user);

        //nb de product à null
        $nbprodempty = $em->getRepository('StoreBackendBundle:Product')->getNbProdEmpty($user);

        //nb de product à null
        $nblikes = $em->getRepository('StoreBackendBundle:Product')->getNbLikesByUser($user);

        //5 last comments
        $lastcommentsactifs = $em->getRepository('StoreBackendBundle:Comment')->getLastComments($user, 5, 2);
        $lastcommentsencours = $em->getRepository('StoreBackendBundle:Comment')->getLastComments($user, 5, 1);
        $lastcommentsinactifs = $em->getRepository('StoreBackendBundle:Comment')->getLastComments($user, 5, 0);

        //commandes
        $orders = $em->getRepository('StoreBackendBundle:Order')->getOrderByUser($user, 5);

        $bestcategories = $em->getRepository('StoreBackendBundle:Category')->getBestCategoryByUser($user, 5);

        //last messages
        $messages = $em->getRepository('StoreBackendBundle:Message')->getLastMessagesByUser($user, 5);

        // Chart in last 6 months
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('now'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-1 month'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-2 month'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-3 month'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-4 month'));
        $statorder[] = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByMonth($user, new \DateTime('-5 month'));

        $response = new Response();
        $response->setPrivate();

        // définit une directive personnalisée du Cache-Control
        $response->headers->addCacheControlDirective('must-revalidate', true);

        $date = new \DateTime();
        $date->modify('+600 seconds');
        $response->setExpires($date);

        $response->setContent($this->renderView('StoreBackendBundle:Main:index.html.twig',
            array(
                'ca' => $ca,
                'nbprod' => $nbprod,
                'nbprodempty' => $nbprodempty,
                'lastcommentsactifs' => $lastcommentsactifs,
                'lastcommentsencours' => $lastcommentsencours,
                'lastcommentsinactifs' => $lastcommentsinactifs,
                'bestcategories' => $bestcategories,
                'messages' => $messages,
                'orders' => $orders,
                'nblikes' => $nblikes,
                'nbsupp' => $nbsupp,
                'nbcms' => $nbcms,
                'nbcomm' => $nbcomm,
                'statorder' => $statorder,
            )));
        $response->setETag(md5($response->getContent()));

// définit l'âge max des caches privés ou des caches partagés
        $response->setMaxAge(600);

        // je retourne la vue index de mon dossier Main
        return $response;
    }
}
