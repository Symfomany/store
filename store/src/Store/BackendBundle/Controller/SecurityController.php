<?php

namespace Store\BackendBundle\Controller;

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

        $session = $request->getSession();


//        $em = $this->getDoctrine()->getManager();
//        $user = $em->getRepository('StoreBackendBundle:Jeweler')->find(1);
//
//        $factory = $this->get('security.encoder_factory');
//        $encoder = $factory->getEncoder($user);
//        $password = $encoder->encodePassword('admin', $user->getSalt());
//        $user->setPassword($password);
//        $em->persist($user);
//        $em->flush();

        /**
         * On interroge le mecanisme de sécutité de Symfony 2 en session
         */
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        // je retourne la vue index de mon dossier Main
        return $this->render('StoreBackendBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }


}





