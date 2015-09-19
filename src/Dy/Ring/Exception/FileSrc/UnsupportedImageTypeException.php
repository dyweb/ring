<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 上午10:52
 */

namespace Dy\Ring\Exception\FileSrc;

class UnsupportedImageTypeException extends \Exception
{
    public function __construct($mimeType)
    {
        parent::__construct('Unsupported image type: "' . $mimeType . '"');
    }
}