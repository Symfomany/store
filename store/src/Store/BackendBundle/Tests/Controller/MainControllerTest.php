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
        $crawler = $client->request('GET', '/administration');
        //reponse: redirection /login

        // toute la page HTML et tous les elements DOM quelle comporte
        $crawler = $client->followRedirect();


        //$crawler->filter : parcourir les noeuds d'elements HTML (DOM)
        $this->assertCount(1, $crawler->filter('html:contains("Authentification")'));
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Authentification")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Connectez-vous à votre compte")')->count());
//        $this->assertGreaterThan(1, $crawler->filter('html:contains("Keep me logged in")')->count());

    }
}
