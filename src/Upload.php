<?php


namespace Dyweb\Ring;


class Upload
{
    protected $width = 0;
    protected $height = 0;
    protected $ratios = array();

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
            'ratios' => array(0, 0),
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
        $file = $this->getFile($field);
        if (is_null($this->fileInfo)) {
            $this->setError('No file selected');
            return false;
        }

        if (!$this->isFileUploaded($file)) {
            return false;
        }






        return true;
    }

    protected function isFileUploaded($file)
    {
        if (!is_uploaded_file($file['tmp_name'])) {
            $error = isset($file['error']) ? $file['error'] : 4;

            // from CI = =
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                    $this->setError('upload_file_exceeds_limit');
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $this->setError('upload_file_exceeds_form_limit');
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $this->setError('upload_file_partial');
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $this->setError('upload_no_file_selected');
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $this->setError('upload_no_temp_directory');
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $this->setError('upload_unable_to_write_file');
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $this->setError('upload_stopped_by_extension');
                    break;
                default:
                    $this->setError('upload_no_file_selected');
                    break;
            }

            return false;
        }

        return true;
    }

    /**
     * @param $field
     * @return array|null
     */
    protected function getFile($field)
    {
        if (!$field) {
            return null;
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

    public function setRatios(array $ratios)
    {
        $this->ratios = array();
        if (!empty($ratios)) {
            if (!is_array($ratios[0]) and count($ratios) === 2) {
                $this->setWidth($ratios[0]);
                $this->setHeight($ratios[1]);
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