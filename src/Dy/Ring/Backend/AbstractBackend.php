<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/22
 * Time: 下午5:44
 */

namespace Dy\Ring\Backend;

use Dy\Ring\Backend\Meta\AbstractMetaStorage;
use Dy\Ring\Backend\Data\AbstractDataStorage;
use Dy\Ring\Source\AbstractSource;
use Dy\Ring\Output\AbstractOutput;

/**
 * Class AbstractBackend
 * @package DY\Ring\Backend
 */
abstract class AbstractBackend
{
    /**
     * @var AbstractDataStorage
     */
    protected $dataStorage = null;

    /**
     * @var AbstractMetaStorage
     */
    protected $metaStorage = null;

    /**
     * @param AbstractDataStorage $dataStorage
     * @param AbstractMetaStorage $metaStorage
     */
    public function __construct(AbstractDataStorage $dataStorage, AbstractMetaStorage $metaStorage)
    {
        $this->dataStorage = $dataStorage;
        $this->metaStorage = $metaStorage;
    }

    /**
     * Return the output data of latest stored file
     *
     * @return AbstractOutput
     */
    abstract public function getOutput();

    final public function store(AbstractSource $source)
    {
        $this->dataStorage->store($source);
        $this->metaStorage->store($this->dataStorage->getMeta());
    }
}
