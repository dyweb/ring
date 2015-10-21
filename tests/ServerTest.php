<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午7:32
 */
class ServerTest extends PHPUnit_Framework_TestCase
{
    public function testServerRunning()
    {
        $client = new \GuzzleHttp\Client(array(
            'base_uri' => 'http://localhost:' . WEB_SERVER_PORT,
            'timeout' => 2.0
        ));
        $res = $client->get('/');
        var_dump($res->getBody()->getContents());
        $this->assertEquals(200, $res->getStatusCode());
        $resNotFound = $client->get('/showMeTheMoney');
        $this->assertEquals(404, $resNotFound->getStatusCode());
    }
}