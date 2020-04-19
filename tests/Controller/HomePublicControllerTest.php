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

    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/fr/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider websiteUrls
     */
    public function testUrls($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function websiteUrls(){
        return [
            ['/fr/about'],
        ];
    }
}