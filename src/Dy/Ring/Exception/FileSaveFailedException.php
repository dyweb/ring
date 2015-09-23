<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-23
 * Time: 下午4:03
 */

namespace Dy\Ring\Exception;

/**
 * Class FileSaveFailedException
 * @package Dy\Ring\Exception
 */
class FileSaveFailedException extends \Exception
{
    public function __contruct($filePath)
    {
        parent::__construct('Failed to save file to ' . $filePath);
    }
}
