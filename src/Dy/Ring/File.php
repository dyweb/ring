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
     * @var string
     */
    protected $fileName = null;

    /**
     * @var string
     */
    protected $fileExtension = null;

    /**
     * @param FileSrc $src
     * @param Rule $rule
     * @throws FileTooLargeException
     */
    public function __construct(FileSrc $src, Rule $rule)
    {
        $this->src = $src;
        $this->rule = $rule;

        $this->check();
    }


    /**
     * TODO: MIME check
     *
     * @throws FileTooLargeException
     */
    public function check()
    {
        $srcSize = $this->src->getFileSize();
        if (!$this->rule->isValidSize($srcSize)) {
            throw new FileTooLargeException($srcSize);
        }
    }


    public function process()
    {
        $this->fileName = $this->rule->makeFileName($this->getFileName());

        $this->getFileExtension();
    }


    /**
     * @return mixed|string
     */
    public function getFileName()
    {
        if (is_null($this->fileName)) {
            $this->fileName = pathinfo($this->src->getFileName(), PATHINFO_FILENAME);
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
