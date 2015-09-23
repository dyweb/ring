<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 上午10:38
 */

namespace Dy\Ring\Exception\FileSrc;

class FailedOpenImageException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct('Failed to open image: "' . $filePath . '"');
    }
}
