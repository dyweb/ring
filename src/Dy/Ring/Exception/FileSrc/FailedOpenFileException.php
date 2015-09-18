<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午11:00
 */

namespace Dy\Ring\Exception\FileSrc;

class FailedOpenFileException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct('Failed to open file: "' . $filePath . '"');
    }
}