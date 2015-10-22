<?php
use Dy\Ring\BackendInterface;
use Dy\Ring\Source\AbstractSource;

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/22
 * Time: 下午5:06
 */
class Local implements BackendInterface
{
    public function storeData(AbstractSource $source)
    {
        // TODO: Implement upload() method.
    }

    public function storeMeta(AbstractSource $source)
    {
        // TODO: Implement storeMeta() method.
    }
}