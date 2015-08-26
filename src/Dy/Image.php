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
     * @var string
     */
    public $filename = '';

    /**
     * @var int
     */
    public $width = 0;

    /**
     * @var int
     */
    public $height = 0;

    /**
     * @var int
     */
    public $imageType = -1;

    /**
     * @var int
     */
    protected $dstWidth = 0;

    /**
     * @var int
     */
    protected $dstHeight = 0;

    /**
     * An image identifier representing the image obtained from the given
     * filename
     *
     * @var resource
     */
    protected $resource = null;

    /**
     * @var string
     */
    protected $errMsg = '';

    /**
     * @var bool
     */
    protected $zoomIn = true;


    /**
     * @param $filename
     * @param Resource $resource
     * @param int $width
     * @param int $height
     * @param int $imageType
     */
    public function __construct($filename, $resource, $width, $height, $imageType)
    {
        $this->filename = $filename;
        $this->resource = $resource;
        $this->width = $width;
        $this->height = $height;
        $this->imageType = $imageType;
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
     * @param   bool    $bool
     * @return  Image   $this
     */
    public function setZoomIn($bool)
    {
        $this->zoomIn = boolval($bool);
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
     * @return $this
     */
    public function resize()
    {
        if (!$this->needResize()) {
            return $this;
        }

        if (!$this->zoomIn) {
            if ($this->width < $this->dstWidth) {
                $this->dstWidth = $this->width;
            }
            if ($this->height < $this->dstHeight) {
                $this->dstHeight = $this->height;
            }
        }

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
            $this->width,
            $this->height
        );
        if ($result) {
            $this->resource = $dstResource;

        } else {
            $this->setError('Failed to resize');
            imagedestroy($dstResource);
        }

        return $this;
    }



    /**
     * Interlace JPEG if possible
     *
     * @return $this
     */
    public function interlaceJpeg()
    {
        if ($this->imageType == IMAGETYPE_JPEG) {
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
     * @return Image $this
     */
    public function correctOrientation()
    {
        $exif = @exif_read_data($this->filename, 'IDFO');
        if (isset($exif['Orientation'])) {
            $this->resource = $this->rotate($this->resource, $exif['Orientation']);
        }

        return $this;
    }


    /**
     * @param   int       $newWidth
     * @param   int       $newHeight
     * @return  Image
     */
    public function copy($newWidth = 0, $newHeight = 0)
    {
        $newImage = clone $this;
        if (!$newHeight or !$newWidth) {
            $newWidth = $this->dstWidth;
            $newHeight = $this->dstHeight;
        }

        return $newImage->setDstSize($newWidth, $newHeight);
    }


    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }


    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }


    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }


    /**
     * @return int
     */
    public function getImageType()
    {
        return $this->imageType;
    }


    /**
     * @return string
     */
    public function getError()
    {
        return $this->errMsg;
    }


    /**
     * @param   resource    $resource
     * @param   int         $orientation
     * @return  resource
     *
     * TODO: find a better way
     */
    public function rotate($resource, $orientation)
    {
        $orientation = intval($orientation);
        if (!$orientation) {
            return false;
        }
        if ($orientation == 8 or $orientation == 6) {
            $length = $this->height > $this->width ? $this->height : $this->width;
            $image = imagecreatetruecolor($length, $length);
            $result = imagecopyresampled(
                $image,
                $resource,
                0,
                0,
                0,
                0,
                $length,
                $length,
                $this->width,
                $this->height
            );
            $image = imagerotate($image, $orientation == 8 ? 90 : -90, 0);
            if ($result) {
                imagedestroy($resource);
                $resource = imagecreatetruecolor($this->height, $this->width);
                $result = imagecopyresampled(
                    $resource,
                    $image,
                    0,
                    0,
                    0,
                    0,
                    $this->height,
                    $this->width,
                    $length,
                    $length
                );
                if (!$result) {
                    return false;
                }
            }
            list($this->height, $this->width) = array($this->width, $this->height);
            return $resource;
        }

        if ($orientation == 3) {
            return imagerotate($resource, 180, 0);
        }

        return $resource;
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
     * If need to resize
     *
     * @return bool
     */
    protected function needResize()
    {
        if (!$this->dstWidth or !$this->dstHeight) {
            return false;
        }
        if ($this->width == $this->dstWidth and
            $this->height == $this->dstHeight
        ) {
            return false;
        }
        return true;
    }


    /**
     * Save the image without resizing
     *
     * @return bool
     */
    protected function saveToDst()
    {
        if ($this->imageType == IMAGETYPE_JPEG) {
            $result = @imagejpeg($this->resource, $this->dstName, 100);
        } elseif ($this->imageType == IMAGETYPE_PNG) {
            $result = @imagepng($this->resource, $this->dstName, 0);
        } else {
            $this->setError('Unsupported type');
            return false;
        }
        if (!$result) {
            $this->setError('Failed to save image to "' . $this->dstName . '"');
        }
        return $result;
    }
}