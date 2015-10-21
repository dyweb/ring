<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午10:05
 */

namespace Dy\Ring\Source;

use Dy\Ring\FileTrait;
use Dy\Ring\SourceInterface;

abstract class AbstractSource implements SourceInterface
{
    use FileTrait
}
