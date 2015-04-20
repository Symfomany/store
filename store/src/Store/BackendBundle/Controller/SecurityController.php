<?php

namespace Store\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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
         */
//        $session = $request->getSession();
//
//        // get the login error if there is one
//        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
//            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
//        } else {
//            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
//            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
//        }

        // je retourne la vue login de mon dossier Security
        return $this->render('StoreBackendBundle:Security:login.html.twig');
    }


}





