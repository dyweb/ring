<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-27
 * Time: 上午10:10
 */

namespace Dy\Ring;

class Util
{
    /**
     * @param string $fileName
     * @return mixed
     */
    public static function filterFileName($fileName)
    {
        return preg_replace("/([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})/", "", $fileName);
    }


    /**
     * @param $path
     * @param $fileName
     * @param $extension
     * @return string
     */
    public static function fileNameNotExist($path, $fileName, $extension)
    {
        $fullName = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName . '.' . $extension;

        $count = 0;
        while (file_exists($fullName) and $count < 100) {
            ++$count;
            $fileName .= '(' . $count . ')';
            $fullName = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
                $fileName . '.' . $extension;
        }

        if (file_exists($fullName)) {
            $fileName = $fileName . '_' . time();
        }

        return $fileName;
    }
}
