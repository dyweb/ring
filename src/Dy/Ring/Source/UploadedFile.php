<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午11:19
 */

namespace Dy\Ring\Source;

use Dy\Ring\Exception\InvalidArgumentException;
use Dy\Ring\Util\File as FileUtil;

class UploadedFile extends AbstractSource
{
    /**
     * @param $field
     */
    public function __construct($field)
    {
        if (empty($_FILES[$field])) {
            throw new InvalidArgumentException('file not uploaded as ' . $field .
                ' check if your form is uploading file with name attribute as ' . $field);
        }

        $fileInfo = $_FILES[$field];

        $this->fileName = FileUtil::filterFileName(pathinfo($fileInfo['name'], PATHINFO_BASENAME));
        $this->filePath = $fileInfo['tmp_name'];
        $this->fileSize = intval($fileInfo['size']);
        $this->mimeType = $fileInfo['type'];
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
}
