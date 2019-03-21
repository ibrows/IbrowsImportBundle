<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 */
class Integer extends AbstractMapping
{
    /**
     * @param mixed $value
     * @return integer
     */
    public function transformToPHP($value)
    {
        return (integer) $value;
    }
}
