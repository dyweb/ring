<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午6:20
 */
class SourceTest extends PHPUnit_Framework_TestCase
{
    public function testSourceInterface()
    {
        $localFile = new \Dy\Ring\Source\LocalFile(__FILE__);
        $this->assertEquals("SourceTest.php", $localFile->getFileName());
        $this->assertEquals(__FILE__, $localFile->getFilePath());
        $this->assertEquals("text/x-php", $localFile->getMimeType());
    }

    public function testUploadedFileSource()
    {
        $client = new \GuzzleHttp\Client(array(
            'base_uri' => 'http://localhost:' . WEB_SERVER_PORT,
            'timeout' => 2.0
        ));
        $res = $client->request('POST', '/upload.php', array(
            'multipart' => array(
                array(
                    'name' => 'data',
                    'contents' => fopen(__DIR__ . '/images/normal.jpg', 'r')
                )
            )
        ));
        $this->assertEquals(200, $res->getStatusCode());
        $json = json_decode($res->getBody()->getContents());
        $this->assertEquals('normal.jpg', $json->file->name);
        $this->assertEquals('normal', $json->file->name_without_ext);
        $this->assertEquals('jpg', $json->file->ext);

    }
}