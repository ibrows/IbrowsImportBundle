<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 */
abstract class AbstractMapping implements MappingInterface
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
     * @var bool
     */
    public $ignoreNotExistent = false;

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return bool
     */
    public function ignoreBlank()
    {
        return $this->ignoreBlank;
    }

    /**
     * @return null|string
     */
    public function getSetterName()
    {
        return $this->setterName;
    }

    /**
     * @return null|string
     */
    public function getGetterName()
    {
        return $this->getterName;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function transformToPHP($value)
    {
        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function transformToCompare($value)
    {
        return $value;
    }

    /**
     * @return boolean
     */
    public function isIgnoreNotExistent()
    {
        return $this->ignoreNotExistent;
    }

    /**
     * @param boolean $ignoreNotExistent
     */
    public function setIgnoreNotExistent($ignoreNotExistent)
    {
        $this->ignoreNotExistent = $ignoreNotExistent;
    }

    /**
     * @return mixed
     */
    public function ignoreNotExistent()
    {
        return $this->ignoreNotExistent;
    }
}
