<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Store\BackendBundle\Form\JewelerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class JewelerController
 * @package Store\BackendBundle\Controller
 */
class JewelerController extends Controller{


    /**
     * My Account
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myaccountAction(Request $request){


        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $orders = $em->getRepository('StoreBackendBundle:Order')->getOrderByUser($user, 20);
        $comments = $em->getRepository('StoreBackendBundle:Comment')->getLastComments($user, 20);
        $messages = $em->getRepository('StoreBackendBundle:Message')->getLastMessagesByUser($user, 20);


        $form = $this->createForm(new JewelerType(), $user);

        $form->handleRequest($request);

        if($form->isValid()){

            $user->upload();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre profil a bien été mis à jour'
            );

            $this->redirectToRoute('store_backend_jeweler_myaccount');
        }

        return $this->render('StoreBackendBundle:Jeweler:myaccount.html.twig',
            array(
                'orders' => $orders,
                'comments' => $comments,
                'messages' => $messages,
                'form' => $form->createView()
            ));
    }





    /**
     * My parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myparametersAction(){

        return $this->render('StoreBackendBundle:Jeweler:myparameters.html.twig');
    }

    /**
     * My parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mymessagesAction(){

        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        $messages = $em->getRepository('StoreBackendBundle:Message')
            ->getLastMessagesByUser($user, 15);

        return $this->render('StoreBackendBundle:Jeweler:mymessages.html.twig', array(
            'messages' => $messages
        ));
    }

    /**
     * My picture
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mypictureAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        //récupérer l'utilisateur courant connecté
        $user = $this->getUser();

        $file = $request->files->get('file');



        $response = new JsonResponse();
        $response->setData(array(
            'data' => 123
        ));

        return $response;
    }



}





