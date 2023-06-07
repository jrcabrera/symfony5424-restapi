<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainUnitTest extends WebTestCase
{
    public function test1Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls'
        );
        $this->assertEquals(401, $objClient->getResponse()->getStatusCode());
    }
    public function test2Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_Authorization' => ''
            ]
        );
        $this->assertEquals(401, $objClient->getResponse()->getStatusCode());
    }
    public function test3Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer'
            ],
            '{"url":"https://www.initiumsoft.com/servicio/desarrollo-de-software/"}'
        );
        $this->assertEquals(200, $objClient->getResponse()->getStatusCode());
    }
    public function test4Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer {}'
            ],
            '{"url":"https://www.initiumsoft.com/servicio/desarrollo-de-software/"}'
        );
        $this->assertEquals(200, $objClient->getResponse()->getStatusCode());
    }
    public function test5Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer {}[]()'
            ],
            '{"url":"https://www.initiumsoft.com/servicio/desarrollo-de-software/"}'
        );
        $this->assertEquals(200, $objClient->getResponse()->getStatusCode());
    }
    public function test6Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer {)'
            ],
            '{"url":"https://www.initiumsoft.com/servicio/desarrollo-de-software/"}'
        );
        $this->assertEquals(401, $objClient->getResponse()->getStatusCode());
    }
    public function test7Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer [{]}'
            ],
            '{"url":"https://www.initiumsoft.com/servicio/desarrollo-de-software/"}'
        );
        $this->assertEquals(401, $objClient->getResponse()->getStatusCode());
    }
    public function test8Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer {([])}'
            ],
            '{"url":"https://www.initiumsoft.com/servicio/desarrollo-de-software/"}'
        );
        $this->assertEquals(200, $objClient->getResponse()->getStatusCode());
    }
    public function test9Authorization()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer (((((((()'
            ],
            '{"url":"https://www.initiumsoft.com/servicio/desarrollo-de-software/"}'
        );
        $this->assertEquals(401, $objClient->getResponse()->getStatusCode());
    }
    public function test1Url()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer ()'
            ],
            '{}'
        );
        $response = json_decode($objClient->getResponse()->getContent(), true);
        $this->assertEquals('Url tag is required', $response['message']);
    }
    public function test2Url()
    {
        $objClient = static::createClient();
        $objClient->request(
            'POST',
            '/api/v1/short-urls',
            [],
            [],
            [
                'HTTP_CONTENT_TIPE' => 'application/json',
                'HTTP_Authorization' => 'Bearer ()'
            ],
            '{"url":"https://www.initiumsoft.com/servicio/desarrollo-de-software/"}'
        );
        $response = json_decode($objClient->getResponse()->getContent(), true);
        $this->assertEquals(true, str_contains($response['url'], 'https://tinyurl.com/'));
    }
}
