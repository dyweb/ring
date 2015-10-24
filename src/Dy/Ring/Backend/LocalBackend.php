<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/24
 * Time: 下午5:03
 */

namespace Dy\Ring\Backend;

use Dy\Ring\Backend\Data\LocalDataStorage;
use Dy\Ring\Backend\Meta\LocalMetaStorage;

final class LocalBackend extends AbstractBackend
{
    /**
     *
     * @TODO use dependency injection
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        parent::__construct(
            new LocalDataStorage($basePath),
            new LocalMetaStorage($basePath)
        );
    }
}
