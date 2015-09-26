<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-25
 * Time: 下午1:07
 */

namespace Dy\Ring\Exception;

/**
 * Class CopyFileFailedException
 * @package Dy\Ring\Exception
 */
class CopyFileFailedException extends \Exception
{
    public function __construct($filePath)
    {
        parent::__construct('Failed to copy file: "'. $filePath . '"');
    }
}
