<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Slider;
use Store\BackendBundle\Form\SliderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SliderController.
 */
class SliderController extends Controller
{
    /**
     * List my categories.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $slides = $em->getRepository('StoreBackendBundle:Slider')->getSlidesByUser($user);

        //paginate to bundle
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $slides,
            $request->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('StoreBackendBundle:Slider:list.html.twig', array(
            'slides' => $pagination,
        ));
    }

    /**
     * Page Action
     * Je recupere l'objet Request qui contient toutes mes données en GET, POST ...
     */
    public function newAction(Request $request)
    {

        //je créer une nouvel objet de mon entité Product
        $slider = new Slider();

        // je crée un formulaire de produit en associant avec mon produit
        $form = $this->createForm(new SliderType(1), $slider,
            array(
                'validation_groups' => 'new',
                'attr' => array(
                    'method' => 'post',
                    'novalidate' => 'novalidate',
                    'action' => $this->generateUrl('store_backend_slider_new'),
                    //action de formulaire pointe vers cette même action de controlleur
                ),
            ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if ($form->isValid()) {

            // j'upload mon fichier en faisant appel a la methode upload()
            $slider->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($slider); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            //je créer un message flash avec pour clef "success"
            // et un message de confirmation
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre slide a bien été crée'
            );

            return $this->redirectToRoute('store_backend_slider_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Slider:new.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Edit Action
     * Je recupere l'objet Request qui contient toutes mes données en GET, POST ...
     */
    public function editAction(Request $request, Slider $id)
    {
        $this->permission('Slider', $id, true);

        // je crée un formulaire de produit en associant avec mon produit
        $form = $this->createForm(new SliderType(1), $id,
            array(
                'validation_groups' => 'edit',
                'attr' => array(
                    'method' => 'post',
                    'novalidate' => 'novalidate',
                    'action' => $this->generateUrl('store_backend_slider_edit', array('id' => $id->getId())),
                    //action de formulaire pointe vers cette même action de controlleur
                ),
            ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if ($form->isValid()) {

            // j'upload mon fichier en faisant appel a la methode upload()
            $id->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($id); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            //je créer un message flash avec pour clef "success"
            // et un message de confirmation
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre slide a bien été modifiée'
            );

            return $this->redirectToRoute('store_backend_slider_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Slider:edit.html.twig',
            array(
                'form' => $form->createView(),
                'slide' => $id,
            )
        );
    }

    /**
     * Action de suppression.
     *
     * @param $id
     */
    public function removeAction($id)
    {
        $this->permission('Slider', $id, true);

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //Je récupère tous les produits de ma base de données avec la methode findAll()
        $slide = $em->getRepository('StoreBackendBundle:Slider')->find($id);

        $em->remove($slide);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre slide a bien été supprimé'
        );

        return $this->redirectToRoute('store_backend_slider_list');
    }
}
