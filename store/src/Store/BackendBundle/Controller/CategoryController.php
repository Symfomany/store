<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class CategoryController
 * @package Store\BackendBundle\Controller
 */
class CategoryController extends AbstractController{


    /**
     * List my categories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('StoreBackendBundle:Category')->getCategoryByUser(1);

        //paginate to bundle
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $categories,
            $request->query->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('StoreBackendBundle:Category:list.html.twig', array(
            'categories' => $pagination
        ));
    }

    /**
     * New category page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){
        $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

        $category = new Category();

        //je recupere un jeweler (marchand) numéro 1
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $category->setJeweler($jeweler); //j'associe mon jeweler 1 à mon produit


        // je crée un formulaire de produit
        $form = $this->createForm(new CategoryType(1),$category,  array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_category_new')
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){

            // j'upload mon fichier en faisant appel a la methode upload()
            $category->upload();


            $em->persist($category); //j'enregistre mon objet product dans doctrine
                $em->flush(); //j'envoi ma requete d'insert à ma table product

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Votre catégorie a bien été crée'
                );
                return $this->redirectToRoute('store_backend_category_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Category:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * New category page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Category $id){

        $this->permission('Category', $id);

        // je crée un formulaire de produit
        $form = $this->createForm(new CategoryType(1),$id,  array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_category_edit', array('id' => $id->getId()))
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            // j'upload mon fichier en faisant appel a la methode upload()
            $id->upload();

                $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
                $em->persist($id); //j'enregistre mon objet product dans doctrine
                $em->flush(); //j'envoi ma requete d'insert à ma table product

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Votre catégorie a bien été modifiée'
                );

                return $this->redirectToRoute('store_backend_category_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Category:edit.html.twig', array(
            'form' => $form->createView(),
            'category' => $id
        ));
    }

    /**
     * View a category
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){

        // je retourne ma vue view de Categorie où je transmet l'id en vue
        return $this->render('StoreBackendBundle:Category:view.html.twig',
            array(
                'id' => $id, // le nom de ma clefs sera le nom de ma variable en vue
                'name' => $name, // le nom de ma clefs sera le nom de ma variable en vue
            )
        );
    }



    /**
     * Action de suppression
     * @param $id
     */
    public function removeAction($id){

        $this->permission('Category', $id);

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //Je récupère tous les produits de ma base de données avec la methode findAll()
        $product = $em->getRepository('StoreBackendBundle:Category')->find($id);

        $em->remove($product);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre catégorie a bien été supprimé'
        );

        return $this->redirectToRoute('store_backend_category_list');

    }

}





