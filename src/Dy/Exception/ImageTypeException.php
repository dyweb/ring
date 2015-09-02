<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-2
 * Time: 上午10:35
 */

namespace Dy\Exception;

class ImageTypeException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Unsupported image type');
    }
}