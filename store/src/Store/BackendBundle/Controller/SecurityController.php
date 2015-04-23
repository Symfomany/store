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
        //je crée un nouveau jeweler
        $jeweler =  new Jeweler();

        //Je crée mon formulaire d'inscription au jeweler que j'associe à mon nouveau jeweler
        $form = $this->createForm(new JewelerSubscribeType(), $jeweler, array(
            'validation_groups' => 'suscribe',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_security_subscribe')
            )
        ));

        // Je lie le formulaire à la requete
        $form->handleRequest($request);

        // je valide mon formulaire
        if($form->isValid()){

            //1. je récupere la valeur mon champ password
            $password = $form['password']->getData();

            //récupérer le service d'encodage de la sécurité de Symfony 2
            $factory = $this->get('security.encoder_factory');

            // 2. je récupere l'encoder de mon jeweler (sha512)
            $encoder = $factory->getEncoder($jeweler); //recupere l'encoder de l'entité jeweler contenu dans la sécurité

            // 3. Avec l'encoder de sécurité, j'encode mon mot de passe et j'y ajoute le salt
            $password = $encoder->encodePassword($password, $jeweler->getSalt()); //récupérer le mot de passe

            // 4. Je renseigne le mot de passe ancode de mon jeweler
            $jeweler->setPassword($password); //modifier le mot de passe encoder avec l'encodage

            $em = $this->getDoctrine()->getManager(); //je récupère le manager de Doctrine

            //5. je récupere le role ROLE_JEWELER par les ROLES
            // Je récupere le 1er groupe/role: ROLE_JEWELER
            $group = $em->getRepository('StoreBackendBundle:Groups')->find(1);

            //J'associe mon jeweler au role ROLE_JEWELER
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
            return $this->redirectToRoute('store_backend_security_login'); //redirection selon la route
        }


        return $this->render('StoreBackendBundle:Security:subscribe.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }



}





