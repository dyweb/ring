<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/22
 * Time: 下午5:52
 */

namespace DY\Ring\Backend\Data;

use Dy\Ring\Source\AbstractSource;

abstract class AbstractDataStorage
{
    abstract public function store(AbstractSource $source);
}
