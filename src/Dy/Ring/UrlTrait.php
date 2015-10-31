<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/31
 * Time: 上午10:09
 */

namespace Dy\Ring;

trait UrlTrait
{
    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $baseUrl;

    public function getUrl($path)
    {
        $this->cleanBase();
        // relative path to basePath
        $relative = $this->relative($path, $this->basePath);
        // concat baseUrl
        return $this->baseUrl . '/' . $relative;
    }

    /**
     * @param string $from
     * @param string $to
     * @return string
     */
    public function relative($from, $to)
    {
        $from = $this->cleanPath($from);
        $to = $this->cleanPath($to);
        return ltrim(substr($from, strlen($to)), '/');
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function cleanPath($path)
    {
        return rtrim($path, '/');
    }

    protected function cleanBase()
    {
        $this->basePath = $this->cleanPath($this->basePath);
        $this->baseUrl = $this->cleanPath($this->baseUrl);
    }
}
