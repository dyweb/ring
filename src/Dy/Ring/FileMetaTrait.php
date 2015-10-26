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
     * file name including extension
     *
     * @var string
     */
    protected $fileName = null;

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
     * @return string
     */
    public abstract function getFileName();

    /**
     * @return string
     */
    public abstract function getDisplayName();

    /**
     * @return string
     */
    public abstract function getFileNameWithoutExt();

    /**
     * @return string
     */
    public abstract function getFileExtension();

    /**
     * @return string
     */
    public abstract function getFilePath();

    /**
     * @return int
     */
    public abstract function getFileSize();

    /**
     * @return string
     */
    public abstract function getMimeType();

    /**
     * @TODO test
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
