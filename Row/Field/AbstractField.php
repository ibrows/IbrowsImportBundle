<?php

namespace Ibrows\ImportBundle\Row\Field;

abstract class AbstractField implements FieldInterface
{
    /**
     * @var mixed
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
