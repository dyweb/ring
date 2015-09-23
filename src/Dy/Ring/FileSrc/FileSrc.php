<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午10:05
 */

namespace Dy\Ring\FileSrc;

use Dy\Ring\Exception\FileSrc\FailedOpenImageException;
use Dy\Ring\Exception\FileSrc\NotImageException;
use Dy\Ring\Exception\FileSrc\UnsupportedImageTypeException;

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
     * @return null|resource
     * @throws FailedOpenImageException
     * @throws UnsupportedImageTypeException
     * @throws \Exception
     */
    public function getResource()
    {
        if ($this->isImage()) {
            if (is_null($this->resource)) {
                $this->openImage();
            }
            return $this->resource;
        }

        throw new NotImageException($this->getFilePath());
    }


    /**
     * @return int|null
     * @throws FailedOpenImageException
     * @throws UnsupportedImageTypeException
     * @throws \Exception
     */
    public function getWidth()
    {
        if ($this->isImage()) {
            if (is_null($this->width)) {
                $this->openImage();
            }
            return $this->width;
        }

        throw new NotImageException($this->getFilePath());
    }


    /**
     * @return int|null
     * @throws FailedOpenImageException
     * @throws UnsupportedImageTypeException
     * @throws \Exception
     */
    public function getHeight()
    {
        if ($this->isImage()) {
            if (is_null($this->height)) {
                $this->openImage();
            }
            return $this->height;
        }

        throw new NotImageException($this->getFilePath());
    }


    /**
     * @return int
     * @throws FailedOpenImageException
     * @throws NotImageException
     * @throws UnsupportedImageTypeException
     * @throws \Exception
     */
    public function getImageType()
    {
        if ($this->isImage()) {
            if (is_null($this->imageType)) {
                $this->openImage();
            }
            return $this->imageType;
        }

        throw new NotImageException($this->getFilePath());
    }


    /**
     * @return bool
     * @throws FailedOpenImageException
     * @throws UnsupportedImageTypeException
     * @throws \Exception
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
     * @throws FailedOpenImageException
     * @throws UnsupportedImageTypeException
     * @throws \Exception
     */
    protected function openImage()
    {
        $filePath = $this->getFilePath();

        $imageInfo = @getimagesize($filePath);

        if (!$imageInfo) {
            throw new FailedOpenImageException($filePath);
        }

        list($this->width, $this->height, $this->imageType)
            = array($imageInfo[0], $imageInfo[1], $imageInfo[2]);

        try {
            $resource = $this->createResource($filePath);
        } catch (UnsupportedImageTypeException $e) {
            throw $e;
        } catch (FailedOpenImageException $e) {
            throw $e;
        }

        $this->resource = $resource;
    }


    /**
     * @param $filePath
     * @return resource
     * @throws FailedOpenImageException
     * @throws UnsupportedImageTypeException
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
                throw new UnsupportedImageTypeException(image_type_to_mime_type($this->imageType));
        }

        if (!$resource) {
            throw new FailedOpenImageException($filePath);
        }

        return $resource;
    }


    /**
     * @param string $fileName
     * @return mixed
     */
    public static function filterFileName($fileName)
    {
        return str_replace(array('/', "\\", '-', ' '), '_', $fileName);
    }
}
