<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 上午10:30
 */

namespace Dy\Ring\Exception\FileSrc;

class NotImageException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct("It's not an image: \"" . $filePath . '"');
    }
}
