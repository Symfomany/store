<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class CategoryController
 * @package Store\BackendBundle\Controller
 */
class CategoryController extends Controller{


    /**
     * List my categories
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('StoreBackendBundle:Category')->getCategoryByUser(1);

        return $this->render('StoreBackendBundle:Category:list.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * New category page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request){

        $category = new Category();

        // je crée un formulaire de produit
        $form = $this->createForm(new CategoryType(),$category,  array(
            'attr' => array(
                'method' => 'post',
                'action' => $this->generateUrl('store_backend_category_new')
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){
                $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
                $em->persist($category); //j'enregistre mon objet product dans doctrine
                $em->flush(); //j'envoi ma requete d'insert à ma table product

                return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Category:new.html.twig', array(
            'form' => $form->createView()
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

}





