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
class CmsController extends AbstractController{


    /**
     * List my cms
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request){

        // forcer la langue
//        $request->setLocale('fr');

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $cms = $em->getRepository('StoreBackendBundle:Cms')->getCmsByUser($user);

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

        $cms = new Cms();
        $user = $this->getUser();

        //je recupere un jeweler (marchand) numéro 1
        $cms->setJeweler($user); //j'associe mon jeweler 1 à mon produit

        // je crée un formulaire de produit
        $form = $this->createForm(new CmsType($user),$cms,  array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_cms_new')
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

            // j'upload mon fichier en faisant appel a la methode upload()
            $cms->upload();

            $em->persist($cms); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('cms.flashdatas.add')
            );
            return $this->redirectToRoute('store_backend_cms_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Cms:new.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * New category page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Cms $id){

        $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

        // je crée un formulaire de produit
        $form = $this->createForm(new CmsType(1), $id,  array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_cms_edit', array('id' => $id->getId()))
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            // j'upload mon fichier en faisant appel a la methode upload()
            $id->upload();

            $em->persist($id); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('cms.flashdatas.edit')
            );
            return $this->redirectToRoute('store_backend_cms_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Cms:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }



    /**
     * Action de suppression
     * @param $id
     */
    public function activateAction(Cms $id, $action){
        $em = $this->getDoctrine()->getManager();
        $id->setActive($action);
        $em->persist($id);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('cms.flashdatas.edit')
        );

        return $this->redirectToRoute('store_backend_cms_list');
    }


    /**
     * Action de suppression
     * @param $id
     */
    public function stateAction(Cms $id, $action){
        $em = $this->getDoctrine()->getManager();
        $id->setState($action);
        $em->persist($id);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('cms.flashdatas.edit')
        );

        return $this->redirectToRoute('store_backend_cms_list');
    }


    /**
     * Action de suppression
     * @param $id
     */
    public function removeAction($id){

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //Je récupère tous les produits de ma base de données avec la methode findAll()
        $cms = $em->getRepository('StoreBackendBundle:Cms')->find($id);

        $em->remove($cms);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('cms.flashdatas.remove')
        );

        return $this->redirectToRoute('store_backend_cms_list');

    }



}





