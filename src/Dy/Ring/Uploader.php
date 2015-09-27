<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-18
 * Time: 下午7:48
 */

namespace Dy\Ring;

use Dy\Ring\Backend\LocalFs;
use Dy\Ring\Exception\FileSrc\NoFileUploadedException;
use Dy\Ring\FileSrc\FileSrc;
use Dy\Ring\FileSrc\UploadedFile;

class Uploader
{
    /**
     * @var File
     */
    private $file = null;

    /**
     * @var BackendInterface
     */
    private $backend = null;

    /**
     * @var FileSrc
     */
    private $fileSrc = null;

    /**
     * @var string 'normal'|'image'
     */
    private $fileType = 'normal';

    /**
     * @var string
     */
    private $uploadPath;

    /**
     * @var bool
     */
    private $overWrite = false;

    /**
     * @var int
     */
    private $maxSize = 0;

    /**
     * @var bool
     */
    private $hashName = true;

    /**
     * destination image size
     *
     * @var int
     */
    private $dstWidth = 0;

    /**
     * destination image size
     *
     * @var int
     */
    private $dstHeight = 0;

    /**
     * @var string
     */
    private $errorMsg = '';


    public function __construct(array $config = array())
    {
        if (!empty($config)) {
            foreach ($config as $key => $val) {
                if (method_exists($this, 'set' . ucfirst($key))) {
                    $this->{'set' . ucfirst($key)}($val);
                } else {
                    $this->$key = $val;
                }
            }
        }
    }


    /**
     * @throws NoFileUploadedException
     * @throws \Exception
     */
    public function prepare()
    {
        if (is_null($this->file)) {
            if (is_string($this->fileSrc)) {
                try {
                    $this->fileSrc = new UploadedFile($this->fileSrc);
                } catch (NoFileUploadedException $e) {
                    throw $e;
                }
            }

            if ($this->fileSrc instanceof FileSrc) {
                $rule = strtolower($this->fileType) === 'normal' ?
                    new Rule() : new ImageRule();

                $rule->setMaxSize($this->maxSize)
                    ->setHashName($this->hashName);

                if (strtolower($this->fileType) === 'image') {
                    $rule->setDstWidth($this->dstWidth)
                        ->setDstHeight($this->dstHeight);

                    $this->file = new Image($this->fileSrc, $rule);
                } else {
                    $this->file = new File($this->fileSrc, $rule);
                }
            } else {
                throw new \InvalidArgumentException('fileSrc : File source');
            }
        }

        if (is_null($this->backend)) {
            $this->backend = new LocalFs($this->uploadPath, $this->overWrite);
        }

        return $this;
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public function doUpload()
    {
        try {
            $this->backend->upload($this->file->check());
        } catch (\Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }

        return true;
    }


    /**
     * @param File $val
     * @return $this
     */
    public function setFile(File $val)
    {
        $this->file = $val;

        return $this;
    }


    /**
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }


    /**
     * @param BackendInterface $val
     * @return $this
     */
    public function setBackend(BackendInterface $val)
    {
        $this->backend = $val;

        return $this;
    }


    /**
     * @param $msg
     * @return $this
     */
    private function setError($msg)
    {
        $this->errorMsg = $msg;

        return $this;
    }
}
