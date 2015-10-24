<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/24
 * Time: 下午4:59
 */

namespace Dy\Ring\Backend\Data;

use Dy\Ring\Exception\InvalidArgumentException;
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
        // check if base path exits and writable
        if (!is_dir($this->basePath)) {
            throw new InvalidArgumentException('base path: ' . $this->basePath . ' is not a directory!' .
                'current working dir is ' . getcwd());
        }
    }
}
