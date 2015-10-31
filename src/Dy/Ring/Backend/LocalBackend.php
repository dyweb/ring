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
use Dy\Ring\Util\Url;

final class LocalBackend extends AbstractBackend
{
    /**
     *
     * @TODO use dependency injection
     * @param string $basePath
     * @param string $baseUrl
     */
    public function __construct($basePath, $baseUrl)
    {
        $d = new LocalDataStorage($basePath);
        $d->setUrlUtil(new Url($basePath, $baseUrl));
        parent::__construct(
            $d,
            new LocalMetaStorage($basePath)
        );
    }
}
