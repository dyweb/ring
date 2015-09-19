<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 下午10:03
 */

namespace Dy\Ring;

class ImageRule extends Rule
{
    /**
     * the width of image after scaling
     * if $dstWidth or $dstHeight equals 0, the image will not be scaled
     * @var int
     */
    protected $dstWidth = 0;

    /**
     * the height of image after scaling
     * if $dstWidth or $dstHeight equals 0, the image will not be scaled
     * @var int
     */
    protected $dstHeight = 0;

    /**
     * interlace JPEG if possible
     * @var bool
     */
    protected $interlaceJpeg = false;

    /**
     * if make image orientation correctly
     * @var bool
     */
    protected $correctOrientation = false;


    /**
     * @param array $config
     */
    public function __construct($config = array())
    {
        if (!empty($config)) {
            foreach ($config as $key => $val) {
                if (method_exists($this, 'set' . ucfirst($key))) {
                    $this->{'set' . ucfirst($key)}($val);
                }
            }
        }
    }


    /**
     * @return bool
     */
    public function needScaling()
    {
        return ($this->dstWidth and $this->dstHeight);
    }


    /**
     * @param int $width
     * @return $this
     */
    public function setDstWidth($width)
    {
        $this->dstWidth = intval($width);

        return $this;
    }


    /**
     * @param int $height
     * @return $this
     */
    public function setDstHeight($height)
    {
        $this->dstWidth = intval($height);

        return $this;
    }


    /**
     * @param bool $bool
     * @return $this
     */
    public function setInterlaceJpeg($bool = false)
    {
        $this->interlaceJpeg = (bool)$bool;

        return $this;
    }


    /**
     * @param bool $bool
     * @return $this
     */
    public function setCorrectOrientation($bool = false)
    {
        $this->correctOrientation = (bool)$bool;

        return $this;
    }
}
