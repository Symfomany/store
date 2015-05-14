<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Tag;
use Store\BackendBundle\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class TagsController
 * @package Store\BackendBundle\Controller
 */
class TagController extends Controller{

    /**
     * Liste de mes tags
     */
    public function listAction(){

        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('StoreBackendBundle:Tag')->findAll();

        return $this->render('StoreBackendBundle:Tag:list.html.twig',
            array(
                "tags" => $tags
            )
        );
    }

    /**
     * AKout d'un tag
     */
    public function newAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $tag = new Tag();
        $form = $this->createForm(new TagType(), $tag);

        $form->handleRequest($request);

        if($form->isValid()){

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($tag); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            //je créer un message flash avec pour clef "success"
            // et un message de confirmation
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre mots-clef a bien été crée'
            );

            return $this->redirectToRoute('store_backend_tag_list');
        }

        return $this->render('StoreBackendBundle:Tag:new.html.twig',
            array(
                "form" => $form->createView()
            )
        );
    }



}





