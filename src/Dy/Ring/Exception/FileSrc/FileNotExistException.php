<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 下午2:07
 */

namespace Dy\Ring\Exception\FileSrc;

class FileNotExistException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct('File dose not exist: "' . $filePath . '"');
    }
}