<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/24
 * Time: 下午4:29
 */

namespace Dy\Ring\Backend\Meta;

use Dy\Ring\Exception\NotSupportedException;
use Dy\Ring\Meta\AbstractMeta;
use Dy\Ring\Source\AbstractSource;

/**
 * Class NullMetaStorage
 *
 * A null storage, stores nothing
 *
 * @package Dy\Ring\Backend\Meta
 */
final class NullMetaStorage extends AbstractMetaStorage
{
    public function store(AbstractMeta $meta)
    {
        throw new NotSupportedException('null storage always support nothing ');
    }
}
