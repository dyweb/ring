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
use Dy\Ring\Util\Url;
use Dy\Ring\Meta\FileMeta;

abstract class AbstractDataStorage
{
    /**
     * @var AbstractMeta|FileMeta
     */
    protected $meta = null;

    /**
     * @var Url
     */
    protected $urlUtil = null;

    /**
     * @param Url $urlUtil
     */
    public function setUrlUtil($urlUtil)
    {
        $this->urlUtil = $urlUtil;
    }

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
