<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-19
 * Time: 上午9:44
 */

namespace Dy\Ring\FileSrc;


interface ImageSrc
{
    public function getResource();

    public function getWidth();

    public function getHeight();
}