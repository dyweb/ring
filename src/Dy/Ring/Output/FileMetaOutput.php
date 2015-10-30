<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/30
 * Time: 上午11:30
 */

namespace Dy\Ring\Output;

use Dy\Ring\FileMetaTrait;
use Dy\Ring\Source\AbstractSource;

class FileMetaOutput extends AbstractOutput
{
    use FileMetaTrait;

    public function __construct()
    {

    }

    public function getFileName()
    {
        // TODO: Implement getFileName() method.
    }

    public function getDownloadUrl()
    {
        // TODO: Implement getDownloadUrl() method.
    }

    public function getDisplayName()
    {
        // TODO: Implement getDisplayName() method.
    }

    public function getFileNameWithoutExt()
    {
        // TODO: Implement getFileNameWithoutExt() method.
    }

    public function getFileExtension()
    {
        // TODO: Implement getFileExtension() method.
    }

    public function getFilePath()
    {
        // TODO: Implement getFilePath() method.
    }

    public function getFileSize()
    {
        // TODO: Implement getFileSize() method.
    }

    public function getMimeType()
    {
        // TODO: Implement getMimeType() method.
    }

    public function getUrl()
    {
        // TODO: Implement getUrl() method.
    }

    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
