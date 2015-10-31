<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/24
 * Time: 下午4:30
 */

namespace DY\Ring\Backend\Data;

use Dy\Ring\Source\AbstractSource;

/**
 * Class NullDataStorage
 *
 * A null data storage, save no data
 *
 * @package DY\Ring\Backend\Data
 */
final class NullDataStorage extends AbstractDataStorage
{
    public function store(AbstractSource $source)
    {
        // TODO: Implement store() method.
    }

    public function getMeta()
    {
        // TODO: Implement getMeta() method.
    }

    public function realpath($path)
    {
        // TODO: Implement realpath() method.
    }
}
