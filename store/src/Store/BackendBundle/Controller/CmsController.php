<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Cms;
use Store\BackendBundle\Form\CmsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class CmsController
 * @package Store\BackendBundle\Controller
 */
class CmsController extends Controller{


    /**
     * List my cms
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $cms = $em->getRepository('StoreBackendBundle:Cms')->getCmsByUser(1);

        //paginate to bundle
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $cms,
            $request->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('StoreBackendBundle:Cms:list.html.twig', array(
            'cms' => $pagination
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


        return $this->render('StoreBackendBundle:Cms:view.html.twig',
            array(
                'id' => $id,
                'cms' => $cms
            )
        );

    }


    /**
     * New category page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){
        $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

        $cms = new Cms();

        //je recupere un jeweler (marchand) numéro 1
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $cms->setJeweler($jeweler); //j'associe mon jeweler 1 à mon produit

        // je crée un formulaire de produit
        $form = $this->createForm(new CmsType(1),$cms,  array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_cms_new')
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            // j'upload mon fichier en faisant appel a la methode upload()
            $cms->upload();

            $em->persist($cms); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre page cms a bien été crée'
            );
            return $this->redirectToRoute('store_backend_cms_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Cms:new.html.twig', array(
            'form' => $form->createView()
        ));
    }


}





