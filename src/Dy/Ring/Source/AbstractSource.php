<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午10:05
 */

namespace Dy\Ring\Source;

use Dy\Ring\FileMetaTrait;

abstract class AbstractSource
{
    use FileMetaTrait;

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->getFileName();
    }
}
