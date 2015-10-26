<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/26
 * Time: 下午5:49
 */

namespace Dy\Ring\Test\Backend\Data;

use GuzzleHttp\Client;

class LocalDataStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testUploadFile()
    {
        $client = new Client(array(
            'base_uri' => 'http://localhost:' . WEB_SERVER_PORT,
            'timeout' => 2.0
        ));
        $res = $client->request('POST', '/upload.php', array(
            'multipart' => array(
                array(
                    'name' => 'data',
                    'contents' => fopen('tests/images/normal.jpg', 'r')
                )
            )
        ));
        // check if the file exists
        $fileExists = file_exists('example/data/normal.jpg');
        $this->assertEquals(true, $fileExists);
    }
}