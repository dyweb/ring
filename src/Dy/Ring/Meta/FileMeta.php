<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/30
 * Time: 下午6:41
 */

namespace Dy\Ring\Meta;

use Dy\Ring\FileMetaTrait;
use Dy\Ring\Source\AbstractSource;

class FileMeta extends AbstractMeta
{
    use FileMetaTrait;

    public function __construct(AbstractSource $source)
    {
        // copy all the attributes
        $this->fileName = $source->getFileName();
        $this->fileExtension = $source->getFileExtension();
        $this->displayName = $source->getDisplayName();
        $this->filePath = $source->getFilePath();
        $this->fileSize = $source->getFileSize();
        $this->mimeType = $source->getMimeType();
    }

    public function jsonSerialize()
    {
        return array(
            'name' => $this->getFileName(),
            'size' => $this->getFileSize(),
            'ext' => $this->getFileExtension(),
            'name_without_ext' => $this->getFileNameWithoutExt()
        );
    }
}
