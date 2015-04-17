<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Product;
use Store\BackendBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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
     * Je recupere l'objet Request qui contient toutes mes données en GET, POST ...
     */
    public function newAction(Request $request){

        //je créer une nouvel objet de mon entité Product
        $product = new Product();

        $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

        //je recupere un jeweler (marchand) numéro 1
        $jeweler = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
        $product->setJeweler($jeweler); //j'associe mon jeweler 1 à mon produit

        // A chaque fois que je crée un objet d'une classe , je dois user la classe

        // je crée un formulaire de produit en associant avec mon produit
        $form = $this->createForm(new ProductType(1),$product,
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
     * Page Action
     * Je recupere l'objet Request qui contient toutes mes données en GET, POST ...
     */
    public function editAction(Request $request,Product $id){
        $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine


        // je crée un formulaire de produit en associant avec mon produit
        $form = $this->createForm(new ProductType(1),$product,
            array(
            'validation_groups' => 'edit',
            'attr' => array(
                'method' => 'post',
                'novalidate' => "novalidate",
                'action' => $this->generateUrl('store_backend_product_edit',
                    array('id' => $id))
                //action de formulaire pointe vers cette même action de controlleur
            )
        ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($product); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
        }


        return $this->render('StoreBackendBundle:Product:edit.html.twig',
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
        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->

        //Je récupère tous les produits de ma base de données avec la methode findAll()
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('store_backend_product_list');

    }

}





