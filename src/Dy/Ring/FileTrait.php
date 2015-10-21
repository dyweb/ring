<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午5:58
 */

namespace Dy\Ring;


trait FileTrait
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var int
     */
    protected $fileSize;

    /**
     * @var string
     */
    protected $mimeType;
}