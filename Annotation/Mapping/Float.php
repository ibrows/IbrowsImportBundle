<?php

namespace Ibrows\ImportBundle\Annotation\Mapping;

/**
 * @Annotation
 */
class Float extends AbstractMapping
{
    /**
     * @param mixed $value
     * @return float
     */
    public function transformToPHP($value)
    {
        return (float)$value;
    }
}