<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-20
 * Time: 下午2:55
 */

namespace Dy\Ring\Exception;

class FunctionNotExistException extends \Exception
{
    public function __construct($functionName)
    {
        parent::__construct('Function does not exist: "' . $functionName . '"');
    }
}
