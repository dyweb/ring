<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-23
 * Time: 下午2:14
 */

namespace Dy\Ring\Exception;

/**
 * Class DirectoryNotExistException
 * @package Dy\Ring\Exception
 */
class DirectoryNotExistException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct('Directory dose not exist: "' . $filePath . '"');
    }
}
