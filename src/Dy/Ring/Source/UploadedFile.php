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
            throw new InvalidArgumentException('file not uploaded as , ' . $field .
                'check if your form is uploading file with name attribute as ' . $field);
        }

        $fileInfo = $_FILES[$field];

        $this->fileName = Util::filterFileName(pathinfo($fileInfo['name'], PATHINFO_BASENAME));
        $this->filePath = $fileInfo['tmp_name'];
        $this->fileSize = intval($fileInfo['size']);
        $this->mimeType = $fileInfo['type'];
    }
}
