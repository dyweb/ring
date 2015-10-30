<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/28
 * Time: 下午9:08
 */

namespace Dy\Ring;

use Dy\Ring\Backend\AbstractBackend;
use Dy\Ring\Rule\AbstractRule;
use Dy\Ring\Source\AbstractSource;

class Uploader
{
    /**
     * @var AbstractBackend
     */
    protected $backend;

    /**
     * @var AbstractSource
     */
    protected $source;

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * @param AbstractBackend $backend
     * @param AbstractSource $source
     */
    public function __construct(AbstractBackend $backend, AbstractSource $source)
    {
        $this->backend = $backend;
        $this->source = $source;
    }

    /**
     * @TODO: avoid duplicated rules
     * @param AbstractRule $rule
     */
    public function addRule(AbstractRule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return bool
     */
    public function check()
    {
        foreach ($this->rules as $rule) {
            /* @var $rule AbstractRule */
            $rule->check($this->source);
        }
        return true;
    }

    /**
     *
     */
    public function save()
    {
        $this->backend->storeData($this->source);
        $this->backend->storeMeta($this->source);
    }

    /**
     * @return Output\AbstractOutput
     */
    public function getOutput()
    {
        return $this->backend->getOutput();
    }
}
