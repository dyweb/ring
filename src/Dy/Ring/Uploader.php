<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/28
 * Time: 下午9:08
 */

namespace Dy\Ring;

use Dy\Ring\Backend\AbstractBackend;
use Dy\Ring\Exception\NotSupportedException;
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
     * Check if the source can pass all the rules
     *
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

    public function transform()
    {
        throw new NotSupportedException('transform is not supported, coming soon');
    }

    /**
     * Tell the backend to store data and then store meta
     */
    public function save()
    {
        $this->backend->store($this->source);
    }

    /**
     * @return Meta\AbstractMeta
     */
    public function getMeta()
    {
        return $this->backend->getMeta();
    }
}
