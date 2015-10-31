<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/31
 * Time: 上午11:02
 */
namespace Dy\Test;

use Dy\Ring\UrlTrait;

class Url
{
    use UrlTrait {
        cleanPath as cleanPathOriginal;
    }

    public function cleanPath($path)
    {
        return $this->cleanPathOriginal($path);
    }
}

class UrlTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCleanPath()
    {
        // http://stackoverflow.com/questions/249664/best-practices-to-test-protected-methods-with-phpunit
        // make the protect method public for test
        // http://stackoverflow.com/questions/11939166/how-to-override-trait-function-and-call-it-from-the-overriden-function

        $url = new Url();
        $this->assertEquals('a/b', $url->cleanPath('a/b/'));
        $this->assertEquals('a/b', $url->cleanPath('a/b//'));
        // FIXME: it does not support .. and .
        // $this->assertEquals('b/c', $url->cleanPath('a/../b/c'));
    }

    public function testRelative()
    {
        $url = new Url();
        $this->assertEquals('b/c', $url->relative('/usr/share/www/b/c', '/usr/share/www'));
    }

    public function testGetUrl()
    {
        $url = new Url();
        $url->setBasePath('/usr/share/www');
        $url->setBaseUrl('http://localhost:8000');
        $this->assertEquals('http://localhost:8000/a.jpg', $url->getUrl('/usr/share/www/a.jpg'));
    }
}