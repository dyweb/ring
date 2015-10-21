<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午11:19
 */

namespace Dy\Ring\Source;

use Dy\Ring\Exception\InvalidArgumentException;
use Dy\Ring\Util;

class UploadedFile extends AbstractSource
{
    /**
     * @param $field
     */
    public function __construct($field)
    {
        if (empty($_FILES[$field])) {
            throw new InvalidArgumentException($field . ': not uploaded');
        }

        $fileInfo = $_FILES[$field];

        $this->fileName = Util::filterFileName(pathinfo($fileInfo['name'], PATHINFO_BASENAME));
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
