<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Supplier;
use Store\BackendBundle\Form\SupplierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class SupplierController
 * @package Store\BackendBundle\Controller
 */
class SupplierController extends Controller{


    /**
     * List my suppliers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $suppliers = $em->getRepository('StoreBackendBundle:Supplier')->getSupplierByUser($user);

        //paginate to bundle
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $suppliers,
            $request->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('StoreBackendBundle:Supplier:list.html.twig', array(
            "suppliers" => $pagination
        ));
    }

    /**
     * View a supplier
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){

        return $this->render('StoreBackendBundle:Supplier:view.html.twig',
            array(
                'id' => $id,
                'name' => $name
            )
        );

    }



    /**
     * Page Action
     * Je recupere l'objet Request qui contient toutes mes données en GET, POST ...
     */
    public function newAction(Request $request){

        //je créer une nouvel objet de mon entité Product
        $supplier = new Supplier();

        $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

        //je recupere un jeweler (marchand) numéro 1
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $supplier->setJeweler($jeweler); //j'associe mon jeweler 1 à mon produit

        // A chaque fois que je crée un objet d'une classe , je dois user la classe

        // je crée un formulaire de produit en associant avec mon produit
        $form = $this->createForm(new SupplierType(1),$supplier,
            array(
                'validation_groups' => 'new',
                'attr' => array(
                    'method' => 'post',
                    'novalidate' => "novalidate",
                    'action' => $this->generateUrl('store_backend_supplier_new')
                    //action de formulaire pointe vers cette même action de controlleur
                )
            ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if($form->isValid()){

            // j'upload mon fichier en faisant appel a la methode upload()
            $supplier->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($supplier); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            //je créer un message flash avec pour clef "success"
            // et un message de confirmation
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre fournisseur a bien été crée'
            );

            return $this->redirectToRoute('store_backend_supplier_list'); //redirection selon la route
        }


        return $this->render('StoreBackendBundle:Supplier:new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }




    /**
     * Edit Action
     * Je recupere l'objet Request qui contient toutes mes données en GET, POST ...
     */
    public function editAction(Request $request, Supplier $id){

        $this->permission('Supplier', $id);

        // je crée un formulaire de produit en associant avec mon produit
        $form = $this->createForm(new SupplierType(1),$id,
            array(
                'validation_groups' => 'new',
                'attr' => array(
                    'method' => 'post',
                    'novalidate' => "novalidate",
                    'action' => $this->generateUrl('store_backend_supplier_edit', array('id' => $id->getId()))
                    //action de formulaire pointe vers cette même action de controlleur
                )
            ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if($form->isValid()){

            // j'upload mon fichier en faisant appel a la methode upload()
            $id->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($id); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            //je créer un message flash avec pour clef "success"
            // et un message de confirmation
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre fournisseur a bien été modifiée'
            );

            return $this->redirectToRoute('store_backend_supplier_list'); //redirection selon la route
        }


        return $this->render('StoreBackendBundle:Supplier:edit.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }


    /**
     * Action de suppression
     * @param $id
     */
    public function removeAction($id){

        $this->permission('Supplier', $id);

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //Je récupère tous les produits de ma base de données avec la methode findAll()
        $supplier = $em->getRepository('StoreBackendBundle:Supplier')->find($id);

        $em->remove($supplier);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre fournisseur a bien été supprimé'
        );

        return $this->redirectToRoute('store_backend_supplier_list');

    }



}





