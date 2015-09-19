<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 下午2:09
 */

namespace Dy\Ring\Exception\FileSrc;

class FileNotReadableException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct('File is not readable: "' . $filePath . '"');
    }
}
