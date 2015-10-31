<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午5:58
 */

namespace Dy\Ring;

trait FileMetaTrait
{
    /**
     * @var string
     */
    protected $url = null;

    /**
     * file name including extension
     *
     * @var string
     */
    protected $fileName = null;

    /**
     * @var string
     */
    protected $displayName = null;

    /**
     * file name without extension
     *
     * @var string
     */
    protected $fileNameWithoutExt = null;

    /**
     * file extension
     *
     * @var string
     */
    protected $fileExtension = null;

    /**
     * @var string
     */
    protected $filePath = null;

    /**
     * @var int
     */
    protected $fileSize = null;


    /**
     * @var string
     */
    protected $mimeType = null;

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getFileNameWithoutExt()
    {
        return substr($this->getFileName(), 0, -1 - strlen($this->getFileExtension()));
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @return int
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @TODO test
     * @TODO for uploaded file, it will return tmp path, which is not safe.
     * @TODO remove it
     *
     * @return array
     */
    public function getInfo()
    {
        return array(
            'name' => $this->getFileName(),
            'display_name' => $this->getDisplayName(),
            'ext' => $this->getFileExtension(),
            'name_without_ext' => $this->getFileNameWithoutExt(),
            'path' => $this->getFilePath(),
            'size' => $this->getFileSize(),
            'mime' => $this->getMimeType()
        );
    }
}
