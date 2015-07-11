<?php


namespace Dyweb\Ring;


class Upload
{
    protected $width = 0;
    protected $height = 0;
    protected $sizes = array();

    protected $maxSize = 0;
    protected $maxWidth = 0;
    protected $maxHeight = 0;

    protected $uploadPath = '';
    protected $textWatermark = array();
    protected $imageWatermark = array();

    protected $encryptName = true;
    protected $zoomIn = false;

    protected $errorMsg = '';

    protected $fileInfo = null;


    public function __construct($config = array())
    {
        $defaultConfig = array(
            'width' => 0,
            'height' => 0,
            'sizes' => array(0, 0),
            'maxWidth' => 0,
            'maxHeight' => 0,
            'maxSize' => 0,
            'zoomIn' => false,
            'encryptName' => true,
            'uploadPath' => '',
            'textWatermark' => array(
                'text' => '',
                'font' => 5,
                'anchor_x' => 0,
                'anchor_y' => 0,
                'opacity' => 50
            ),
            'imageWatermark' => array(
                'image' => '',
                'anchor_x' => 0,
                'anchor_y' => 0,
                'opacity' => 50
            ),
        );

        $config = array_merge($defaultConfig, $config);
        foreach ($config as $key => $val) {
            if (method_exists($this, 'set' . ucfirst($key))) {
                $this->{'set' . ucfirst($key)}($val);
            } else {
                $this->$key = $config[$key];
            }
        }

    }


    public function doUpload($field)
    {
        if (empty($field)) {
            $this->setError('No file selected');
            return FALSE;
        }

        $this->fileInfo = $this->getFile($field);

        return true;
    }


    /**
     * @param $field
     * @return array|null
     */
    protected function getFile($field)
    {
        if (empty($field)) {
            return null;
        }

        if (is_array($field)) {
            $fileInfo = array();
            foreach ($field as $imageField) {
                $file = $this->getFile($imageField);
                if ($file) {
                    $fileInfo[] = $file;
                }
            }
            return empty($fileInfo) ? null : $fileInfo;
        }

        if (!is_string($field)) {
            return null;
        }

        $files = $this->filesInput();
        if (isset($files[$field])) {
            return $files[$field];
        }

        return null;
    }


    /**
     * @return mixed
     */
    public function filesInput()
    {
        return $_FILES;
    }


    public function setZoomIn($bool)
    {
        $this->zoomIn = $bool and true;
        return $this;
    }

    public function setEncryptName($bool)
    {
        $this->encryptName = $bool and true;
        return $this;
    }

    public function setMaxWidth($width)
    {
        $this->maxWidth = intval($width);
        return $this;
    }

    public function setMaxHeight($height)
    {
        $this->maxHeight = $height;
        return $this;
    }

    public function setMaxSize($size)
    {
        $this->maxSize = $size;
        return $this;
    }

    public function setWidth($width)
    {
        $this->$width = intval($width);
        return $this;
    }

    public function setHeight($height)
    {
        $this->height = intval($height);
        return $this;
    }

    public function setSizes(array $sizes)
    {
        $this->sizes = array();
        if (!empty($sizes)) {
            if (!is_array($sizes[0]) and count($sizes) === 2) {
                $this->setWidth($sizes[0]);
                $this->setHeight($sizes[1]);
            } else {
                foreach ($sizes as $desc => $size) {
                    if (@count($size) === 2) {
                        $this->sizes[$desc] = $size;
                    }
                }
            }
        }

        return $this;
    }

    public function setUploadPath($path)
    {
        $this->uploadPath = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        return $this;
    }

    public function setError($msg)
    {
        $this->errorMsg = $msg;
        return $this;
    }

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}