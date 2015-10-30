<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/27
 * Time: 下午3:35
 */

namespace Dy\Ring\Test\Rule;


use Dy\Ring\Rule\SizeRule;
use Dy\Ring\Source\LocalFile;

class SizeRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testMaxSizeZero()
    {
        $this->setExpectedException('Dy\Ring\Exception\InvalidArgumentException');
        $r = new SizeRule(0);
    }

    public function testMaxSizeZeroString()
    {
        $this->setExpectedException('Dy\Ring\Exception\InvalidArgumentException');
        $r = new SizeRule('0');
    }

    public function testMaxSizeExceeded()
    {
        $this->setExpectedException('Dy\Ring\Exception\OutOfBoundsException', 'File size 11767 exceeded maxSize 100');
        $r = new SizeRule(100);
        $s = new LocalFile("tests/images/normal.jpg");
        $r->check($s);
    }

    public function testMaxSize()
    {
        $r = new SizeRule(12000);
        $s = new LocalFile("tests/images/normal.jpg");
        $r->check($s);
    }

    public function testHelperKb()
    {
        $this->assertEquals(1024, SizeRule::kb(1));
        $this->assertEquals(1024 * 1024, SizeRule::mb(1));
    }
}