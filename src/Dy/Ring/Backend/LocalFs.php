<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:51
 */

namespace Dy\Ring\Backend;

use Dy\Ring\BackendInterface;
use Dy\Ring\Exception\CopyFileFailedException;
use Dy\Ring\Exception\DirectoryNotExistException;
use Dy\Ring\Exception\DirectoryNotWritableException;
use Dy\Ring\Exception\FileSaveFailedException;
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
     * @throws DirectoryNotExistException
     * @throws DirectoryNotWritableException
     */
    public function __construct($uploadPath, $overwrite = false)
    {
        $this->setUploadPath($uploadPath)
            ->setOverwrite($overwrite);
    }


    /**
     * @param $uploadPath
     * @return $this
     * @throws DirectoryNotExistException
     * @throws DirectoryNotWritableException
     */
    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = realpath($uploadPath);
        
        if (!$this->uploadPath) {
            throw new DirectoryNotExistException($uploadPath);
        }
        
        if (!is_writable($this->uploadPath)) {
            throw new DirectoryNotWritableException($this->uploadPath);
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
     * @throws FileSaveFailedException
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
        } catch (CopyFileFailedException $e) {
            throw new FileSaveFailedException($fullName);
        }

        return true;
    }
}
