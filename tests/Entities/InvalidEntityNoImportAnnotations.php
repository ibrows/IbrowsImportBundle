<?php

namespace Ibrows\ImportBundle\Tests\Entities;

class InvalidEntityNoImportAnnotations
{
    private $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return InvalidEntityNoImportAnnotations
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
