<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-24
 * Time: 下午6:47
 */

class FileTest extends  PHPUnit_Framework_TestCase
{
    public function testCheck()
    {
        $rule = new \Dy\Ring\Rule();
        $fileSrc = new \Dy\Ring\FileSrc\LocalFile(__DIR__ . '/images/notImage.bin');

        $file = new \Dy\Ring\File($fileSrc, $rule);
        try {
            $result = $file->check();
        } catch (Exception $e) {
            $this->assertEquals('Here should not throw and exceptions', $e->getMessage());
        }
        if (isset($result)) {
            $this->assertTrue($result instanceof \Dy\Ring\File);
            unset($result);
        }

        $rule->setMaxSize(1);
        $file = new \Dy\Ring\File($fileSrc, $rule);
        try {
            $result = $file->check();
        } catch (\Dy\Ring\Exception\FileTooLargeException $e) {
            $this->assertTrue(true);
        }
        if (isset($result)) {
            $this->assertEquals('Here show throw an FileTooLargeException', 'Nothing found');
        }
    }


    public function testGetFileName()
    {
        $fileSrc = new \Dy\Ring\FileSrc\LocalFile(__DIR__ . '/images/notImage.bin');

        $rule = new \Dy\Ring\Rule(array('hashName' => false));

        $file = new \Dy\Ring\File($fileSrc, $rule);

        $fileName = $file->getFileName();
        $this->assertEquals('notImage', $fileName);
    }


    public function testGetFileExtension()
    {
        $fileSrc = new \Dy\Ring\FileSrc\LocalFile(__DIR__ . '/images/notImage.bin');

        $rule = new \Dy\Ring\Rule();

        $file = new \Dy\Ring\File($fileSrc, $rule);

        $fileExtension = $file->getFileExtension();
        $this->assertEquals('bin', $fileExtension);
    }
}