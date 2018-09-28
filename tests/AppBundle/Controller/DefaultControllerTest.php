<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Actualite;
use AppBundle\Entity\Commentaire;
use AppBundle\Form\ActualiteType;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexWithoutLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function login($client){

    	
	    $crawler = $client->request('GET', '/login');
	    $buttonCrawlerNode = $crawler->selectButton('_submit');
	    $form = $buttonCrawlerNode->form();
	    $data = array('_username' => 'adminab','_password' => 'Darkness');
	    $client->submit($form,$data);

	    $crawler = $client->followRedirect();
	    $crawler = $client->request('GET', '/');
    }

    public function testLogin()
	{
		$client = static::createClient();
	    $this->login($client);
	    $this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

    public function testCreateActus(){

    	$client = static::createClient();
    	$this->login($client);
    	$container = $client->getContainer();
    	$em = $container->get('doctrine')->getManager();

    	$actu1 = new Actualite();
    	$actu1->setTitle('La victoire des bleus');
    	$actu1->setCreatedBy('Didier Deschamps');
    	$actu1->setDescription('<p>On est les champions...</p>');
    	$actu1->createPost($em,$actu1);

    	$crawler = $client->request('GET', '/');
    	$response = $client->getResponse();
    	$responseContent = $response->getContent();

    	$this->assertContains($actu1->getTitle(),$responseContent);

    }

    public function testCreateCommentairesForActu(){
    	$client = static::createClient();
    	$this->login($client);
    	$container = $client->getContainer();
    	$em = $container->get('doctrine')->getManager();

    	$commentaire = new Commentaire();
    	$actu = $em->getRepository('AppBundle:Actualite')->findOneById(1);
    	$commentaire->setCreatedBy('Jack');
    	$commentaire->setMessage('<p>Je suis le maître du monde !!</p>');
    	$commentaire->createPost($em,$commentaire,$actu);

    	$crawler = $client->request('GET', '/actualite/1');
    	$response = $client->getResponse();
    	$responseContent = $response->getContent();

    	$this->assertContains($commentaire->getCreatedBy(),$responseContent);
    	$this->assertContains($commentaire->getMessage(),$responseContent);
    }
}
