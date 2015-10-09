<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午10:05
 */

namespace Dy\Ring\FileSrc;

use Dy\Ring\Exception\NotSupportedException;
use Dy\Ring\Exception\RuntimeException;

abstract class FileSrc
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

    /**
     * @var resource
     */
    protected $resource = null;

    /**
     * @var int
     */
    protected $width = null;

    /**
     * @var int
     */
    protected $height = null;

    /**
     * @var bool
     */
    protected $isImage = null;

    /**
     * @var int
     */
    protected $imageType = null;


    /**
     * get file source name
     *
     * @return string
     */
    abstract public function getFileName();

    /**
     * get file source path
     *
     * @return string
     */
    abstract public function getFilePath();


    /**
     * get file size in Bytes
     *
     * @return int
     */
    abstract public function getFileSize();


    /**
     * get file's mime type
     *
     * @return string
     */
    abstract public function getMimeType();


    /**
     * @return resource
     */
    public function getResource()
    {
        if ($this->isImage()) {
            if (is_null($this->resource)) {
                $this->openImage();
            }
            return $this->resource;
        }

        throw new NotSupportedException($this->getFilePath() . ' is not an image');
    }


    /**
     * @return int
     */
    public function getWidth()
    {
        if ($this->isImage()) {
            if (is_null($this->width)) {
                $this->openImage();
            }
            return $this->width;
        }

        throw new NotSupportedException($this->getFilePath() . ' is not an image');
    }


    /**
     * @return int
     */
    public function getHeight()
    {
        if ($this->isImage()) {
            if (is_null($this->height)) {
                $this->openImage();
            }
            return $this->height;
        }

        throw new NotSupportedException($this->getFilePath() . ' is not an image');
    }


    /**
     * @return int
     */
    public function getImageType()
    {
        if ($this->isImage()) {
            if (is_null($this->imageType)) {
                $this->openImage();
            }
            return $this->imageType;
        }

        throw new NotSupportedException($this->getFilePath() . ' is not an image');
    }


    /**
     * @return bool
     */
    public function isImage()
    {
        if (is_null($this->isImage)) {
            if (strpos($this->getMimeType(), 'image') === false) {
                $this->isImage = false;
            } else {
                $this->isImage = true;
            }
        }

        return $this->isImage;
    }


    /**
     *
     */
    protected function openImage()
    {
        $filePath = $this->getFilePath();

        $imageInfo = @getimagesize($filePath);

        if (!$imageInfo) {
            throw new RuntimeException('Failed to open file image ' . $filePath);
        }

        list($this->width, $this->height, $this->imageType)
            = array($imageInfo[0], $imageInfo[1], $imageInfo[2]);

        try {
            $resource = $this->createResource($filePath);
        } catch (NotSupportedException $e) {
            throw $e;
        } catch (RuntimeException $e) {
            throw $e;
        }

        $this->resource = $resource;
    }


    /**
     * @param $filePath
     * @return resource
     *
     * @throws NotSupportedException
     * @throws RuntimeException
     */
    protected function createResource($filePath)
    {
        switch ($this->imageType) {
            case IMAGETYPE_JPEG:
                $resource = @imagecreatefromjpeg($filePath);
                break;
            case IMAGETYPE_PNG:
                $resource = @imagecreatefrompng($filePath);
                break;
            case IMAGETYPE_GIF:
                $resource = @imagecreatefromgif($filePath);
                break;
            default:
                throw new NotSupportedException('Unsupported image mime type : ' . image_type_to_mime_type($this->imageType));
        }

        if (!$resource) {
            throw new RuntimeException('Failed to open file : ' . $filePath);
        }

        return $resource;
    }
}
