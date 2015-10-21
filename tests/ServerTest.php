<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午7:32
 */
class ServerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    protected function setUp()
    {
        $this->client = new \GuzzleHttp\Client(array(
            'base_uri' => 'http://localhost:' . WEB_SERVER_PORT,
            'timeout' => 2.0
        ));
    }

    public function testServerRunning()
    {
        $res = $this->client->get('/');
        $this->assertEquals(200, $res->getStatusCode());

    }

    public function testServerReturn404()
    {
        try {
            $this->client->get('/abc.txt');
        } catch (GuzzleHttp\Exception\ClientException $ex) {
            $this->assertEquals(404, $ex->getResponse()->getStatusCode());
        }
    }
}