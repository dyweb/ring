<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午11:19
 */

namespace Dy\Ring\FileSrc;

use Dy\Ring\Exception\FileSrc\NoFileUploadedException;

class UploadedFile extends FileSrc
{
    /**
     *
     * @param  string $field
     * @throws NoFileUploadedException
     */
    public function __construct($field)
    {
        if (empty($_FILES[$field])) {
            throw new NoFileUploadedException($field);
        }

        $fileInfo = $_FILES[$field];

        $this->fileName = $fileInfo['name'];
        $this->filePath = $fileInfo['tmp_name'];
        $this->fileSize = intval($fileInfo['size']);
        $this->mimeType = $fileInfo['type'];
    }


    /**
     * @return string
     */
    public function getFileName()
    {
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
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }


    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
}