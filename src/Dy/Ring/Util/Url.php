<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/31
 * Time: 上午10:09
 */

namespace Dy\Ring\Util;

class Url
{
    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @param $basePath
     * @param $baseUrl
     */
    public function __construct($basePath, $baseUrl)
    {
        $this->basePath = $basePath;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $path
     * @return string
     */
    public function getUrl($path)
    {
        $this->cleanBase();
        // relative path to basePath
        $relative = $this->relative($path, $this->basePath);
        // concat baseUrl
        return $this->baseUrl . '/' . $relative;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function cleanPath($path)
    {
        return rtrim($path, '/');
    }

    /**
     * @TODO: self or static
     * @param string $from
     * @param string $to
     * @return string
     */
    public static function relative($from, $to)
    {
        $from = self::cleanPath($from);
        $to = self::cleanPath($to);
        return ltrim(substr($from, strlen($to)), '/');
    }

    protected function cleanBase()
    {
        $this->basePath = $this->cleanPath($this->basePath);
        $this->baseUrl = $this->cleanPath($this->baseUrl);
    }
}
