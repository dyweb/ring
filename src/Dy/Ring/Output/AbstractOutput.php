<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/30
 * Time: 上午11:09
 */

namespace Dy\Ring\Output;

abstract class AbstractOutput implements \JsonSerializable
{
    abstract public function getUrl();
}
