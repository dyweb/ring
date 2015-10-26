<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/26
 * Time: 下午7:03
 */

namespace Dy\Ring\Test\Rule;

use Dy\Ring\Rule\AbstractRule;
use Dy\Ring\Source\AbstractSource;
use Dy\Ring\Source\LocalFile;

class DummyRule extends AbstractRule
{
    public function check(AbstractSource $source)
    {
        return true;
    }
}

class AbstractRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testPass()
    {
        $r = new DummyRule();
        $this->assertEquals(true, $r->check(new LocalFile("tests/images/normal.jpg")));
    }
}