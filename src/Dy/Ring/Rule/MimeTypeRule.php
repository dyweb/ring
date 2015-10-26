<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/26
 * Time: 下午6:32
 */

namespace Dy\Ring\Rule;

use Dy\Ring\Exception\InvalidArgumentException;
use Dy\Ring\Source\AbstractSource;

final class MimeTypeRule extends AbstractRule
{
    protected $allowedTypes = array();

    // TODO: add const for common mime types;

    public function __construct(array $types = array())
    {
        if (!empty($types)) {
            $this->allowedTypes = array_map('strtolower', $types);
        }
    }

    public function check(AbstractSource $source)
    {
        if (empty($this->allowedTypes)) {
            throw new InvalidArgumentException('Allowed mime types can\'t be empty!');
        }
        $mime = strtolower($source->getMimeType());
        if (array_search($mime, $this->allowedTypes) === false) {
            throw new InvalidArgumentException('Mime type ' . $mime . ' is not allowed');
        }
        return true;
    }
}
