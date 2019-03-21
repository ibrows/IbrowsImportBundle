<?php

namespace Ibrows\ImportBundle\Annotation\Compare;

abstract class AbstractCompare implements CompareInterface
{
    /**
     * @var string
     */
    public $fieldName;

    /**
     * @var string
     */
    public $setterName = null;

    /**
     * @var string
     */
    public $getterName = null;

    /**
     * @var bool
     */
    public $ignoreBlank = false;

    /**
     * @return null|string
     */
    public function getGetterName()
    {
        return $this->getterName;
    }

    /* (non-PHPdoc)
     * @see Ibrows\ImportBundle\Annotation\Compare.CompareInterface::transformToCompare()
     */
    public function transformToCompare($value)
    {
        //proxy of mapping
        $class = get_class($this);
        $class = str_replace('\\Compare\\', '\\Mapping\\', $class);
        $obj = new $class();
        return $obj->transformToCompare($value);
    }
}
