<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 上午11:22
 */

class LocalFileTest extends PHPUnit_Framework_TestCase
{
    public function testGetFileName()
    {
        $filePath = __DIR__ . '/images/test1.png';

        $image = new \Dy\Ring\FileSrc\LocalFile($filePath);

        $fileName = $image->getFileName();

        $this->assertEquals(pathinfo($filePath, PATHINFO_BASENAME), $fileName);
    }


    public function testGetResource()
    {
        $filePath = __DIR__ . '/images/test1.png';

        $image = new \Dy\Ring\FileSrc\LocalFile($filePath);

        try {
            $resource = $image->getResource();
        } catch (\Exception $e) {
            throw $e;
        }

        $this->assertTrue(!empty($resource));
    }
}