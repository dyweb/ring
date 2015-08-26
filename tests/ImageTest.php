<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-7-15
 * Time: 下午11:09
 */

use Dy\Image;
use Dy\StdImgIO;

class ImageTest extends PHPUnit_Framework_TestCase
{
    protected $localPng;
    protected $dstPng;
    protected $urlJpg;

    public function __construct()
    {
        $this->localPng = dirname(__DIR__) . '/ring.png';
        $this->dstPng = __DIR__ . '/images/ring.png';
        $this->dstJpg = __DIR__ . '/images/xuuea.jpg';
        $this->urlJpg = 'http://files.colabug.com/forum/201505/28/212219p3oalx9dle9xuuea.jpg';

        $this->png = StdImgIO::in($this->urlJpg);
    }

    public function testAll()
    {
        $this->png->setDstWidth(200)
            ->setDstHeight(300)
            ->resize()
            ->correctOrientation()
            ->interlaceJpeg();

        $this->assertEmpty($this->png->getError());

        StdImgIO::out($this->png, $this->dstJpg);
        $this->assertEmpty($this->png->getError());
    }


    public function testUpload()
    {
        $upload = new \Dy\Upload(array(
            'path' => __DIR__ . '/images',
            'width' => 100,
            'height' => 100,
            'zoomIn' => true,
            'overWrite' => false,
            'hashName' => true,
        ));

        $_FILES['image'] = array(
            'name' => 'name.jpg',
            'tmp_name' => $this->urlJpg,
            'size' => 1,
            'type' => 'image/jpg',
        );

        $upload->uploadImage('image');
        $this->assertEmpty($upload->getError());
    }
}