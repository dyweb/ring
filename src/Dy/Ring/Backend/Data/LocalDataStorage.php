<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/24
 * Time: 下午4:59
 */

namespace DY\Ring\Backend\Data;

use Dy\Ring\Source\AbstractSource;

final class LocalDataStorage extends AbstractDataStorage
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
