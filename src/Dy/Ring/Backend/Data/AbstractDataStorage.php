<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/22
 * Time: 下午5:52
 */

namespace DY\Ring\Backend\Data;

use Dy\Ring\Source\AbstractSource;
use Dy\Ring\Meta\AbstractMeta;

abstract class AbstractDataStorage
{
    /**
     * @var AbstractMeta
     */
    protected $meta;

    abstract public function store(AbstractSource $source);

    /**
     * @param string $path
     * @return string
     */
    abstract public function realpath($path);

    /**
     * @return AbstractMeta
     */
    abstract public function getMeta();
}
