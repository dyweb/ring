<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/27
 * Time: 下午2:55
 */

namespace Dy\Ring\Rule;

use Dy\Ring\Exception\InvalidArgumentException;
use Dy\Ring\Exception\OutOfBoundsException;
use Dy\Ring\Source\AbstractSource;

final class SizeRule extends AbstractRule
{
    /**
     * @var int
     */
    protected $maxSize = 0;

    public function __construct($maxSize)
    {
        if (intval($maxSize) === 0) {
            throw new InvalidArgumentException('maxSize can\'t be' . $maxSize);
        }
        $this->maxSize = intval($maxSize);
    }

    /**
     * @param AbstractSource $source
     * @return bool
     */
    public function check(AbstractSource $source)
    {
        // TODO: Implement check() method.
        if ($this->maxSize === 0) {
            throw new InvalidArgumentException('maxSize cant\'t be 0');
        }
        if ($this->maxSize < $source->getFileSize()) {
            throw new OutOfBoundsException('File size ' . $source->getFileSize() . ' exceeded maxSize ' . $this->maxSize);
        }
        return true;
    }
}
