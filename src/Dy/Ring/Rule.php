<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:45
 */

namespace Dy\Ring;

/**
 * Class Rule
 * @package Dy\Ring
 */
class Rule
{
    /**
     * max file size in Bytes
     *
     * @var int
     */
    protected $maxSize = 0;

    /**
     * if use hash filename
     *
     * @var bool
     */
    protected $hashName = true;

    /**
     * the prefix of filename
     *
     * @var string
     */
    protected $namePrefix = '';

    /**
     * the suffix of filename
     *
     * @var string
     */
    protected $nameSuffix = '';


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
     * @param $size
     * @return bool
     */
    public function isValidSize($size)
    {
        return (!$this->maxSize or $size <= $this->maxSize);
    }


    /**
     * @param string $fileName
     * @return string
     */
    public function makeFileName($fileName)
    {
        if ($this->hashName) {
            $fileName = md5($fileName . time());
        }

        $fileName = $this->namePrefix . $fileName . $this->nameSuffix;

        return $fileName;
    }


    /**
     * @param int $size
     * @return $this
     */
    public function setMaxSize($size)
    {
        $size = intval($size);
        if ($size) {
            $this->maxSize = $size;
        }

        return $this;
    }


    /**
     * @param bool $bool
     * @return $this
     */
    public function setHashName($bool)
    {
        $this->hashName = (bool)$bool;

        return $this;
    }


    /**
     * @param string $prefix
     * @return $this
     */
    public function setNamePrefix($prefix)
    {
        $this->namePrefix = $prefix;

        return $this;
    }


    /**
     * @param string $suffix
     * @return $this
     */
    public function setNameSuffix($suffix)
    {
        $this->nameSuffix = $suffix;

        return $this;
    }
}
