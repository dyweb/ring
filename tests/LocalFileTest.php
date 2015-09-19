<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 上午11:22
 */

class LocalFileTest extends PHPUnit_Framework_TestCase
{
    private $filePath = '/home/xsf/Pictures/desktop/grass.jpg';


    public function testGetFileName()
    {
        $image = new \Dy\Ring\FileSrc\LocalFile($this->filePath);

        $fileName = $image->getFileName();

        $this->assertEquals(pathinfo($this->filePath, PATHINFO_BASENAME), $fileName);
    }


    public function testGetResource()
    {
        $image = new \Dy\Ring\FileSrc\LocalFile($this->filePath);

        try {
            $resource = $image->getResource();
        } catch (\Exception $e) {
            throw $e;
        }

        $this->assertTrue(!empty($resource));
    }
}