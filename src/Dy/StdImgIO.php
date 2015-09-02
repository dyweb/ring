<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-7-16
 * Time: 下午7:43
 */

namespace Dy;

use Dy\Exception\ImageTypeException;
use Dy\Exception\StdImgIOException;

class StdImgIO
{
    /**
     * @param $fileName
     * @return Image
     * @throws StdImgIOException
     */
    public static function in($fileName)
    {
        $fileName = self::confirmSrcFile($fileName);
        return self::newImage($fileName);
    }


    /**
     * @param Image $img
     * @param $dstName
     * @param bool $overWrite
     * @return bool
     * @throws StdImgIOException
     * @throws ImageTypeException
     */
    public static function out(Image $img, $dstName, $overWrite = true)
    {
        $dstName = self::confirmDstFile($dstName);

        if (!$overWrite and file_exists($dstName)) {
            throw new StdImgIOException('"' . $dstName .'" exists');
        }

        $imageType = $img->getImageType();
        $resource = $img->getResource();

        if ($imageType == IMAGETYPE_JPEG) {
            $result = @imagejpeg($resource, $dstName, 100);
        } elseif ($imageType == IMAGETYPE_PNG) {
            $result = @imagepng($resource, $dstName, 0);
        } else {
            throw new ImageTypeException();
        }

        if (!$result) {
            return false;
        }
        return true;
    }


    /**
     * @param $fileName
     * @return Image
     * @throws StdImgIOException
     */
    protected static function newImage($fileName)
    {
        list(
            $resource,
            $width,
            $height,
            $imageType
            ) = self::createResource($fileName);

        return new Image(
            $fileName,
            $resource,
            $width,
            $height,
            $imageType
        );
    }


    /**
     * @param $fileName
     * @throws ImageTypeException
     * @throws StdImgIOException
     * @return array
     *
     * TODO: check MIME?
     */
    protected static function createResource($fileName)
    {
        $imageInfo = self::getImageInfo($fileName);

        $imageType = $imageInfo[2];
        if ($imageType == IMAGETYPE_JPEG) {
            $resource = imagecreatefromjpeg($fileName);
        } elseif ($imageType == IMAGETYPE_PNG) {
            $resource = imagecreatefrompng($fileName);
        } else {
            throw new ImageTypeException();
        }

        if (!is_resource($resource)) {
            throw new StdImgIOException('Unable to create image resource');
        }

        return array(
            $resource,
            $imageInfo[0],
            $imageInfo[1],
            $imageInfo[2]
        );
    }


    /**
     * @param $fileName
     * @return string
     * @throws StdImgIOException
     */
    protected static function confirmSrcFile($fileName)
    {
        if (is_file($fileName)) {
            if (!is_readable($fileName)) {
                throw new StdImgIOException('"' .$fileName. '" is not readable');
            }
        }

        return $fileName;
    }


    /**
     * @param $fileName
     * @return array
     * @throws StdImgIOException
     */
    protected static function getImageInfo($fileName)
    {
        $imageInfo = @getimagesize($fileName);
        if (!$imageInfo) {
            throw new StdImgIOException('Cannot get image info from "' . $fileName .'"');
        }

        return $imageInfo;
    }


    /**
     * @param $dstName
     * @return string
     * @throws StdImgIOException
     */
    protected static function confirmDstFile($dstName)
    {
        if (!$dstName) {
            throw new StdImgIOException('Invalid dst file name :"' . $dstName . '"');
        }

        $dir = pathinfo($dstName, PATHINFO_DIRNAME);
        if (!is_dir($dir)) {
            if (!mkdir($dir)) {
                throw new StdImgIOException('Failed to make directory: "' . $dir . '"');
            }
        }
        if (!is_writable($dir)) {
            throw new StdImgIOException('"' . $dir . '" is not writable');
        }

        return $dstName;
    }
}