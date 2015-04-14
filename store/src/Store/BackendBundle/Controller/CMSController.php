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
        $em = $this->getDoctrine()->getManager();
        $cms = $em->getRepository('StoreBackendBundle:Cms')->getCmsByUser(1);

        return $this->render('StoreBackendBundle:CMS:list.html.twig', array(
            'cms' => $cms
        ));
    }

    /**
     * View a cms
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){

        $em = $this->getDoctrine()->getManager();
        $cms = $em->getRepository('StoreBackendBundle:Cms')->find(1);


        return $this->render('StoreBackendBundle:CMS:view.html.twig',
            array(
                'id' => $id,
                'cms' => $cms
            )
        );

    }

}





