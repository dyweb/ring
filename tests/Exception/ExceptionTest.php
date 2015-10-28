<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/28
 * Time: 下午11:28
 */

namespace Dy\Ring\Test\Exception;


use Dy\Ring\Exception\InvalidArgumentException;
use Dy\Ring\Exception\ExceptionInterface;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCatchByInterface()
    {
        try{
            throw new InvalidArgumentException("xsfour is a cat");
        }catch (ExceptionInterface $e){

        }
    }
}