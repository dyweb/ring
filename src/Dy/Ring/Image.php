<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 下午10:02
 */

namespace Dy\Ring;

use Dy\Ring\Exception\NotSupportedException;
use Dy\Ring\Exception\OutOfBoundsException;
use Dy\Ring\Exception\RuntimeException;
use Dy\Ring\FileSrc\FileSrc;

/**
 * Class Image
 * @package Dy\Ring
 */
class Image extends File
{
    /**
     * @var ImageRule
     */
    protected $rule;

    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;


    /**
     * @param FileSrc $src
     * @param ImageRule $rule
     */
    public function __construct(FileSrc $src, ImageRule $rule)
    {
        parent::__construct($src, $rule);

        $this->resource = $this->src->getResource();
        $this->width = $this->src->getWidth();
        $this->height = $this->src->getHeight();
    }


    /**
     * @return $this
     */
    public function check()
    {
        if (!$this->isValid) {
            try {
                parent::check();
            } catch (OutOfBoundsException $e) {
                throw $e;
            }

            if (!$this->isImage()) {
                throw new NotSupportedException($this->src->getFilePath() . ' is not an image');
            }

            $this->isValid = true;
        }

        return $this;
    }


    /**
     * @return $this
     */
    public function process()
    {
        $this->check();

        if ($this->rule->needScaling()) {
            $this->scale($this->rule->getDstWidth(), $this->rule->getDstHeight());
        }

        if ($this->rule->needInterlaceJpeg()) {
            $this->interlaceJpeg();
        }

        if ($this->rule->needRotate()) {
            $this->rotate();
        }

        return $this;
    }


    /**
     * @param $dstWidth
     * @param $dstHeight
     * @return $this
     */
    public function scale($dstWidth, $dstHeight)
    {
        $this->check();

        $dstResource = imagecreatetruecolor($dstWidth, $dstHeight);
        $result = imagecopyresampled(
            $dstResource,
            $this->resource,
            0,
            0,
            0,
            0,
            $dstWidth,
            $dstHeight,
            $this->width,
            $this->height
        );
        if (!$result) {
            imagedestroy($dstResource);
            throw new RuntimeException('Failed to scale');
        }

        $this->resource = $dstResource;
        $this->width = $dstWidth;
        $this->height = $dstHeight;
        return $this;
    }


    /**
     * @return $this
     */
    public function interlaceJpeg()
    {
        $this->check();

        if ($this->src->getImageType() == IMAGETYPE_JPEG) {
            $resource = $this->resource;

            if (!function_exists('imageinterlace')) {
                throw new NotSupportedException('Need "GD" extension');
            }

            if (@imageinterlace($resource, 1)) {
                $this->resource = $resource;
            } else {
                throw new RuntimeException('Failed to interlaceJpeg');
            }
        }
        return $this;
    }


    /**
     * @return $this
     */
    public function rotate()
    {
        $this->check();

        $functions = get_extension_funcs('exif');
        if (empty($functions)) {
            throw new NotSupportedException('Need "EXIF" extension');
        }

        $functions = get_extension_funcs('gd');
        if (empty($functions)) {
            throw new NotSupportedException('Need "GD" extension');
        }

        $exif = @exif_read_data($this->src->getFilePath(), 'IDFO');

        if (isset($exif['orientation']) and ($orientation = intval($exif['orientation']))) {
            if ($orientation === 8 or $orientation === 6) {
                //turn image shape into square
                $length = $this->height > $this->width ? $this->height : $this->width;
                $image = imagecreatetruecolor($length, $length);
                $result = imagecopyresampled(
                    $image,
                    $this->resource,
                    0,
                    0,
                    0,
                    0,
                    $length,
                    $length,
                    $this->width,
                    $this->height
                );

                if ($result) {
                    //square image rotates
                    $image = imagerotate($image, $orientation == 8 ? 90 : -90, 0);

                    //restore ratio
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
                        throw new RuntimeException('Failed to rotate image');
                    }

                    imagedestroy($this->resource);
                    $this->resource = $resource;
                    list($this->height, $this->width) = array($this->width, $this->height);
                } else {
                    throw new RuntimeException('Failed to rotate image');
                }
            }

            if ($orientation === 3) {
                $this->resource = imagerotate($this->resource, 180, 0);
            }
        }

        return $this;
    }


    /**
     * @param $dst
     * @return bool
     */
    public function copyTo($dst)
    {
        $this->check();

        $imageType = $this->src->getImageType();
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $result = @imagejpeg($this->resource, $dst, 100);
                break;
            case IMAGETYPE_PNG:
                $result = @imagepng($this->resource, $dst, 0);
                break;
            case IMAGETYPE_GIF:
                $result = @imagegif($this->resource, $dst);
                break;
            default:
                throw new NotSupportedException('Unsupported image mime type');
        }

        if (!$result) {
            throw new RuntimeException('Failed to copy to : ' . $this->src->getFilePath());
        }

        return true;
    }
}
