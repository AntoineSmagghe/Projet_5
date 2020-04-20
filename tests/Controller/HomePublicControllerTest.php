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
    public function testUrls($url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function websiteUrls(){
        return [
            ['/fr'],
            ['/fr/about'],
            ['/fr/contact'],
            ['/fr/legals'],
            ['/fr/rgpd'],
            ['/fr/article/{format}'],
            ['/fr/article/releases'],
            ['/fr/article/public-event'],
            ['/fr/article/private-event'],
        ];
    }
}