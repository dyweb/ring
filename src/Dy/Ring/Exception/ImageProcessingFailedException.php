<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-20
 * Time: 下午3:48
 */

namespace Dy\Ring\Exception;

class ImageProcessingFailedException extends \Exception
{
    public function __construct($functionName)
    {
        parent::__construct('Image processing failed: "' . $functionName . '"');
    }
}
