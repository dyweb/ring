<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-7-15
 * Time: 下午5:06
 */

namespace Dy;


class Image
{
    /**
     * If the image has been saved
     *
     * @var bool
     */
    protected $saved = false;

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
     * Path to save the image
     *
     * @var string
     */
    protected $dstName = '';

    /**
     * An image identifier representing the image obtained from the given
     * filename
     *
     * @var resource
     */
    protected $resource = null;


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
     * @param   string    $newName
     * @param   int       $newWidth
     * @param   int       $newHeight
     * @return  Image
     */
    public function copy($newName, $newWidth = 0, $newHeight = 0)
    {
        $newImage = new Image($this->dstName, $newName);

        if (!$newHeight or !$newWidth) {
            $newWidth = $this->dstWidth;
            $newHeight = $this->dstHeight;
        }
        $newImage->setDstSize($newWidth, $newHeight);

        return $newImage;
    }


    /**
     * @param   string    $dstName
     * @return  Image     $this
     */
    public function setDstName($dstName)
    {
        if ($dstName and is_string($dstName)) {
            $this->dstName = $dstName;
        }
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
        $this->setDstWidth($width);
        $this->setDstHeight($height);
        return $this;
    }
}