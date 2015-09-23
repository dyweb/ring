<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-23
 * Time: 下午2:14
 */

namespace Dy\Ring\Exception;

/**
 * Class DirectoryNotWritableException
 * @package Dy\Ring\Exception
 */
class DirectoryNotWritableException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct('Directory is not writable: "' . $filePath . '"');
    }
}
