<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:44
 */

namespace Dy\Ring;

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
     * @var bool
     */
    protected $isValid = null;

    /**
     * @param FileSrc $src
     * @param Rule $rule
     * @throws FileTooLargeException
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
     * @return true
     * @throws FileTooLargeException
     */
    public function check()
    {
        if ($this->isValid) {
            return;
        }
        $srcSize = $this->src->getFileSize();
        if (!$this->rule->isValidSize($srcSize)) {
            throw new FileTooLargeException($srcSize);
        }

        $this->isValid = true;
    }


    /**
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
     * @return mixed|string
     */
    public function getFileExtension()
    {
        if (is_null($this->fileExtension)) {
            $this->fileExtension = pathinfo($this->src->getFileName(), PATHINFO_EXTENSION);
        }

        return $this->fileExtension;
    }
}
