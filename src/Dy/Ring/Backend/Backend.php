<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:49
 */

namespace Dy\Ring\Backend;

use Dy\Ring\File;

/**
 * Class Backend
 * @package Dy\Ring\Backend
 */
abstract class Backend
{
    /**
     * @var mixed
     */
    protected $basePath;

    /**
     * @var bool
     */
    protected $overWrite = false;


    /**
     * @param $basePath
     * @return $this
     * @throw \Exception
     */
    abstract public function setBasePath($basePath);

    abstract public function save(File $file);


    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        if (!empty($config)) {
            foreach ($config as $key => $val) {
                if (method_exists($this, 'set' . ucfirst($key))) {
                    $this->{'set' . ucfirst($key)}($val);
                }
            }
        }
    }
}
