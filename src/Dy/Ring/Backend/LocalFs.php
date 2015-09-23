<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:51
 */

namespace Dy\Ring\Backend;

use Dy\Ring\Exception\DirectoryNotExistException;
use Dy\Ring\Exception\DirectoryNotWritableException;
use Dy\Ring\Exception\FileSaveFailedException;
use Dy\Ring\File;

class LocalFs extends Backend
{
    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        parent::__construct($config);
    }


    /**
     * @param $basePath
     * @return $this
     * @throws DirectoryNotExistException
     * @throws DirectoryNotWritableException
     */
    public function setBasePath($basePath)
    {
        $this->basePath = realpath($basePath);
        
        if (!$this->basePath) {
            throw new DirectoryNotExistException($basePath);
        }
        
        if (!is_writable($this->basePath)) {
            throw new DirectoryNotWritableException($this->basePath);
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
     * @throws FileSaveFailedException
     * @throws \Exception
     */
    public function save(File $file)
    {
        $fullName = rtrim($this->basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $file->getBaseName();

        if (!$this->overWrite) {
            $fileName = $file->getFileName();
            $count = 0;
            while (file_exists($fullName) and $count < 100) {
                ++$count;
                $fileName .= '(' . $count . ')';
                $fullName = rtrim($this->basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
                    $fileName . '.' . $file->getFileExtension();
            }

            if (file_exists($fullName)) {
                $fileName = $file->getFileName() . '_' . time();
                $fullName = rtrim($this->basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
                    $fileName . '.' . $file->getFileExtension();
            }

            $file->setFileName($fileName);
        }

        try {
            $result = $file->copyTo($fullName);
        } catch (\Exception $e) {
            throw $e;
        }

        if (!$result) {
            throw new FileSaveFailedException($fullName);
        }
    }
}

