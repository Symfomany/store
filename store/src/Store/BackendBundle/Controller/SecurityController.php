<?php

namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Jeweler;
use Store\BackendBundle\Form\JewelerSubscribeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class SecurityController
 * @package Store\BackendBundle\Controller
 */
class SecurityController extends Controller{

    /**
     * Page Login
     */
    public function loginAction(Request $request){

        /**
         * On interroge le mecanisme de sécutité de Symfony 2 en session
         * Qui vérifie le bon login et le bon mot de passe en sécurité
         */
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        // je retourne la vue login de mon dossier Security
        return $this->render('StoreBackendBundle:Security:login.html.twig',
            array(
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            ));
    }


    /**
     * Suscribe a Jeweler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subscribeAction(Request $request){

        $jeweler =  new Jeweler();

        //Je crée mon formulaire d'inscription au jeweler
        $form = $this->createForm(new JewelerSubscribeType(), $jeweler, array(
            'validation_groups' => 'suscribe',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_category_new')
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine
            $password = $form['password']->getData();

            //récupérer le service d'encodage de symfony 2
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($jeweler); //recupere l'encoder de l'entité jeweler contenu dans la sécurité

            $password = $encoder->encodePassword($password, $jeweler->getSalt()); //récupérer le mot de passe
            $jeweler->setPassword($password); //modifier le mot de passe encoder avec l'encodage



            // j'ajoute le groupe à l'utilisateur
            $group = $em->getRepository('StoreBackendBundle:Groups')->find(1);
            $jeweler->addGroup($group);

            $em->persist($jeweler); //enregistrement
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre compte a bien été crée'
            );
            $this->get('session')->getFlashBag()->add(
                'info',
                'Vous pouvez vous connecter sur le back-office'
            );
            return $this->redirectToRoute('store_backend_category_list'); //redirection selon la route
        }

        return $this->render('StoreBackendBundle:Security:subscribe.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }



}





