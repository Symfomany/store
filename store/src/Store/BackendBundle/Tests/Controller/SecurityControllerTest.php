<?php

namespace Store\BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    public function testSubscribe()
    {
        //il crée un client  web HTTP
        $client = static::createClient();

        // le client crée une requete en GET sur /administration
        $crawler = $client->request('GET', '/subscribe');
        //reponse: redirection /login

        //$crawler->filter : parcourir les noeuds d'elements HTML (DOM)
        $this->assertCount(1, $crawler->filter('html:contains("Souscription de Bijoutier")'));
//        $this->assertGreaterThan(1, $crawler->filter('html:contains("Keep me logged in")')->count());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Envoyer')->form(array(
            'store_backend_jeweler_subscribe[title]'  => 'Mon titre',
            'store_backend_jeweler_subscribe[email]'  => 'juju@yahoo.fr',
            'store_backend_jeweler_subscribe[username]'  => 'jujulilou',
            'store_backend_jeweler_subscribe[password][mdp]'  => 'testalpha',
            'store_backend_jeweler_subscribe[password][mdp_conf]'  => 'testalpha',
            // ... other fields to fill
        ));
        $client->submit($form);
        //        $crawler = $client->followRedirect();

//        $this->assertGreaterThan(0, $crawler->filter('html:contains("Votre email est déjà existant")')->count());

//        $crawler = $client->followRedirect();
//
//        $this->assertCount(1, $crawler->filter('html:contains("Authentification")'));

    }
}
