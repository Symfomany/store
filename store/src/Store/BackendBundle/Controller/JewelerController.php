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
        $likes = $em->getRepository('StoreBackendBundle:Product')->getNbLikesByUser($user);
        $nborders = $em->getRepository('StoreBackendBundle:Order')->getNbOrderByUser($user, 5);
        $nbsuppliers = $em->getRepository('StoreBackendBundle:Supplier')->getCountByUser($user);

        $nbprod = $em->getRepository('StoreBackendBundle:Product')->getCountByUser($user);
        $nbcms = $em->getRepository('StoreBackendBundle:CMS')->getCountByUser($user);
        $nbcomm = $em->getRepository('StoreBackendBundle:Comment')->getCountByUser($user);



        $form = $this->createForm(new JewelerType(), $user, array(
            'validation_groups' => 'edit',
            'attr' => array('novalidate' => 'novalidate')
        ));

        $form->handleRequest($request);

        if($form->isValid()){

            $user->upload();

            $city = $form['meta']->getData()->getCity();
            $zipcode = $form['meta']->getData()->getZipcode();

            if(!empty($city)){
                $coordonates = $em->getRepository('StoreBackendBundle:Villes')
                    ->getCordonneesByCity($city);

                if(!$coordonates){
                    $coordonates = $em->getRepository('StoreBackendBundle:Villes')
                        ->getCordonneesByCity($zipcode);
                }

                if(!empty($coordonates)){
                    $user->getMeta()->setLongitude($coordonates['longitude']);
                    $user->getMeta()->setLatitude($coordonates['latitude']);
                }
            }

            $user->setDateUpdated(new \Datetime('now'));
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
                'nbprod' => $nbprod,
                'nbcms' => $nbcms,
                'nbcomm' => $nbcomm,
                'orders' => $orders,
                'comments' => $comments,
                'messages' => $messages,
                'nborders' => $nborders,
                'nbsuppliers' => $nbsuppliers,
                'likes' => $likes,
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





