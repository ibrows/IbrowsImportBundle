<?php

namespace Ibrows\ImportBundle\Row;

use Ibrows\ImportBundle\Row\Field\FieldInterface;

interface RowInterface
{
    /**
     * @return FieldInterface[]
     */
    public function getFields();
    
    /**
     * @param string $fieldName
     * @return FieldInterface
     */
    public function get($fieldName);

    /**
     * @param string $fieldName
     * @return bool
     */
    public function has($fieldName);
}
