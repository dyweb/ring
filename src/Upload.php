<?php


namespace dyweb\ring;


class Upload
{
    const MAX_WIDTH = 10000;
    const MAX_HEIGHT = 10000;

    protected $width = 0;
    protected $height = 0;
    protected $sizes = [];
    protected $path = '';
    protected $watermark = [];
    protected $encrypt_name = true;
    protected $zoom_in = false;

    protected $file_info = null;

    public function __construct($config)
    {
        $this->zoom_in = isset($config['zoom_in']) and $config['zoom_in'];

        $this->encrypt_name = isset($config['encrypt_name']) and $config['encrypt_name'];

        if (isset($config['path'])) {
            $this->path = $config['path'];
        }

        if (isset($config['sizes']) and is_array($config['sizes']) and !empty($config['sizes'])) {
            if (!is_array($config['sizes'][0])) {
                if (count($config['sizes']) == 2) {
                    $this->width = $config['sizes'][0];
                    $this->height = $config['sizes'][1];
                }
            } else {
                $this->sizes = $config['sizes'];
            }
        }

        if (empty($this->sizes)) {
            if (!isset($config['width']) and isset($config['height'])) {
                $this->width = $config['width'];
                $this->height = $config['height'];
            }
        }

        if (isset($config['watermark'])) {
            $this->watermark = $config['watermark'];
        }

    }


    public function do_upload($field = null)
    {

    }

    protected function get_image($field)
    {
        if (!is_string($field)) {
            return null;
        }

        if (is_null($field)) {
            if (empty($_FILES)) {
                return null;
            }
            $images = array();
            foreach ($_FILES as $file) {
                if ($this->is_image($file)) {
                    $images[] = $file;
                }
            }
            return empty($images) ? null : $images;
        }

        if (!isset($_FILES[$field])) {
            return null;
        }

        return $_FILES[$field];
    }


    private function is_image($file)
    {

        return true;
    }
}