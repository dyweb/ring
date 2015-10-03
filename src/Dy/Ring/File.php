<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:44
 */

namespace Dy\Ring;

use Dy\Ring\Exception\CopyFileFailedException;
use Dy\Ring\Exception\FileTooLargeException;
use Dy\Ring\FileSrc\FileSrc;

/**
 * Class File
 * @package Dy\Ring
 */
class File
{
    /**
     * @var FileSrc
     */
    protected $src;

    /**
     * @var Rule
     */
    protected $rule;

    /**
     * filename without extension
     *
     * @var string
     */
    protected $fileName = null;

    /**
     * file extension
     *
     * @var string
     */
    protected $fileExtension = null;

    /**
     * @var string
     */
    protected $baseName = null;

    /**
     * @var bool
     */
    protected $isValid = null;

    /**
     * @param FileSrc $src
     * @param Rule $rule
     */
    public function __construct(FileSrc $src, Rule $rule)
    {
        $this->src = $src;
        $this->rule = $rule;

        $this->getFileName();
        $this->getFileExtension();
    }


    /**
     * TODO: MIME check
     *
     * @return $this
     * @throws FileTooLargeException
     */
    public function check()
    {
        if (!$this->isValid) {
            $srcSize = $this->src->getFileSize();
            if (!$this->rule->isValidSize($srcSize)) {
                throw new FileTooLargeException($srcSize);
            }

            $this->isValid = true;
        }

        return $this;
    }


    /**
     * file name without extension
     *
     * @return string
     */
    public function getFileName()
    {
        if (is_null($this->fileName)) {
            $this->fileName = $this->rule->makeFileName(pathinfo($this->src->getFileName(), PATHINFO_FILENAME));
        }

        return $this->fileName;
    }


    /**
     * @param string $fileName
     * @return $this
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        if (!is_null($this->baseName)) {
            $this->baseName = $this->fileName . '.' . $this->fileExtension;
        }

        return $this;
    }


    /**
     * file extension
     *
     * @return string
     */
    public function getFileExtension()
    {
        if (is_null($this->fileExtension)) {
            $this->fileExtension = pathinfo($this->src->getFileName(), PATHINFO_EXTENSION);
        }

        return $this->fileExtension;
    }


    /**
     * file name with extension
     *
     * @return string
     */
    public function getBaseName()
    {
        if (is_null($this->baseName)) {
            $this->baseName = $this->fileName . '.' . $this->fileExtension;
        }

        return $this->baseName;
    }


    /**
     * @return bool
     */
    public function isImage()
    {
        return $this->src->isImage();
    }


    /**
     * @param $dst
     * @return bool
     * @throws CopyFileFailedException
     * @throws FileTooLargeException
     */
    public function copyTo($dst)
    {
        $this->check();

        $result = @copy($this->src->getFilePath(), $dst);

        if (!$result) {
            throw new CopyFileFailedException($this->src->getFilePath());
        }

        return true;
    }
}
