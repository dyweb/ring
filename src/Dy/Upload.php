<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-7-17
 * Time: 下午8:22
 */

namespace Dy;

use Dy\Exception\ImageTypeException;

class Upload
{
    private $maxSize;

    private $path;

    private $width;

    private $height;

    private $ratios;

    private $zoomIn;

    private $errMsg = '';

    private $correctOrientation = true;

    private $hashName = true;

    private $overWrite = false;

    public function __construct($config)
    {
        $dftConfig = array(
            'maxSize' => 0,
            'path' => '',           //必需
            'width' => 0,           //长宽任意一个为零则不调整大小
            'height' => 0,          //
            'ratios' => array(),
            'zoomIn' => true,       //调整长宽时，是否放大
            'correctOrientation' => true,   //（变量名超长...)是否调整图片的方向
            'hashName' => true,     //是否对文件名哈希
            'overWrite' => false,   //是否覆盖同名文件
        );

        $config = array_merge($dftConfig, $config);
        foreach ($config as $key => $val) {
            if (method_exists($this, 'set' . ucfirst($key))) {
                $this->{'set' . ucfirst($key)}($val);
            } else {
                $this->$key = $config[$key];
            }
        }

        $maxFileSize = $this->getMaxFilesize();
        if ($this->maxSize <= 0 or $this->maxSize > $maxFileSize) {
            $this->maxSize = $maxFileSize;
        }
    }


    /**
     * @param   string  $field
     * @return  Image   $this|bool
     */
    public function uploadImage($field)
    {
        $fileInfo = $this->getFileInfo($field);
        if (is_null($fileInfo)) {
            $this->setError('No file selected');
            return false;
        }

        if ($fileInfo['size'] > $this->maxSize) {
            $this->setError('Too large');
            return false;
        }

        if (strpos(strtolower($fileInfo['type']), 'image') === false) {
            $this->setError('Not image');
            return false;
        }

        try {
            $image = StdImgIo::in($fileInfo['tmp_name'])
                ->setZoomIn($this->zoomIn)
                ->setDstWidth($this->width)
                ->setDstHeight($this->height);
        } catch (ImageTypeException $e) {
            $this->setError($e->getMessage());
            return false;
        }

        if ($this->correctOrientation) {
            $image->correctOrientation();
        }

        $file = $this->genDstName($fileInfo['name'], '', false);;

        //当$this->ratios为空时，才使用width和height
        if (empty($this->ratios)) {
            $image->resize();
            if (!StdImgIO::out($image, $file, $this->overWrite)) {
                $this->setError('Failed to save image');
                return false;
            }
        } else {
            $fileName = $file;
            foreach ($this->ratios as $desc => $ratio) {
                $tmpImage = $image->copy($ratio[0], $ratio[1])->resize();
                $fileName = $this->genDstName($fileName, $desc, true);
                if (!StdImgIO::out($tmpImage, $fileName, $this->overWrite)) {
                    $this->setError('Failed to save image');
                    return false;
                }
            }
        }

        //返回的是没有后缀的图片名
        return $file;
    }


    private function genDstName($file, $desc = '', $hashed = false)
    {
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        return $this->path .
        (($this->hashName and !$hashed) ? md5(date('YmdHis') . $file) : $fileName) .
        ($desc ? '_' . $desc : '') . '.' .
        $extension;
    }


    public function setPath($path)
    {
        $this->path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        return $this;
    }


    public function setMaxSize($size)
    {
        $this->maxSize = $size;
        return $this;
    }


    public function setWidth($width)
    {
        $this->width = intval($width);
        return $this;
    }


    public function setHeight($height)
    {
        $this->height = intval($height);
        return $this;
    }


    public function setRatios($ratios)
    {
        $this->ratios = $ratios;
        return $this;
    }


    /**
     * @param $bool
     * @return $this
     */
    public function setHashName($bool)
    {
        $this->hashName = $bool;
        return $this;
    }


    /**
     * @param $bool
     * @return $this
     */
    public function setCorrectOrientation($bool) {
        $this->correctOrientation = $bool;
        return $this;
    }


    /**
     * @param $bool
     * @return $this
     */
    public function setOverWrite($bool) {
        $this->overWrite = $bool;
        return $this;
    }


    public function getError()
    {
        return $this->errMsg;
    }


    /**
     * @param $field
     * @return array|null
     */
    private function getFileInfo($field)
    {
        if (!$field) {
            return null;
        }

        if (!is_string($field)) {
            return null;
        }

        $files = $_FILES;
        if (isset($files[$field])) {
            return $files[$field];
        }

        return null;
    }

    private function setError($msg)
    {
        $this->errMsg = $msg;
        return $this;
    }

    /**
     * Returns the maximum size of an uploaded file as configured in php.ini.
     *
     * @return int The maximum size of an uploaded file in bytes
     */
    private static function getMaxFilesize()
    {
        $iniMax = strtolower(ini_get('upload_max_filesize'));

        if ('' === $iniMax) {
            return PHP_INT_MAX;
        }

        $max = ltrim($iniMax, '+');
        if (0 === strpos($max, '0x')) {
            $max = intval($max, 16);
        } elseif (0 === strpos($max, '0')) {
            $max = intval($max, 8);
        } else {
            $max = (int) $max;
        }

        switch (substr($iniMax, -1)) {
            case 't':
                $max *= 1024;
                //no break
            case 'g':
                $max *= 1024;
                //no break
            case 'm':
                $max *= 1024;
                //no break
            case 'k':
                $max *= 1024;
        }

        return $max;
    }
}