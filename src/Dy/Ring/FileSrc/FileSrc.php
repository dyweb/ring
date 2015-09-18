<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午10:05
 */

namespace Dy\Ring\FileSrc;

abstract class FileSrc
{
    /**
     * get file source name
     *
     * @return string
     */
    public abstract function getFileName();

    /**
     * get file source path
     *
     * @return string
     */
    public abstract function getFilePath();


    /**
     * get file size in Bytes
     *
     * @return int
     */
    public abstract function getFileSize();


    /**
     * get file's mime type
     *
     * @return string
     */
    public abstract function getMimeType();
}