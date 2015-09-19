<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:45
 */

namespace Dy\Ring;

class Rule
{
    /**
     * @var string
     */
    protected $fileType = 'normal';

    /**
     * max file size in Bytes
     * @var int
     */
    protected $maxSize = 0;

    /**
     * @var array
     */
    protected $validMimeTypes = array();

    public function __construct($config = array())
    {

    }
}
