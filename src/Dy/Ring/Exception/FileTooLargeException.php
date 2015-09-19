<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 下午11:21
 */

namespace Dy\Ring\Exception;

class FileTooLargeException extends \Exception
{
    public function __construct($size)
    {
        parent::__construct('The file is too large : ' . $size . 'B');
    }
}
