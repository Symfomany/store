<?php

// L'endroit ou je déclare ma classe MainController
namespace Store\BackendBundle\Controller;

// J'inclue la classe Controller de Symfony pour pouvoir hériter de cette classe
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class StaticsController.
 */
class StaticsController extends Controller
{
    /**
     * Pages contact.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {

        //je retourne la vue contact contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:contact.html.twig');
    }

    /**
     * Page About.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction()
    {

        //je retourne la vue contact contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:about.html.twig');
    }

    /**
     * Pages Mentions Légales.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function termsAction()
    {

        //je retourne la vue contact contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:terms.html.twig');
    }

    /**
     * Page Concept.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function conceptAction()
    {

        //je retourne la vue contact contenu dans le dossier Statics de mon bundle StoreBackendBundle
        return $this->render('StoreBackendBundle:Statics:concept.html.twig');
    }
}
