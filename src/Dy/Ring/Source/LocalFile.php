<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午10:15
 */

namespace Dy\Ring\Source;

use Dy\Ring\Exception\InvalidArgumentException;
use Dy\Ring\Exception\RuntimeException;
use Dy\Ring\Util;

/**
 * Class LocalFile
 * @package Dy\Ring\Source
 */
class LocalFile extends AbstractSource
{
    /**
     * @TODO init the file name, mime when construct for better performance
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = realpath($filePath);

        if (!$this->filePath) {
            throw new InvalidArgumentException('File not exist : ' . $filePath);
        }

        // TODO: add test
        if (!is_readable($this->filePath)) {
            throw new InvalidArgumentException('File not readable : ' . $filePath);
        }
    }

    /**
     * @return mixed|string
     */
    public function getFileName()
    {
        if (!$this->fileName) {
            $this->fileName = pathinfo($this->filePath, PATHINFO_BASENAME);
            $this->fileName = Util::filterFileName($this->fileName);
        }

        return $this->fileName;
    }

    /**
     * @TODO: use pathinfo
     *
     * @return string
     */
    public function getFileNameWithoutExt()
    {
        return substr($this->getFileName(), 0, -1 - strlen($this->getFileExtension()));
    }

    /**
     * @see http://stackoverflow.com/questions/173868/how-to-extract-a-file-extension-in-php
     *
     * @return string
     */
    public function getFileExtension()
    {
        // TODO: handle file without ext
        $extWithDot = strrchr($this->getFileName(), '.');
        if ($extWithDot) {
            return substr($extWithDot, 1);
        }
        return '';
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @return int
     */
    public function getFileSize()
    {
        if (!$this->fileSize) {
            $this->fileSize = @filesize($this->filePath);
        }

        if ($this->fileSize === false) {
            throw new RuntimeException('Failed to open file : ' . $this->filePath);
        }

        return $this->fileSize;
    }


    /**
     * @return mixed
     */
    public function getMimeType()
    {
        $info = finfo_open(FILEINFO_MIME_TYPE);

        $this->mimeType = @finfo_file($info, $this->filePath);

        if (!$this->mimeType) {
            throw new RuntimeException('Failed to open file : ' . $this->filePath);
        }

        finfo_close($info);

        return $this->mimeType;
    }
}
