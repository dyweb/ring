<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:51
 */

namespace Dy\Ring\Backend;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Dy\Ring\Exception\RuntimeException;
use Dy\Ring\BackendInterface;
use Dy\Ring\File;
use Dy\Ring\Util;

class LocalFs implements BackendInterface
{
    /**
     * @var string
     */
    private $uploadPath;

    /**
     * @var bool
     */
    private $overWrite;


    /**
     * @param $uploadPath
     * @param bool|false $overwrite
     */
    public function __construct($uploadPath, $overwrite = false)
    {
        $this->setUploadPath($uploadPath)
            ->setOverwrite($overwrite);
    }


    /**
     * @param $uploadPath
     * @return $this
     */
    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = realpath($uploadPath);

        if (!$this->uploadPath) {
            throw new InvalidArgumentException($uploadPath . ' does not exist');
        }

        if (!is_writable($this->uploadPath)) {
            throw new InvalidArgumentException($this->uploadPath . 'is not writable');
        }

        return $this;
    }


    /**
     * @param bool $bool
     * @return $this
     */
    public function setOverwrite($bool)
    {
        $this->overWrite = (bool)$bool;

        return $this;
    }


    /**
     * @param File $file
     * @return bool
     */
    public function upload(File $file)
    {
        if (!$this->overWrite) {
            $fileName = Util::fileNameNotExist($this->uploadPath, $file->getFileName(), $file->getFileExtension());
            $file->setFileName($fileName);
        }

        $fullName = rtrim($this->uploadPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $file->getBaseName();

        try {
            $file->copyTo($fullName);
        } catch (RuntimeException $e) {
            throw $e;
        }

        return true;
    }
}
