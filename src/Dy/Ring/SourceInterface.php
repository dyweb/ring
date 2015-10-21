<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午3:51
 */

namespace Dy\Ring;

interface SourceInterface
{
    /**
     * get file source name
     *
     * @return string
     */
    public function getFileName();

    /**
     * get file source path
     *
     * @return string
     */
    public function getFilePath();


    /**
     * get file size in Bytes
     *
     * @return int
     */
    public function getFileSize();


    /**
     * get file's mime type
     *
     * @return string
     */
    public function getMimeType();
}
