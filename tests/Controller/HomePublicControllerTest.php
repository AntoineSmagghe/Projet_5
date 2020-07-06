<?php

namespace Test\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePublicControllerTest extends WebTestCase
{
    public function testlocalRedirect()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider websiteUrls
     */
    public function testUrls($method, $url, $parameter)
    {
        $client = static::createClient();

        $client->request($method, $url, [$parameter]);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function websiteUrls(){
        return [
            ['GET', '/fr/about', null],
            ['GET', '/fr/contact', null],
            ['GET', '/fr/legals', null],
            ['GET', '/fr/rgpd', null],
        ];
    }
}