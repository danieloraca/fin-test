<?php
declare(strict_types=1);

namespace App\Project\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PricingControllerTest extends WebTestCase
{
    public function testGetPricingOK(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/12/5250');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type', 'application/json'
        ));
    }

    public function testGetPricingParameterTypeException(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/12/aaa');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type', 'application/json'
        ));
    }

    public function testGetPricingParameterRangeException(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/1/2');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $this->assertTrue($client->getResponse()->headers->contains(
            'Content-Type', 'application/json'
        ));
    }

    public function testGetPricingParameterException(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/1000');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
