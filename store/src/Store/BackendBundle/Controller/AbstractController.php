<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Entity\Category;
use Store\BackendBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Class CategoryController
 * @package Store\BackendBundle\Controller
 */
abstract class AbstractController extends Controller{

    /**
     * Get Permission
     * @param $id
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function permission($object, $id){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $object = $em->getRepository('StoreBackendBundle:'.$object)->find($id);

        if($user->getId() != $object->getJeweler()->getId()){
            throw new AccessDeniedException("Vous n'est aps authoriser à accéder à ce contenu");
        }

    }



    /**
     * Customize Response
     * @param $route
     * @param string $message
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function response($route, $message = ""){
        if(!empty($message)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre produit a bien été crée'
            );
        }

        return $this->redirectToRoute('store_backend_product_list'); //redirection selon la route


    }

}





