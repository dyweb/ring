<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午10:15
 */

namespace Dy\Ring\FileSrc;

use Dy\Ring\Exception\FileSrc\FailedOpenFileException;
use Dy\Ring\Exception\FileSrc\FileNotExistException;
use Dy\Ring\Exception\FileSrc\FileNotReadableException;

class LocalFile extends FileSrc
{
    /**
     * @param $filePath
     * @throws FileNotExistException
     * @throws FileNotReadableException
     */
    public function __construct($filePath)
    {
        $this->filePath = realpath($filePath);

        if (!$this->filePath) {
            throw new FileNotExistException($filePath);
        }

        if (!is_readable($this->filePath)) {
            throw new FileNotReadableException($filePath);
        }
    }


    /**
     * @return mixed|string
     */
    public function getFileName()
    {
        if (!$this->fileName) {
            $this->fileName = pathinfo($this->filePath, PATHINFO_BASENAME);
        }

        return $this->fileName;
    }


    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }


    /**
     * @return int
     * @throws FailedOpenFileException
     */
    public function getFileSize()
    {
        if (!$this->fileSize) {
            $this->fileSize = @filesize($this->filePath);
        }

        if ($this->fileSize === false) {
            throw new FailedOpenFileException($this->filePath);
        }

        return $this->fileSize;
    }


    /**
     * @return mixed|string
     * @throws FailedOpenFileException
     */
    public function getMimeType()
    {
        $info = finfo_open(FILEINFO_MIME_TYPE);

        $this->mimeType = @finfo_file($info, $this->filePath);

        if (!$this->mimeType) {
            throw new FailedOpenFileException($this->filePath);
        }

        finfo_close($info);

        return $this->mimeType;
    }
}
