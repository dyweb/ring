<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/22
 * Time: 下午5:52
 */

namespace Dy\Ring\Backend\Meta;

use Dy\Ring\Source\AbstractSource;

abstract class AbstractMetaStorage
{
    abstract public function store(AbstractSource $source);
}
