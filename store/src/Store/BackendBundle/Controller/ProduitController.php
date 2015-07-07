<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Product;
use Store\BackendBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProduitController extends Controller
{
    public function listAction(Request $request)
    {

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        //Je récupère tous les bijous du jeweler numéro 1
        $products = $em->getRepository('StoreBackendBundle:Product')
            ->getProductByUser($user);

        return $this->render('StoreBackendBundle:Product:list.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * View a product.
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id, $name)
    {
        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        //Je récupère tous les bijous de ma base de données avec la methode findAll()
        $product = $em->getRepository('StoreBackendBundle:Product')->find($id);

        return $this->render('StoreBackendBundle:Product:view.html.twig',
            array(
                'product' => $product,
            )
        );
    }

    /**
     * Activate a product.
     *
     * @Security("is_granted('', id)")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function activateAction(Product $id, $action)
    {

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        $id->setActive($action);
        $em->persist($id);
        $em->flush();

        //je créer un message flash avec pour clef "success"
        // et un message de confirmation
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre bijou a bien été activé'
        );

        return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
    }

    /**
     * Cover a product.
     *
     * @Security("is_granted('', id)")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function coverAction(Product $id, $action)
    {

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        $id->setCover($action);
        $em->persist($id);
        $em->flush();

        //je créer un message flash avec pour clef "success"
        // et un message de confirmation
        $this->get('session')->getFlashBag()->add(
            'success',
            'Votre bijou a bien été modifié'
        );

        return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
    }

    /**
     * Page Action
     * Je recupere l'objet Request qui contient toutes mes données en GET, POST ...
     */
    public function newAction(Request $request)
    {

        //je créer une nouvel objet de mon entité Product
        $product = new Product();

        $user = $this->getUser();

        $product->setJeweler($user); //j'associe mon jeweler 1 à mon bijou

        // je crée un formulaire de bijou en associant avec mon bijou
        $form = $this->createForm(new ProductType($user), $product,
            array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_product_new'),
                //action de formulaire pointe vers cette même action de controlleur
            ),
        ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if ($form->isValid()) {

            // j'upload mon fichier en faisant appel a la methode upload()
            $product->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($product); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product

            //je créer un message flash avec pour clef "success"
            // et un message de confirmation
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre bijou a bien été crée'
            );

            //je récupere la quantité du bijou enregistrer
            $quantity = $product->getQuantity();

            if ($quantity == 1) {
                //je créer un message flash avec pour clef "success"
                // et un message de confirmation
                $this->get('session')->getFlashBag()->add(
                    'warning',
                    'Votre bijou est un bijou unique !'
                );
            }

            return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Product:new.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * is_granted
     * 1er argument : attribut à vide
     * 2eme argument Objet: bijou.
     *
     * @Security("is_granted('', id)")
     */
    public function editAction(Request $request, Product $id)
    {

        // je crée un formulaire de bijou en associant avec mon bijou
        $form = $this->createForm(new ProductType(1), $id,
            array(
            'validation_groups' => 'edit',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_product_edit',
                    array('id' => $id->getId())),
                //action de formulaire pointe vers cette même action de controlleur
            ),
        ));

        // Je fusionne ma requête  avec mon formulaire
        $form->handleRequest($request);

        // Si la totalité du formulaire est valide
        if ($form->isValid()) {
            $id->upload();

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $em->persist($id); //j'enregistre mon objet product dans doctrine
            $em->flush(); //j'envoi ma requete d'insert à ma table product


            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre bijou a bien été edité'
            );

            return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Product:edit.html.twig',
            array(
                'form' => $form->createView(),
                'product' => $id,
            )
        );
    }

    /**
     * Action de suppression.
     *
     * @Security("is_granted('', id)")
     */
    public function removeAction(Product $id)
    {

        // recupere le manager de doctrine :  Le conteneur d'objets de Doctrine
        $em = $this->getDoctrine()->getManager();

        $this->get('session')->getFlashBag()->add(
            'success',
            'Le bijou '.$id->getTitle().' a bien été supprimé'
        );

        $em->remove($id);
        $em->flush();

        return $this->redirectToRoute('store_backend_product_list');
    }
}
