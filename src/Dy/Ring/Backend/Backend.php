<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:49
 */

namespace Dy\Ring\Backend;

use Dy\Ring\File;

abstract class Backend
{
    abstract public function setBasePath($basePath);
    abstract public function save(File $file);
}
