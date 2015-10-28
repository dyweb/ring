<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/28
 * Time: 下午9:24
 */
namespace Dy\Ring\Test;

use Dy\Ring\Backend\LocalBackend;
use Dy\Ring\Source\LocalFile;
use Dy\Ring\Uploader;

class UploaderTest extends \PHPUnit_Framework_TestCase
{
    public function testUploader()
    {
        $local = new LocalBackend("example/data");
        $source = new LocalFile("tests/images/normal.jpg");
        $uploader = new Uploader($local, $source);
        $uploader->check();
    }
}