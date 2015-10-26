<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/26
 * Time: 下午7:10
 */

namespace Dy\Ring\Test\Rule;


use Dy\Ring\Rule\MimeTypeRule;
use Dy\Ring\Source\LocalFile;

class MimeTypeRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyAllowedTypes()
    {
        $this->setExpectedException('Dy\Ring\Exception\InvalidArgumentException');
        $s = new LocalFile("tests/images/normal.jpg");
        $r = new MimeTypeRule(array());
        $r->check($s);
    }

    public function  testConstructor()
    {
        $s = new LocalFile("tests/images/normal.jpg");
        $r = new MimeTypeRule(array('image/jpeg'));
        $this->assertEquals(true, $r->check($s));
    }
}