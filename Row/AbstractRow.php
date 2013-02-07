<?php

namespace Ibrows\ImportBundle\Row;

use Ibrows\ImportBundle\Row\Field\FieldInterface;

abstract class AbstractRow implements RowInterface
{
    /**
     * @var FieldInterface[]
     */
    protected $fields = array();

    /**
     * @return FieldInterface[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string $fieldName
     * @return bool
     */
    public function has($fieldName)
    {
        return (bool)$this->get($fieldName);
    }

    /**
     * @param string $fieldName
     * @return FieldInterface|null
     */
    public function get($fieldName)
    {
        foreach($this->fields as $field){
            if($field->getName() == $fieldName){
                return $field;
            }
        }

        return null;
    }

    /**
     * @param FieldInterface[] $fields
     */
    protected function setFields(array $fields)
    {
        $this->fields = $fields;
    }
}