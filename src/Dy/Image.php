<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-7-15
 * Time: 下午5:06
 */

namespace Dy;

/**
 * Class Image
 * TODO: add watermark
 *
 * @package Dy
 */
class Image
{
    /**
     * If the image has been saved
     *
     * @var bool
     */
    protected $saved = false;

    /**
     * Path to save the image
     *
     * @var string
     */
    protected $dstName = '';

    /**
     * @var int
     */
    protected $dstWidth = 0;

    /**
     * @var int
     */
    protected $dstHeight = 0;

    /**
     * Path or URL to get the image
     *
     * @var string
     */
    protected $srcName = '';

    /**
     * @var int
     */
    protected $srcWidth = 0;

    /**
     * @var int
     */
    protected $srcHeight = 0;

    /**
     * @var int
     */
    protected $srcType = -1;

    /**
     * An image identifier representing the image obtained from the given
     * filename
     *
     * @var resource
     */
    protected $resource = null;

    /**
     * @var array
     */
    protected $srcImageInfo = array();

    /**
     *
     *
     * @var string
     */
    protected $errMsg = '';


    /**
     * @param   string    $srcName
     * @param   string    $dstName
     */
    public function __construct($srcName, $dstName)
    {
        $this->srcName = $srcName;
        $this->dstName = $dstName;
    }


    /**
     * Destruction
     */
    public function __destruct()
    {
        if ($this->resource) {
            imagedestroy($this->resource);
        }
    }

    /**
     * @return $this
     */
    public function createResource()
    {
        $imageInfo = $this->getImageInfo($this->srcName);

        if (!$imageInfo) {
            $this->srcWidth = $imageInfo[0];
            $this->srcHeight = $imageInfo[1];
            $this->srcType = $imageInfo[2];

            $resource = $this->getResource($imageInfo[2]);
            if ($resource) {
                $this->resource = $resource;
            }
        }

        return $this;
    }


    /**
     * Save image to file
     *
     * @return bool
     */
    public function save()
    {
        if (!$this->resource) {
            $this->createResource();
        }
        if ($this->errMsg) {
            return false;
        }

        if ($this->needResize()) {
            if (!$this->resize()) {
                return false;
            }
        }

        if (!$this->saveToDst()) {
            return false;
        }

        $this->saved = true;
        return true;
    }


    /**
     * @param   string    $newName
     * @param   int       $newWidth
     * @param   int       $newHeight
     * @return  Image
     */
    public function copy($newName, $newWidth = 0, $newHeight = 0)
    {
        $newImage = new Image($this->dstName, $newName);

        $newImage->setResource($this->resource);

        if (!$newHeight or !$newWidth) {
            $newWidth = $this->dstWidth;
            $newHeight = $this->dstHeight;
        }
        $newImage->setDstSize($newWidth, $newHeight);

        return $newImage;
    }


    /**
     * @param   resource    $imageResource
     * @return  Image       $this
     */
    public function setResource($imageResource)
    {
        $this->resource = $imageResource;
        return $this;
    }


    /**
     * @param   int     $width
     * @return  Image   $this
     */
    public function setDstWidth($width)
    {
        $width = intval($width);
        if ($width) {
            $this->dstWidth = $width;
        }
        return $this;
    }


    /**
     * @param   int     $height
     * @return  Image   $this
     */
    public function setDstHeight($height)
    {
        $height = intval($height);
        if ($height) {
            $this->dstHeight = $height;
        }
        return $this;
    }


    /**
     * @param   int     $width
     * @param   int     $height
     * @return  Image   $this
     */
    public function setDstSize($width, $height)
    {
        $this->setDstWidth($width)->setDstHeight($height);
        return $this;
    }


    /**
     * @return string
     */
    public function getError()
    {
        return $this->errMsg;
    }


    /**
     * @param   string  $errMsg
     * @return  Image   $this
     */
    protected function setError($errMsg)
    {
        $this->errMsg = $errMsg;
        return $this;
    }


    /**
     * Interlace JPEG if possible
     *
     * @return $this
     */
    protected function interlaceJpeg()
    {
        if ($this->srcType == IMAGETYPE_JPEG) {
            $resource = $this->resource;
            if (@imageinterlace($resource, 1)) {
                $this->resource = $resource;
            } else {
                $this->setError('Interlacing failed');
            }
        }
        return $this;
    }


    /**
     * @param   int     $imageType
     * @return  bool|resource
     */
    protected function getResource($imageType)
    {
        if ($imageType == IMAGETYPE_JPEG) {
            $resource = imagecreatefromjpeg($this->srcName);
        } elseif ($imageType == IMAGETYPE_PNG) {
            $resource = imagecreatefrompng($this->srcName);
        } else {
            $this->setError('Image type not supported');
            return false;
        }


        if ($resource) {
            return $resource;
        }

        $this->setError('Unable to create image resource');
        return false;
    }


    /**
     * Get the size and mime of an image
     *
     * @param   string  $fileName
     * @return  array|bool
     */
    protected function getImageInfo($fileName)
    {
        $imageInfo = @getimagesize($fileName);
        if (!$imageInfo) {
            $this->setError('Cannot get information of "' . $fileName . '"');
            return false;
        }
        return $imageInfo;
    }


    /**
     * If need to resize
     *
     * @return bool
     */
    protected function needResize()
    {
        if (!$this->dstWidth or !$this->dstHeight) {
            return false;
        }
        if ($this->srcWidth == $this->dstWidth and
            $this->srcHeight == $this->dstHeight
        ) {
            return false;
        }

        return true;
    }


    /**
     * Resize the image
     *
     * @return bool
     */
    protected function resize()
    {
        $dstResource = imagecreatetruecolor($this->dstWidth, $this->dstHeight);

        $result = imagecopyresampled(
            $dstResource,
            $this->resource,
            0,
            0,
            0,
            0,
            $this->dstWidth,
            $this->dstHeight,
            $this->srcWidth,
            $this->srcHeight
        );
        if ($result) {
            $this->resource = $dstResource;
            imagedestroy($dstResource);
            return true;
        } else {
            $this->setError('Failed to resize');
            imagedestroy($dstResource);
            return false;
        }
    }


    /**
     * Save the image without resizing
     *
     * @return bool
     */
    protected function saveToDst()
    {
        if ($this->srcType == IMAGETYPE_JPEG) {
            $result = imagejpeg($this->resource, $this->dstName, 100);
        } elseif ($this->srcType == IMAGETYPE_PNG) {
            $result = imagepng($this->resource, $this->dstName, 100);
        } else {
            $this->setError('Image type not supported');
            return false;
        }

        if (!$result) {
            $this->setError('Failed to save to "' . $this->dstName . '"');
        }
        return $result;
    }
}
