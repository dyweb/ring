<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/26
 * Time: 下午6:16
 */

namespace Dy\Ring\Test\Source;

use Dy\Ring\Source\AbstractSource;

class Dummy extends AbstractSource
{
    public function getFileName()
    {
        return "dummy";
    }

    public function getFileNameWithoutExt()
    {
        // TODO: Implement getFileNameWithoutExt() method.
    }

    public function getFileExtension()
    {
        // TODO: Implement getFileExtension() method.
    }

    public function getFilePath()
    {
        // TODO: Implement getFilePath() method.
    }

    public function getFileSize()
    {
        // TODO: Implement getFileSize() method.
    }

    public function getMimeType()
    {
        // TODO: Implement getMimeType() method.
    }

    public function getInfo()
    {
    }

}

class AbstractSourceTest extends \PHPUnit_Framework_TestCase
{
    public function testDisplayName()
    {
        $source = new Dummy();
        $this->assertEquals($source->getFileName(), $source->getDisplayName());
    }
}