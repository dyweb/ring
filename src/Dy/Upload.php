<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-7-17
 * Time: 下午8:22
 */

namespace Dy;

class Upload
{
    private $maxSize;

    private $path;

    private $width;

    private $height;

    private $zoomIn;

    private $ratios;

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
            'zoomIn' => true,       //调整长宽时，是否放大
            'ratios' => array(),     //这个没用 TODO:删掉
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
            var_dump($this->maxSize);
            return false;
        }

        if (strpos(strtolower($fileInfo['type']), 'image') === false) {
            $this->setError('Not an image');
            return false;
        }

        if (!is_dir($this->path)) {
            $this->setError('Wrong path');
            return false;
        }

        if (!is_writable($this->path)) {
            $this->setError('Path not writable');
            return false;
        }

        $image = StdImgIo::in($fileInfo['tmp_name'])
            ->setZoomIn($this->zoomIn)
            ->setDstWidth($this->width)
            ->setDstHeight($this->height)
            ->resize();

        if ($this->correctOrientation) {
            $image->correctOrientation();
        }

        $fileName = $fileInfo['name'];
        if ($this->hashName) {
            $fileName = $this->genDstName($fileName);
        }
        var_dump($fileName);

        if (!StdImgIO::out($image, $fileName, $this->overWrite)) {
            $this->setError('Failed to save image');
            return false;
        }

        return $fileName;
    }


    private function genDstName($file, $desc = '')
    {
        return $this->path . DIRECTORY_SEPARATOR .
            md5(date('YmdHis')) .
            ($desc ? '_' . $desc : '') . '.' .
            pathinfo($file, PATHINFO_EXTENSION);
    }


    public function setPath($path)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->path = realpath($path);

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


    public function setRatios(array $ratios)
    {
        $this->ratios = array();
        if (!empty($ratios)) {
            if (!is_array($ratios[0]) and count($ratios) === 2) {
                $this->setWidth($ratios[0])->setHeight($ratios[1]);
            } else {
                foreach ($ratios as $desc => $ratio) {
                    if (@count($ratio) === 2) {
                        $this->ratios[$desc] = $ratio;
                    }
                }
            }
        }

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