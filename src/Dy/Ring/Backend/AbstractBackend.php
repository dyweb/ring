<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/22
 * Time: 下午5:44
 */

namespace Dy\Ring\Backend;

use Dy\Ring\Backend\Meta\AbstractMetaStorage;
use Dy\Ring\Source\AbstractSource;
use Dy\Ring\Backend\Data\AbstractDataStorage;

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
     * Store source data to backend
     *
     * @param AbstractSource $source
     * @return mixed
     */
    public function storeData(AbstractSource $source)
    {
        $this->dataStorage->store($source);
    }

    /**
     * Store source meta to backend
     *
     * @TODO: add throw not supported exception in comment
     * @param AbstractSource $source
     * @return mixed
     */
    public function storeMeta(AbstractSource $source)
    {
        $this->metaStorage->store($source);
    }
}
