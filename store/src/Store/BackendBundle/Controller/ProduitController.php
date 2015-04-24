<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Product;
use Store\BackendBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class ProduitController extends AbstractController{



    public function listAction(Request $request){

        //Methode numéro 1: restreindre l'accès au niveau de mon action de controlleur
//        if (false === $this->get('security.context')->isGranted('ROLE_COMMERCIAL')) {
//            throw new AccessDeniedException("Accès interdit pour ce type de contenu");
//        }

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        //Je récupère tous les produits du jeweler numéro 1
        $products = $em->getRepository('StoreBackendBundle:Product')
            ->getProductByUser($user);


        //paginate to bundle
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('StoreBackendBundle:Product:list.html.twig', array(
            'products' => $pagination
        ));
    }



    /**
     * View a product
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name)
    {
        $this->permission('Product', $id);

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //Je récupère tous les produits de ma base de données avec la methode findAll()
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);


        return $this->render('StoreBackendBundle:Product:view.html.twig',
            array(
                'product' => $product
            )
        );

    }

    /**
     * Activate a product
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activateAction(Product $id, $action){


        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        $id->setActive($action);
        $em->persist($id);
        $em->flush();

        //je créer un message flash avec pour clef "success"
        // et un message de confirmation
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre produit a bien été activé'
        );

        return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
    }



    /**
     * Cover a product
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function coverAction(Product $id, $action){

        $this->permission('Product', $id);

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        $id->setCover($action);
        $em->persist($id);
        $em->flush();

        //je créer un message flash avec pour clef "success"
        // et un message de confirmation
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre produit a bien été modifié'
        );

        return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
    }


    /**
     * Page Action
     * Je recupere l'objet Request qui contient toutes mes données en GET, POST ...
     */
    public function newAction(Request $request){

        //je créer une nouvel objet de mon entité Product
        $product = new Product();

        $user = $this->getUser();

        $product->setJeweler($user); //j'associe mon jeweler 1 à mon produit

        // je crée un formulaire de produit en associant avec mon produit
        $form = $this->createForm(new ProductType($user),$product,
            array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => "novalidate",
                'action' => $this->generateUrl('store_backend_product_new')
                //action de formulaire pointe vers cette même action de controlleur
            )
        ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if($form->isValid()){

            // j'upload mon fichier en faisant appel a la methode upload()
            $product->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($product); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            //je créer un message flash avec pour clef "success"
            // et un message de confirmation
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre produit a bien été crée'
            );

            //je récupere la quantité du produit enregistrer
            $quantity = $product->getQuantity();

            // si ma quantité de produit est < 5
            if($quantity < 5){
                // $this->get() => accède au conteneur de service
                // la methode notify sera executer avec un message de bienvenue
                $this->get('store.backend.notification')
                    ->notify('Attention, votre produit '.$product->getTitle().' est bientôt épuisé','danger');
            }

            if($quantity == 1){
                //je créer un message flash avec pour clef "success"
                // et un message de confirmation
                $this->get('session')->getFlashBag()->add(
                    'warning',
                    'Votre bijou est un produit unique !'
                );
            }



            return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
        }


        return $this->render('StoreBackendBundle:Product:new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }


    /**
     */
    public function editAction(Request $request,Product $id){

//        $this->permission('Product', $id);

        // je crée un formulaire de produit en associant avec mon produit
        $form = $this->createForm(new ProductType(1),$id,
            array(
            'validation_groups' => 'edit',
            'attr' => array(
                'method' => 'post',
                'novalidate' => "novalidate",
                'action' => $this->generateUrl('store_backend_product_edit',
                    array('id' => $id->getId()))
                //action de formulaire pointe vers cette même action de controlleur
            )
        ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if($form->isValid()){
            $id->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($id); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            // si ma quantité de produit est < 5
            if($id->getQuantity() < 5){
                // $this->get() => accède au conteneur de service
                // la methode notify sera executer avec un message de bienvenue
                $this->get('store.backend.notification')
                    ->notify('Attention, votre produit '.$id->getTitle().' est bientôt épuisé', 'danger');
            }

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre produit a bien été edité'
            );

            return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
        }


        return $this->render('StoreBackendBundle:Product:edit.html.twig',
            array(
                'form' => $form->createView(),
                'product' => $id
            )
        );
    }


    /**
     * Action de suppression
     * @param $id
     */
    public function removeAction($id){

        $this->permission('Product', $id);

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //Je récupère tous les produits de ma base de données avec la methode findAll()
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);

        $em->remove($product);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre produit a bien été supprimé'
        );

        return $this->redirectToRoute('store_backend_product_list');

    }

}





