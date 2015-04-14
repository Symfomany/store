<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class ProduitController
 * @package Store\BackendBundle\Controller
 */
class ProduitController extends Controller{


    /**
     * List my product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(){

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //Je récupère tous les produits du jeweler numéro 1
        $products = $em->getRepository('StoreBackendBundle:Product')->getProductByUser(1);


        return $this->render('StoreBackendBundle:Product:list.html.twig', array(
            'products' => $products
        ));
    }



    /**
     * View a product
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name){
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
     * Page Action
     */
    public function newAction(){

        // je crée un formulaire de produit
        $form = $this->createForm(new ProductType());

        return $this->render('StoreBackendBundle:Product:new.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * Action de suppression
     * @param $id
     */
    public function removeAction($id){
        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->

        //Je récupère tous les produits de ma base de données avec la methode findAll()
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('store_backend_product_list');

    }

}





