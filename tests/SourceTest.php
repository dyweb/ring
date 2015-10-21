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
}