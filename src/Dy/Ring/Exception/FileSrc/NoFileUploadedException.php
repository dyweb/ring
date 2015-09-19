<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午11:25
 */

namespace Dy\Ring\Exception\FileSrc;

class NoFileUploadedException extends \Exception
{
    public function __construct($filed)
    {
        parent::__construct('No file uploaded: "' . $filed . '"');
    }
}
