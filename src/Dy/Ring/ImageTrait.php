<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午3:42
 */

namespace Dy\Ring;

trait ImageTrait
{
    /**
     * @var int
     */
    protected $width = null;

    /**
     * @var int
     */
    protected $height = null;

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
}