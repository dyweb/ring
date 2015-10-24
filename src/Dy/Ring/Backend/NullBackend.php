<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/24
 * Time: 下午4:34
 */

namespace DY\Ring\Backend;

use DY\Ring\Backend\Data\NullDataStorage;
use Dy\Ring\Backend\Meta\NullMetaStorage;
use Dy\Ring\Source\AbstractSource;

final class NullBackend extends AbstractBackend
{
    public function __construct(NullDataStorage $dataStorage, NullMetaStorage $metaStorage)
    {
        parent::__construct($dataStorage, $metaStorage);
    }

    public function storeData(AbstractSource $source)
    {
        // TODO: Implement storeData() method.
    }

    public function storeMeta(AbstractSource $source)
    {
        // TODO: Implement storeMeta() method.
    }
}
