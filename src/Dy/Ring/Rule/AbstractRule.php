<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/26
 * Time: 下午6:27
 */

namespace Dy\Ring\Rule;

use Dy\Ring\Source\AbstractSource;

abstract class AbstractRule
{
    /**
     * @param AbstractSource $source
     * @return boolean
     */
    abstract public function check(AbstractSource $source);
}
