<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/24
 * Time: 下午4:59
 */

namespace Dy\Ring\Backend\Data;

use Dy\Ring\Exception\InvalidArgumentException;
use Dy\Ring\Exception\RuntimeException;
use Dy\Ring\Meta\FileMeta;
use Dy\Ring\Source\AbstractSource;
use Dy\Ring\Source\UploadedFile;

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
        $this->basePath = rtrim($basePath, '/');
    }

    public function store(AbstractSource $source)
    {
        $this->checkDir();

        // TODO: create a dir by date, and save the source file TODO: should be able to
        // config this behaviour
        // FIXME: currently just store in the path directly
        if ($source instanceof UploadedFile) {
            $src = $source->getFilePath();
            $dst = $this->getDstPath($source);
            $moved = @move_uploaded_file($src, $dst);
            if (!$moved) {
                throw new RuntimeException('can\'t move file from ' . $src . ' to ' . $dst);
            }
        }
        // config the meta
        $this->meta = new FileMeta($source);
    }

    public function getMeta()
    {
        return $this->meta;
    }

    private function checkDir()
    {
        // check if base path exits and writable
        if (!is_dir($this->basePath)) {
            throw new InvalidArgumentException('base path: ' . $this->basePath .
                ' is not a directory or does not exist' .
                ' current working dir is ' . getcwd());
        }
        // check writable
        if (!is_writable($this->basePath)) {
            throw new InvalidArgumentException('base path: ' . $this->basePath .
                ' is not writable' .
                ' current working dir is ' . getcwd());
        }
    }

    /**
     * @TODO: allow hash file name, rolling folder by date etc
     *
     * @param AbstractSource $source
     * @return string
     */
    private function getDstPath(AbstractSource $source)
    {
        return $this->basePath . '/' . $source->getFileName();
    }
}
