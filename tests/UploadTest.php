<?php

use Dy\Upload;

class UploadTest extends PHPUnit_Framework_TestCase
{
    protected $width = 0;
    protected $height = 0;
    protected $ratios = array();

    protected $maxSize = 0;
    protected $maxWidth = 0;
    protected $maxHeight = 0;

    protected $uploadPath = '';
    protected $textWatermark = array();
    protected $imageWatermark = array();

    protected $encryptName = true;
    protected $zoomIn = false;

    protected $errorMsg = '';

    protected $fileInfo = null;

    public function __construct($config = array()){
        $defaultConfig = array(
            'width' => 0,
            'height' => 0,
            'ratios' => array(0, 0),
            'maxWidth' => 0,
            'maxHeight' => 0,
            'maxSize' => 0,
            'zoomIn' => false,
            'encryptName' => true,
            'uploadPath' => '',
            'textWatermark' => array(
                'text' => '',
                'font' => 5,
                'anchor_x' => 0,
                'anchor_y' => 0,
                'opacity' => 50
            ),
            'imageWatermark' => array(
                'image' => '',
                'anchor_x' => 0,
                'anchor_y' => 0,
                'opacity' => 50
            ),
        );
        $config = array_merge($defaultConfig, $config);
        foreach ($config as $key => $val) {
            if (method_exists($this, 'set' . ucfirst($key))) {
                $this->{'set' . ucfirst($key)}($val);
            } else {
                $this->$key = $config[$key];
            }
        }
    }
    public function testWidth(){
        $config = array(
            'width' => 0,
            'height' => 0,
            'ratios' => array(0, 0),
            'maxWidth' => 0,
            'maxHeight' => 0,
            'maxSize' => 0,
            'zoomIn' => false,
            'encryptName' => true,
            'uploadPath' => '',
            'textWatermark' => array(
                'text' => '',
                'font' => 5,
                'anchor_x' => 0,
                'anchor_y' => 0,
                'opacity' => 50
            ),
            'imageWatermark' => array(
                'image' => '',
                'anchor_x' => 0,
                'anchor_y' => 0,
                'opacity' => 50
            ),
        );
        $upload = new Upload($config);
        $upload->setHeight(1000);
        $config['height'] = 1000;
        $newUpload = new Upload($config);
        $this->assertEquals($newUpload, $upload);

    }
}