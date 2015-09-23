<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 上午11:22
 */

require_once('TestFiles.php');

use Dy\Ring\FileSrc\LocalFile as File;

class LocalFileTest extends PHPUnit_Framework_TestCase
{
    private $files = array();

    private $filePaths = array();


    public function __construct()
    {
        $filePaths = TestFiles::get();
        foreach ($filePaths as $filePath) {
            try {
                $file = new File($filePath);
            } catch (\Dy\Ring\Exception\FileSrc\FileNotExistException $e) {
                continue;
            } catch (\Dy\Ring\Exception\FileSrc\FileNotReadableException $e) {
                continue;
            }

            $this->files[] = $file;
            $this->filePaths[] = $filePath;
        }
    }


    public function testConstruct()
    {
        $this->files = array();
        $this->filePaths = array();

        $filePaths = TestFiles::get();
        foreach ($filePaths as $filePath) {
            try {
                $file = new File($filePath);
            } catch (\Dy\Ring\Exception\FileSrc\FileNotExistException $e) {
                $this->assertEquals('notExist', str_replace(IMAGE_DIR, '', $filePath));
                continue;
            } catch (\Dy\Ring\Exception\FileSrc\FileNotReadableException $e) {
                $this->assertEquals('notReadable', str_replace(IMAGE_DIR, '', $filePath));
                continue;
            }

            $this->assertTrue($file instanceof File);

            $this->files[] = $file;
            $this->filePaths[] = $filePath;
        }
    }


    public function testGetFilePath()
    {
        foreach (range(0, count($this->files) - 1) as $i) {
            $this->assertEquals($this->filePaths[$i], $this->files[$i]->getFilePath());
        }
    }


    public function testGetFileName()
    {
        foreach (range(0, count($this->files) - 1) as $i) {
            $this->assertEquals(
                \Dy\Ring\FileSrc\FileSrc::filterFileName(pathinfo($this->filePaths[$i], PATHINFO_BASENAME)),
                $this->files[$i]->getFileName()
            );
        }
    }


    public function testGetFileSize()
    {
        foreach (range(0, count($this->files) - 1) as $i) {
            $this->assertEquals(
                filesize($this->filePaths[$i]),
                $this->files[$i]->getFileSize()
            );
        }
    }


    public function testGetMimeType()
    {
        foreach (range(0, count($this->files) - 1) as $i) {
            $this->assertEquals(
                $this->getMimeType($this->filePaths[$i]),
                $this->files[$i]->getMimeType()
            );
        }
    }


    public function testIsImage()
    {
        foreach (range(0, count($this->files) - 1) as $i) {
            if (strpos($this->filePaths[$i], 'normal') !== false
                or strpos($this->filePaths[$i], 'notOpenImage') !== false) {
                $isImage = true;
            } else {
                $isImage = false;
            }
            $this->assertEquals(
                $isImage,
                $this->files[$i]->isImage()
            );
        }
    }


    public function testGetResource()
    {
        foreach (range(0, count($this->files) - 1) as $i) {
            try {
                $resource = $this->files[$i]->getResource();
            } catch (\Dy\Ring\Exception\FileSrc\UnsupportedImageTypeException $e) {
                $this->assertFalse(
                    strpos($this->filePaths[$i], 'unsupportedImage') === false
                );
                continue;
            } catch (\Dy\Ring\Exception\FileSrc\NotImageException $e) {
                $this->assertFalse(
                    strpos($this->filePaths[$i], 'notImage') === false
                );
                continue;
            } catch (\Dy\Ring\Exception\FileSrc\FailedOpenImageException $e) {
                $this->assertFalse(
                    strpos($this->filePaths[$i], 'notOpenImage') === false
                );
                continue;
            }

            $this->assertTrue(is_resource($resource));
        }
    }


    private function getMimeType($filePath)
    {
        $info = finfo_open(FILEINFO_MIME_TYPE);

        $mimeType = @finfo_file($info, $filePath);

        finfo_close($info);

        return $mimeType;
    }
}