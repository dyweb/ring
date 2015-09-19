<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 下午10:02
 */

namespace Dy\Ring;

use Dy\Ring\Exception\FileSrc\NotImageException;
use Dy\Ring\Exception\FileTooLargeException;
use Dy\Ring\FileSrc\FileSrc;

class Image extends File
{
    /**
     * @param FileSrc $src
     * @param ImageRule $rule
     * @throws FileTooLargeException
     * @throws NotImageException
     */
    public function __construct(FileSrc $src, ImageRule $rule)
    {
        parent::__construct($src, $rule);

        $this->check();
    }


    /**
     * @throws FileTooLargeException
     * @throws NotImageException
     * @throws \Exception
     */
    public function check()
    {
        try {
            parent::check();
        } catch (FileTooLargeException $e) {
            throw $e;
        }

        if (!$this->src->isImage()) {
            throw new NotImageException($this->src->getFilePath());
        }
    }


    public function process()
    {

    }
}
