<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-27
 * Time: 上午9:38
 */

namespace Dy\Ring;

use Dy\Ring\Source\AbstractSource;

/**
 * Interface BackendInterface
 * @package Dy\Ring
 */
interface BackendInterface
{
    /**
     * Store source data to backend
     *
     * @param AbstractSource $source
     * @return mixed
     */
    public function storeData(AbstractSource $source);

    /**
     * Store source meta to backend
     *
     * @TODO: add throw not supported exception in comment
     * @param AbstractSource $source
     * @return mixed
     */
    public function storeMeta(AbstractSource $source);
}
