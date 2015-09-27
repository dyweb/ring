<?php
/**
 * Created by PhpStorm.
 * User: xsf
 * Date: 15-9-27
 * Time: 上午9:38
 */

namespace Dy\Ring;

/**
 * Interface BackendInterface
 * @package Dy\Ring
 */
interface BackendInterface
{
    /**
     * @param File $file
     * @return bool
     * @throws Dy\Ring\Exception\FileSaveFailedException
     */
    public function upload(File $file);
}
