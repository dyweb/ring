<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/24
 * Time: 下午5:02
 */

namespace Dy\Ring\Backend\Meta;

use Dy\Ring\Source\AbstractSource;

final class LocalMetaStorage extends AbstractMetaStorage
{
    /**
     * @var string
     */
    protected $basePath;

    /**
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function store(AbstractSource $source)
    {
        // TODO: Implement store() method.
    }
}
