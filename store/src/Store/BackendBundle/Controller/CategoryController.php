<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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





