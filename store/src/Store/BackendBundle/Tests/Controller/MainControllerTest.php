<?php

namespace Store\BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        //il crée un client  web HTTP
        $client = static::createClient();

        // le client crée une requete en GET sur /administration
        $crawler = $client->request('GET', '/subscribe');
        //reponse: redirection /login

        //$crawler->filter : parcourir les noeuds d'elements HTML (DOM)
        $this->assertCount(1, $crawler->filter('html:contains("Souscription de Bijoutier")'));
//        $this->assertGreaterThan(1, $crawler->filter('html:contains("Keep me logged in")')->count());

        // Fill in the form xand submit it
        $form = $crawler->selectButton('Envoyer')->form(array(
            'store_backend_jeweler_subscribe[title]'  => 'Mon titre ba bla... loool',
            'store_backend_jeweler_subscribe[email]'  => 'juju@yahoo.fr',
            'store_backend_jeweler_subscribe[username]'  => 'jujuliloumont',
            'store_backend_jeweler_subscribe[password][mdp]'  => 'testalpha120',
            'store_backend_jeweler_subscribe[password][mdp_conf]'  => 'testalpha120',
        ));
        $client->submit($form);

        exit(var_dump($client->getResponse()->getContent()));

//        $alert = $crawler->filter('html:contains(".alert-danger")');
//
////        exit(var_dump($client->getResponse()->getContent()));
//
//        //il crée un client  web HTTP
//        $client = static::createClient();
//
//        // le client crée une requete en GET sur /administration
//        $crawler = $client->request('GET', '/administration');
//        //reponse: redirection /login
//
//        // toute la page HTML et tous les elements DOM quelle comporte
//        $crawler = $client->followRedirect();
//
//
//        //$crawler->filter : parcourir les noeuds d'elements HTML (DOM)
//        $this->assertCount(1, $crawler->filter('html:contains("Authentification")'));
//        $this->assertGreaterThan(0, $crawler->filter('html:contains("Authentification")')->count());
//        $this->assertGreaterThan(0, $crawler->filter('html:contains("Connectez-vous à votre compte")')->count());
//        $this->assertGreaterThan(1, $crawler->filter('html:contains("Keep me logged in")')->count());

    }
}
